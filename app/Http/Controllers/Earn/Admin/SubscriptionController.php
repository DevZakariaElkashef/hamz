<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Earn\SubscriptionRepository;
use App\Http\Requests\Earn\Web\SubscriptionRequest;

class SubscriptionController extends Controller
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subscriptions = $this->subscriptionRepository->index($request);
        return view('earn.subscriptions.index', compact('subscriptions'));
    }

    public function search(Request $request)
    {
        $subscriptions = $this->subscriptionRepository->search($request);
        return view('earn.subscriptions.table', compact('subscriptions'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("earn.subscriptions.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        $this->subscriptionRepository->store($request); // store subscription
        return to_route('earn.subscriptions.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.subscriptions.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        return view('earn.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, Subscription $subscription)
    {
        $this->subscriptionRepository->update($request, $subscription);
        return to_route('earn.subscriptions.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Subscription $subscription)
    {
        $subscription->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        $this->subscriptionRepository->delete($subscription);
        return to_route('earn.subscriptions.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->subscriptionRepository->deleteSelection($request);
        return to_route('earn.subscriptions.index')->with('success', __("main.delete_successffully"));
    }
}
