<?php

namespace App\Http\Controllers\Autos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auto;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $autos = Auto::where('user_id', $id)->get();
        return view('autos.registration.index', compact('autos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();
        $autos = Auto::where('user_id', $id)->get();
        return view('autos.registration.create', compact('autos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        $auto = Auto::create([
            'user_id' => $id,
            'owner_name' => $request->owner_name,
            'state_number' => $request->state_number,
            'color' => $request->color,
            'vin_code' => $request->vin_code,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year
        ]);
        $autos = Auto::where('user_id', $id)->get();
        $message = 'Авто успішно створене';

        return view('autos.registration.index', compact('message', 'autos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $auto = Auto::where('id', $id)->get()->first();
        //dd($auto->id);
        return view('autos.registration.edit', compact('auto'));
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
        //dd($request->all());
        $auto = Auto::whereId($id)->update([
            'user_id' => $id,
            'owner_name' => $request->owner_name,
            'state_number' => $request->state_number,
            'color' => $request->color,
            'vin_code' => $request->vin_code,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year
        ]);
        $id = Auth::id();
        $autos = Auto::where('user_id', $id)->get();
        $message = "Авто з ID = " . $id . " успішно оновлене";

        return view('autos.registration.index', compact('autos', 'message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auto = Auto::where('id', $id)->get()->first();
        $auto->delete();
        $user_id = Auth::id();
        $autos = Auto::where('user_id', $user_id)->get();
        $message = "Авто з ID = " . $id . " успішно видалене";

        return view('autos.registration.index', compact('autos', 'message'));
    }
}
