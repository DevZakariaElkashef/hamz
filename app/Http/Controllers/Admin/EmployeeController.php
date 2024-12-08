<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\Admin\EmployeeRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->middleware('can:hamz.employees.index')->only(['index']);
        $this->middleware('can:hamz.employees.create')->only(['create', 'store']);
        $this->middleware('can:hamz.employees.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.employees.delete')->only(['destroy']);
        $this->middleware('can:hamz.employees.export')->only(['export']);
        $this->middleware('can:hamz.employees.import')->only(['import']);

        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = $this->employeeRepository->index($request);
        $cities = $this->employeeRepository->cities();
        return view('employees.index', compact('employees', 'cities'));
    }

    public function search(Request $request)
    {
        $employees = $this->employeeRepository->search($request);
        return view('employees.table', compact('employees'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new EmployeeExport($request), 'employees.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('file'));

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
        $cities = $this->employeeRepository->cities();
        $roles = Role::whereNotIn('id', [1, 2, 3])->get();
        return view("employees.create", compact('cities', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $this->employeeRepository->store($request); // store employee
        return to_route('employees.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        $cities = $this->employeeRepository->cities();
        return view('employees.edit', compact('employee', 'cities'));
    }

    public function toggleStatus(Request $request, User $employee)
    {
        $employee->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, User $employee)
    {
        $this->employeeRepository->update($request, $employee);
        return to_route('employees.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $employee)
    {
        $this->employeeRepository->delete($employee);
        return to_route('employees.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->employeeRepository->deleteSelection($request);
        return to_route('employees.index')->with('success', __("main.delete_successffully"));
    }
}
