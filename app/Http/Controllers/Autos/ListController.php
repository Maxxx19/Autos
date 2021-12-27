<?php

namespace App\Http\Controllers\Autos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auto;

class ListController extends Controller
{
    public function index()
    {

        return view('autos.list.index');
    }
    public function autosDB(Request $request)
    {
        if ($request->ajax()) {

            return datatables()->of(
                Auto::all()
            )
                ->make(true);
        }
    }
}
