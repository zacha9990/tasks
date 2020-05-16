<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use App\Education;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Yajra\Datatables\Datatables;
use File;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'position'  => Position::all(),
            'education' => Education::all()
        );

        return view('employees.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'           => 'required|string|min:6|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
            'email'          => 'required|email||regex:/(^([a-zA-Z0-9\.\-\,\@\ ]+)(\d+)?$)/u',
            'date_of_birth'  => 'date|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
            'place_of_birth' => 'string',
            'phone'          => 'required|string|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'photo'          => 'image|mimes:jpeg,png,jpg|',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $employee = new Employee();

        $employee->name           = $request->name;
        $employee->password       = bcrypt('password');
        $employee->email          = $request->email;
        $employee->place_of_birth = $request->place_of_birth;
        $employee->date_of_birth  = $request->date_of_birth;
        $employee->address        = $request->address;
        $employee->phone          = $request->phone;
        $employee->sex            = $request->sex;
        $employee->position_id    = $request->position;
        $employee->education_id   = $request->education;

        if ($request->file('photo')) {
            $path = public_path() . '/images/employees/';

            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

            $file                 = $request->file('photo');
            $dt                   = Carbon::now();
            $acak                 = $file->getClientOriginalExtension();
            $filename             = rand(1111, 9999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;

            $request->file('photo')->move("images/employees/", $filename);
            $employee->photo = "images/employees/" . $filename;
        }

        $employee->save();
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        $data = array(
            'position'  => Position::all(),
            'education' => Education::all(),
            'employee' => $employee,
        );

        // dd($data);

        return view('employees.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $data = array(
            'position'  => Position::all(),
            'education' => Education::all(),
            'employee' => $employee,
        );

        // dd($data);

        return view('employees.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'name'                  => 'required|string|min:6|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
            'email'                 => 'required|email||regex:/(^([a-zA-Z0-9\.\-\,\@\ ]+)(\d+)?$)/u',
            'date_of_birth'         => 'date|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
            'place_of_birth'        => 'string',
            'phone'                 => 'required|string|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'photo'                 => 'image|mimes:jpeg,png,jpg|',
        ]);


        $employee->name           = $request->name;
        $employee->email          = $request->email;
        $employee->place_of_birth = $request->place_of_birth;
        $employee->date_of_birth  = $request->date_of_birth;
        $employee->address        = $request->address;
        $employee->phone          = $request->phone;
        $employee->sex            = $request->sex;
        $employee->position_id    = $request->position;
        $employee->education_id   = $request->education;

        if ($request->file('photo')) {
            $pic_path         = public_path() . $employee->photo;
            if (File::exists($pic_path)) {
                unlink($pic_path);
            }

            $path = public_path() . '/images/employees/';

            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

            $file                 = $request->file('photo');
            $dt                   = Carbon::now();
            $acak                 = $file->getClientOriginalExtension();
            $filename             = rand(1111, 9999) . '-' . $dt->format('Y-m-d-H-i-s') . '.' . $acak;

            $request->file('photo')->move("images/employees/", $filename);
            $employee->photo = "images/employees/" . $filename;
        }

        $employee->save();

        if (Auth::guard('employee')->check()) {
            $data = array(
                'position'  => Position::all(),
                'education' => Education::all(),
                'employee' => $employee,
            );

            return redirect()->back();
        }

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function deleteEmployee(Employee $employee)
    {
        $pic_path         = public_path() . $employee->photo;

        if (File::exists($pic_path)) {
            unlink($pic_path);
        }

        Employee::whereId($employee->id)->delete();

        return redirect()->route('employees.index');
    }

    public function all_employee_yajra()
    {
        $employee = Employee::select([
            'id',
            'name',
            'email',
            'photo',
            'place_of_birth',
            'date_of_birth',
            'address',
            'phone',
            'sex',
            'position_id',
            'education_id',
        ]);

        if (Auth::guard('admin')->check()) :
            return Datatables::of(Employee::query())
                ->addColumn('action', function ($employee) {
                    return '<a href="employees/' . $employee->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="' . route('employeess.delete', $employee->id) . '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })
                ->addColumn('photo_x', function ($employee) {
                    return '<img src="' . $employee->photo . '" width="50" height="50" />';
                })
                ->rawColumns(['photo_x', 'action'])

                ->editColumn('position_id', function (Employee $employee) {
                    return $employee->position->name;
                })
                ->editColumn('education_id', function (Employee $employee) {
                    return $employee->education->name;
                })

                ->make(true);
        else :
            return Datatables::of(Employee::query())
                ->addColumn('action', function ($employee) {
                    return '<a href="#" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-default"></i>Pinjam</a>';
                })
                ->editColumn('position_id', function (Employee $employee) {
                    return $employee->position->name;
                })
                ->editColumn('education_id', function (Employee $employee) {
                    return $employee->education->name;
                })
                ->make(true);
        endif;
    }
}
