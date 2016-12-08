<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Hospital;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Validation rules for hospital model
     *
     * @var Array
     */
    public $rules = [
        'name' => 'required',
        'reg_no' => 'required',
        'contact_no' => 'required',
        'address' => 'required',
        'map_lat' => 'required',
        'map_lng' => 'required',
    ];
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'index', 'show'
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::all();

        return response()->json($hospitals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->donor)
            abort(403);

        $this->validate($request, $this->rules);

        $hospital = new Hospital;
        $hospital->avatar = 'default.png';
        $hospital->name = $request->name;
        $hospital->reg_no = $request->reg_no;
        $hospital->contact_no = $request->contact_no;
        $hospital->address = $request->address;
        $hospital->map_lat = $request->map_lat;
        $hospital->map_lng = $request->map_lng;
        $hospital->user_id = $request->user()->id;
        $hospital->save();

        return response()->json([
            'success' => true,
            'hospital' => $hopital
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hospital = Hospital::findOrFail($id);

        return response()->json($hospital);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $hospital = Hospital::find($id);
        $hospital->avatar = 'default.png';
        $hospital->name = $request->name;
        $hospital->reg_no = $request->reg_no;
        $hospital->contact_no = $request->contact_no;
        $hospital->address = $request->address;
        $hospital->map_lat = $request->map_lat;
        $hospital->map_lng = $request->map_lng;
        $hospital->save();

        return response()->json([
            'success' => true,
            'hospital' => $hopital
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
