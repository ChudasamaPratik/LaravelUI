<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Employee::all();
        return view('home', compact('data'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:employees,name',
            'mobile' => 'required|numeric'
        ]);
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        $employee->save();
        return response()->json(['message' => 'Done', 'employee' => $employee]);
    }

    public function edit($id)
    {
        $data = Employee::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        $validation = $request->validate([
            'name' => 'required|unique:employees,name',
            'mobile' => 'required|numeric'
        ]);

        $employee->name = $request->name;
        $employee->mobile = $request->mobile;
        $employee->update();

        return response()->json(['message' => 'Done', 'employee' => $employee]);
    }
}
