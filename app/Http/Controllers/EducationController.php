<?php

namespace App\Http\Controllers;

use App\Education;
use App\Employee;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Yajra\Datatables\Datatables;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('educations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('educations.create');
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
            'name'           => 'required|string|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
        ]);

        $education = new Education();

        $education->name = $request->name;
        $education->save();
        return redirect()->route('educations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        return view('educations.edit', ['education' => $education]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        //
        $this->validate($request, [
            'name'           => 'required|string|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
        ]);

        $education->name = $request->name;
        $education->save();

        return redirect()->route('educations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        //
    }

    public function all_education_yajra()
    {
        $employee = Education::select([
            'id',
            'name',
        ]);

        if (Auth::guard('admin')->check()) :
            return Datatables::of(Education::query())
                ->addColumn('action', function ($education) {
                    return '<a href="educations/' . $education->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="' . route('educationss.delete', $education->id) . '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })
                ->make(true);
        else :
            return Datatables::of(Education::query())
                ->addColumn('action', function ($education) {
                    return '<a href="#" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-default"></i>Pinjam</a>';
                })
                ->make(true);
        endif;
    }

    public function deleteEducation(Education $education)
    {
        $used = Employee::whereEducation_id($education->id)->get();

        if (count($used) == 0) {
            Education::whereId($education->id)->delete();
            return redirect()->route('educations.index');
        }

        return redirect()->route('educations.index')->with('status', 'Cannot Delete Data, Data is being used in employee table');
    }
}
