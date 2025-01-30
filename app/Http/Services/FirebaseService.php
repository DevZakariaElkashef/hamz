<?php

namespace App\Http\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    private $url = 'https://fcm.googleapis.com/v1/projects/hamz-52a65/messages:send';
    private $scope = 'https://www.googleapis.com/auth/firebase.messaging';
    private $token;

    public function __construct()
    {
        $credentialsPath = storage_path('app/firebase.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Firebase credentials file not found.');
        }

        $credentials = new ServiceAccountCredentials($this->scope, $credentialsPath);
        $this->token = $credentials->fetchAuthToken(HttpHandlerFactory::build());
    }

    /*----------------------------------------------------------------------------------------------------*/

    private function convertArrayValuesToString(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->convertArrayValuesToString($value);
            } else if ($value && !is_object($value)) {
                $value = (string)$value;
            }
        }

        return $array;
    }

    /*----------------------------------------------------------------------------------------------------*/

    private function sendRequest($payload)
    {
        $headers = [
            'Authorization: Bearer ' . $this->token['access_token'],
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($httpCode >= 400) {
            Log::error('Firebase notification failed', [
                'http_code' => $httpCode,
                'response' => $response,
                'error' => $error,
                'payload' => $payload,
            ]);
        }
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function notify($title, $body, $devicesTokens, $additionalData = null)
    {
        if ($additionalData) {
            $this->convertArrayValuesToString($additionalData);
        }

        foreach ($devicesTokens as $token) {
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => $additionalData,
                    'android' => [
                        'notification' => [
                            'notificationCount' => 1,
                            'channel_id' => 'default_notification_channel',
                            'sound' => 'sound.mp3',
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'alert' => [
                                    'title' => $title,
                                    'body' => $body,
                                ],
                                'sound' => 'sound.mp3',
                            ],
                        ],
                    ],
                ],
            ];

            $this->sendRequest($payload);
        }
    }
}
