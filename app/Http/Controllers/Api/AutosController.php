<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use App\Models\Brand;
use App\Models\ModelAuto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AutosController extends Controller
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
    protected function getAutos(Request $request)
    {

        $autos = 'Unavaible data';
        if ($request->has('limit')) {
            $autos = Auto::paginate($request->limit);
        }
        if ($request->has('orderBy')) {
            $autos = Auto::orderBy($request->orderBy)->paginate();
        }
        if ($request->has('search')) {
            $autos = Auto::where('owner_name', $request->search)->paginate();
            if (!isset($autos[0]->owner_name)) {
                $autos = Auto::where('state_number', $request->search)->paginate();
            }
            if (!isset($autos[0]->state_number)) {
                $autos = Auto::where('vin_code', $request->search)->paginate();
            }
        }

        if (
            isset($request->filter_brand) ||
            isset($request->filter_model) ||
            isset($request->filter_year)
        ) {
            if ($request->has('filter_brand')) {
                $autos_all = Auto::where('brand', $request->filter_brand)->paginate();
            }
            if ($request->has('filter_model')) {
                $autos_all = Auto::where('model', $request->filter_model)->paginate();
            }
            if ($request->has('filter_year')) {
                $autos_all = Auto::where('year', $request->filter_year)->paginate();
            }
            if (
                $request->has('filter_brand')
                && $request->has('filter_year')
            ) {
                $autos_all = Auto::where('brand', $request->filter_brand)
                    ->where('year', $request->filter_year)->paginate();
            }
            if (
                $request->has('filter_model')
                && $request->has('filter_year')
            ) {
                $autos_all = Auto::where('model', $request->filter_model)
                    ->where('year', $request->filter_year)->paginate();
            }
            if (
                $request->has('filter_brand')
                && $request->has('filter_model')
            ) {
                $autos_all = Auto::where('brand', $request->filter_brand)
                    ->where('model', $request->filter_model)->paginate();
            }
            if (
                $request->has('filter_brand')
                && $request->has('filter_year')
                && $request->has('filter_model')
            ) {
                $autos_all = Auto::where('brand', $request->filter_brand)
                    ->where('model', $request->filter_model)
                    ->where('year', $request->filter_year)->paginate();
            }
            if (isset($autos_all[0])) {
                $autos = $autos_all;
            } else {
                $autos = "No data available";
            }
        }

        return response()->json($autos);
    }
    protected function editAuto(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'owner_name' => 'required|string|min: 3|max: 30',
            'state_number' => 'required|string|min: 8|max: 8',
            'color' => 'required| min:3|max: 11',
            'vin_code' => 'required|string|min: 17|max: 17'
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
        $auto = Auto::where('vin_code', $request->vin_code)->get()->first();
        if (isset($auto->vin_code)) {
            $auto->update([
                'owner_name' => $request->owner_name,
                'state_number' => $request->state_number,
                'color' => $request->color,
                'vin_code' => $request->vin_code,
                'brand' => $brand,
                'model' => $model,
                'year' => $year
            ]);
        } else {
            return response()->json(['error' => 'Auto does not exist']);
        }

        return response()->json(['success' => 'Auto created']);
    }

    protected function deleteAuto(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'vin_code' => 'required|string|min: 17|max: 17'
        ]);
        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/' . $request->vin_code . '?format=json');
            if (isset($response['Results'][8]['Value']) == null) {
                return response()->json(['error' => 'Wrong VIN code!'], 401);
            }
        }
        $auto = Auto::where('vin_code', $request->vin_code)->get()->first();
        if (isset($auto->vin_code)) {
            $auto->delete();
        } else {
            return response()->json(['error' => 'Auto does not exist']);
        }

        return response()->json(['success' => 'Auto successfully deleted']);
    }

    protected function brandList(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'brand' => 'required|string|min: 3|max: 20'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $brand = Brand::where('name', $request->brand)->get()->first();
            if (isset($brand->name)) {
                $model_auto = ModelAuto::where('brand_id', $brand->id)->get();
                return response()->json(['success' => 'Brand exists', 'brand' => $brand->name, 'model_auto' => $model_auto]);
            } else {
                return response()->json(['error' => 'Brand does not exist'], 401);
            }
        }
    }
}
