<?php

namespace App\Repositories\Earn;

use App\Models\Subscription;
use App\Traits\ImageUploadTrait;

class SubscriptionRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $subscriptions = Subscription::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->filter($request)->earn()->latest()->paginate($request->per_page ?? $this->limit);

        return $subscriptions;
    }


    public function search($request)
    {
        return Subscription::when($request->user()->role_id == 3, function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->search($request->search)->earn()->latest()->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'subscriptions');
        }
        unset($data['_token']);
        $data['app'] = 'earn';
        return Subscription::create($data);
    }


    public function update($request, $subscription)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'subscriptions', $subscription->image);
        }
        unset($data['_token'], $data['_method']);
        $subscription->update($data);
        return $subscription;
    }


    public function delete($subscription)
    {
        $subscription->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Subscription::whereIn('id', $ids)->delete();
        return true;
    }
}
