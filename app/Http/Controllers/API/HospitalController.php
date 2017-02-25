<?php

namespace App\Http\Controllers\API;

use Auth;
use Validator;
use App\Hospital;
use App\Services\ImageStorageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    protected $imageStorageService;

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

    public function __construct(ImageStorageService $imageStorageService)
    {
        $this->middleware('auth:api', ['except' => [
            'index', 'show'
        ]]);

        $this->imageStorageService = $imageStorageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = Hospital::all();

        return response()->json([
            'count'     => count($hospitals),
            'hospitals' => $hospitals
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
        if (Auth::user()->donor || Auth::user()->hospital) {
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

        $hospital = new Hospital;

        if ($request->hasFile('avatar')) {
            $hospital->avatar = $this->imageStorageService->storeAvatar($request->file('avatar'));
        }

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
            'hospital' => $hospital
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
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ]);
        }

        $hospital = Hospital::find($id);

        if (Auth::user()->id !== $hospital->user->id)
            abort(403);

        if ($request->hasFile('avatar')) {
            $hospital->avatar = $this->imageStorageService->storeAvatar($request->file('avatar'));
        }

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
