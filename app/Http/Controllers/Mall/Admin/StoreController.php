<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\StoreRepository;
use App\Http\Requests\Mall\Web\StoreRequest;
use App\Models\Section;
use App\Models\User;

class StoreController extends Controller
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->index($request);
        return view('mall.stores.index', compact('stores'));
    }

    public function search(Request $request)
    {
        $stores = $this->storeRepository->search($request);
        return view('mall.stores.table', compact('stores'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        return view("mall.stores.create", compact('sections', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->storeRepository->store($request); // store store
        return to_route('mall.stores.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.stores.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        return view('mall.stores.edit', compact('store', 'sections', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Store $store)
    {
        $this->storeRepository->update($request, $store);
        return to_route('mall.stores.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $this->storeRepository->delete($store);
        return to_route('mall.stores.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->storeRepository->deleteSelection($request);
        return to_route('mall.stores.index')->with('success', __("mall.delete_successffully"));
    }
}
