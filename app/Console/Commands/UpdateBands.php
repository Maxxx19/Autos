<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Brand;
use App\Models\ModelAuto;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class UpdateBands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_autos_brands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('model_autos');

        $response = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json');

        $brands = Arr::pluck($response['Results'], 'Make_ID');

        $models = [];
        $autos = array_chunk($brands, 10);
        foreach ($autos as $auto) {
            foreach ($auto as $key => $value) {
                $data = Http::get('https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeid/' . $value . '?format=json');
                $models += $data['Results'];
            }
            //dd($models);
        }
        $data = 0;
        foreach ($models as $model) {
            if ($model['Make_Name'] != $data) {
                $brand = Brand::create([
                    'name' => $model['Make_Name']
                ]);
                $data = $brand->name;
            }
            $model = ModelAuto::create([
                'name' => $model['Model_Name'],
                'brand_id' => $brand->id
            ]);
        }
        return 0;
    }
}