<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class CreateAutoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createAuto(Request $request)
    {
        //{"owner_name": "Bill","state_number": "FD4515DF", "color":"white","vin_code":"3FA6P0VP1HR282209"}
        $data = $request->all();
        $validator = Validator::make($data, [
            'owner_name' => 'required|string|min: 3|max: 30',
            'state_number' => 'required|string|min: 8|max: 8',
            'color' => 'required| min:3|max: 11',
            'vin_code' => 'required|string|unique:autos|min: 17|max: 17'
        ]);
        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/' . $request->vin_code . '?format=json');
            if (isset($response['Results'][8]['Value']) == null) {
                return response()->json(['error' => 'Wrong VIN code!'], 401);
            } else {
                $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/' . $request->vin_code . '?format=json');
                $brand = $response['Results'][6]['Value'];
                $model = $response['Results'][8]['Value'];
                $year = $response['Results'][9]['Value'];
            }
        }
        $auto = Auto::create([
            'owner_name' => $request->owner_name,
            'state_number' => $request->state_number,
            'color' => $request->color,
            'vin_code' => $request->vin_code,
            'brand' => $brand,
            'model' => $model,
            'year' => $year
        ]);

        return response()->json(['success' => 'Auto updated']);
    }
}
