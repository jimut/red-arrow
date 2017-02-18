<?php

namespace App\Http\Controllers;

use Auth;
use App\Hospital;
use Illuminate\Http\Request;
use App\Services\ImageStorageService;

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
        'contact_no' => 'required|digits:10',
        'address' => 'required',
        'map_lat' => 'required',
        'map_lng' => 'required',
    ];

    public function __construct(ImageStorageService $imageStorageService)
    {
        $this->middleware('auth', ['except' => [
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->donor && Auth::user()->hospital)
            abort(403);

        return view('hospital.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->donor && Auth::user()->hospital)
            abort(403);

        $this->validate($request, $this->rules);

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

        return redirect()->route('hospital.show', [$hospital]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hospital = Hospital::find($id);

        return view('hospital.show', [
            'hospital' => $hospital
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hospital = Hospital::find($id);

        if (Auth::user()->id !== $hospital->user->id)
            abort(403);

        return view('hospital.edit', [
            'hospital' => $hospital
        ]);
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

        return redirect()->route('hospital.show', [$hospital]);
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
