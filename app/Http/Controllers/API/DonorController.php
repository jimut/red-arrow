<?php

namespace App\Http\Controllers\API;

use Auth;
use Validator;
use App\Donor;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
    * Validation rules for hospital model
    *
    * @var Array
    */
    public $rules = [
        'name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'map_lat' => 'required',
        'map_lng' => 'required',
        'contact_no' => 'required',
        'blood_type' => 'required',
    ];

    public function __construct(){
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
        $donors = Donor::all();

        return response()->json([
            'count'  => count($donors),
            'donors' => $donors
        ]);
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
        if ($request->user()->hospital) {
            return response()->json([
                'success' => false
            ]);
        }

        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ]);
        }

        $donor = new Donor;
        $donor->avatar = 'default.png';
        $donor->name = $request->name;
        $donor->dob = $request->dob;
        $donor->address = $request->address;
        $donor->map_lat = $request->map_lat;
        $donor->map_lng = $request->map_lng;
        $donor->contact_no = $request->contact_no;
        $donor->blood_type = $request->blood_type;
        $donor->health_issues = $request->health_issues;
        $donor->user_id = $request->user()->id;
        $donor->save();

        return response()->json([
            'success' => true,
            'donor' => $donor
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
        $donor = Donor::findOrFail($id);

        return response()->json($donor);
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
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ]);
        }

        $donor = Donor::find($id);
        $donor->avatar = 'default.png';
        $donor->name = $request->name;
        $donor->dob = $request->dob;
        $donor->address = $request->address;
        $donor->map_lat = $request->map_lat;
        $donor->map_lng = $request->map_lng;
        $donor->contact_no = $request->contact_no;
        $donor->blood_type = $request->blood_type;
        $donor->health_issues = $request->health_issues;
        $donor->save();

        return response()->json([
            'success' => true,
            'donor' => $donor
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

    /**
     * Show notifications of current user
     *
     * @return \Illuminate\Http\Response
     */
    public function showNotification(Request $request)
    {
        $user = $request->user();

        if (!$user->donor) {
            return response()->json([
                'success' => false
            ]);
        }

        $appointments = $user->donor->appointments;
        $newNotifications = [];
        foreach ($appointments as $appointment) {
            if ($appointment->status === 'SENT') {
                $appointment->donor;
                $appointment->hospital;
                $newNotifications[] = $appointment;
            }
        }

        return response()->json([
            'newNotifications' => $newNotifications,
            'donor' => $user->donor
        ]);
    }
}
