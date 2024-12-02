<?php

namespace App\Traits;

trait MapTrait
{
    function getAddressFromLatLong($latitude, $longitude)
    {
        // API key
        $apiKey = "AIzaSyCJk7ipLdFwUkJ8whIRLSNq2mgwqLZr7y8";

        // Function to make the API request
        function getFormattedAddress($latitude, $longitude, $apiKey, $language)
        {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey&language=$language";

            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL session
            $response = curl_exec($curl);

            // Close cURL session
            curl_close($curl);

            // Decode the response
            $responseData = json_decode($response, true);

            // Check if the response contains the 'results' key and it's not empty
            if (isset($responseData['results'][0])) {
                // Return the formatted address
                return $responseData['results'][0]['formatted_address'];
            } else {
                return null;
            }
        }

        // Get address in English
        $addressEn = getFormattedAddress($latitude, $longitude, $apiKey, 'en');

        // Get address in Arabic
        $addressAr = getFormattedAddress($latitude, $longitude, $apiKey, 'ar');

        // Return both addresses
        return [
            'en' => $addressEn ?? "Address not found",
            'ar' => $addressAr ?? "Address not found"
        ];
    }
}

