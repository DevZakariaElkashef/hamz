<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earn\Web\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\Video;
use App\Repositories\Earn\SubscriptionRepository;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;

        // autherization
        $this->middleware('can:earn.subscriptions.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subscriptions = $this->subscriptionRepository->index($request);
        $used = Video::where('user_id', auth()->id())->count();

        return view('earn.subscriptions.index', compact('subscriptions', 'used'));
    }

    public function search(Request $request)
    {
        $subscriptions = $this->subscriptionRepository->search($request);
        $used = Video::where('user_id', auth()->id())->count();

        return view('earn.subscriptions.table', compact('subscriptions', 'used'))->render();
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
        if (auth()->user()->role_id != '3') {
            $subscription->update(['status' => $request->status]);
            return response()->json([
                'success' => true,
                'message' => __("main.updated_successffully"),
            ]);
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        if (auth()->user()->role_id != '3') {
            $this->subscriptionRepository->delete($subscription);
            return to_route('earn.subscriptions.index')->with('success', __("main.delete_successffully"));
        }

        return to_route('earn.subscriptions.index');
    }

    public function delete(Request $request)
    {
        if (auth()->user()->role_id != '3') {
            $this->subscriptionRepository->deleteSelection($request);
            return to_route('earn.subscriptions.index')->with('success', __("main.delete_successffully"));
        }

        return to_route('earn.subscriptions.index');
    }
}
