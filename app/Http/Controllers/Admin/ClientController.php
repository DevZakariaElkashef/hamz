<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\ClientExport;
use App\Imports\ClientImport;
use App\Models\User as Client;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ClientRepository;
use App\Http\Requests\Admin\ClientRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class ClientController extends Controller
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->middleware('can:hamz.users.index')->only(['index']);
        $this->middleware('can:hamz.users.create')->only(['create', 'store']);
        $this->middleware('can:hamz.users.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.users.delete')->only(['destroy']);

        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = $this->clientRepository->index($request);
        $cities = $this->clientRepository->cities();
        return view('clients.index', compact('clients', 'cities'));
    }

    public function search(Request $request)
    {
        $clients = $this->clientRepository->search($request);
        return view('clients.table', compact('clients'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new ClientExport($request), 'clients.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ClientImport, $request->file('file'));

            return back()->with('success', __("main.created_successfully"));
        } catch (ValidationException $e) {
            // Get the first failure from the exception
            $failure = $e->failures()[0];

            // Format the error message for the first failed row
            $errorMessage = "Row {$failure->row()}: " . implode(', ', $failure->errors());

            // Flash the error message to the session
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Handle any other exceptions that might occur
            return back()->with('error', __("An unexpected error occurred: " . $e->getMessage()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = $this->clientRepository->cities();
        return view("clients.create", compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $this->clientRepository->store($request); // store client
        return to_route('clients.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('clients.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $cities = $this->clientRepository->cities();
        return view('clients.edit', compact('client', 'cities'));
    }

    public function toggleStatus(Request $request, Client $client)
    {
        $client->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $this->clientRepository->update($request, $client);
        return to_route('clients.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->clientRepository->delete($client);
        return to_route('clients.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->clientRepository->deleteSelection($request);
        return to_route('clients.index')->with('success', __("main.delete_successffully"));
    }
}
