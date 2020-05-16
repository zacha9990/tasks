<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Position;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Yajra\Datatables\Datatables;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.create');
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
            'name'           => 'required|string|min:4|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
        ]);

        $position = new Position();

        $position->name = $request->name;
        $position->save();
        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
        return view('positions.edit', ['position' => $position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //
        $this->validate($request, [
            'name'           => 'required|string|min:4|regex:/(^([a-zA-Z0-9\.\-\,\ ]+)(\d+)?$)/u',
        ]);

        $position->name = $request->name;
        $position->save();

        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
    }

    public function all_position_yajra()
    {
        $employee = Position::select([
            'id',
            'name',
        ]);

        if (Auth::guard('admin')->check()) :
            return Datatables::of(Position::query())
                ->addColumn('action', function ($position) {
                    return '<a href="positions/' . $position->id . '/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="' . route('educationss.delete', $position->id) . '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })
                ->make(true);
        else :
            return Datatables::of(Position::query())
                ->addColumn('action', function ($position) {
                    return '<a href="#" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-default"></i>Pinjam</a>';
                })
                ->make(true);
        endif;
    }

    public function deletePosition(Position $position)
    {
        $used = Employee::wherePosition_id($position->id)->get();

        if (count($used) == 0) {
            Position::whereId($position->id)->delete();
            return redirect()->route('positions.index');
        }

        return redirect()->route('positions.index')->with('status', 'Cannot Delete Data, Data is being used in employee table');
    }
}
