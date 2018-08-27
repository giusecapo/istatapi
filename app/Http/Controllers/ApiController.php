<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function index(){
        return "Istat APIs v1.0";
    }

    public function countries(){
        $countries = \App\Country::all();
        return response()->json($countries);
    }

    public function country(Request $request, $code){
        $code = strtoupper($code);

        // If code is 2 chars, use sigla_iso_3166_1_alpha_2_stati
        // If code is 3 chars, use sigla_iso_3166_1_alpha_3_stati
        $country = null;
        if (strlen($code) == 2){
            $country = \App\Country::where('sigla_iso_3166_1_alpha_2_stati', $code)->first();            
        }
        if (strlen($code) == 3){
            $country = \App\Country::where('sigla_iso_3166_1_alpha_3_stati', $code)->first();            
        }

        return response()->json($country);
    }

    public function regions(){
        $regions = \App\Region::all();
        return response()->json($regions);
    }

    public function region(Request $request, $find, $provinces = false){
        $region = null;
        $provincesResponse = null;

        if (is_numeric($find)){
            $region = \App\Region::where('cod_istat', $find)->first();            
        } else {
            $find = strtolower($find);
            $region = \App\Region::where('nome', 'LIKE', '%'.$find.'%')->first();
        }

        if ($provinces){
            $provincesResponse = \App\Province::where('id_regione', $region->id)->get();  
            return response()->json($provincesResponse);            
        }

        return response()->json($region);
    }

    public function regionProvinces(Request $request, $find){
        $region = null;
        $provincesResponse = null;

        if (is_numeric($find)){
            $region = \App\Region::where('cod_istat', $find)->first();            
        } else {
            $find = strtolower($find);
            $region = \App\Region::where('nome', 'LIKE', '%'.$find.'%')->first();
        }
        
        if ($region){
            $provincesResponse = \App\Province::where('id_regione', $region->id)->get(); 
        } 
        return response()->json($provincesResponse);            
    }

    public function provinces(){
        $provinces = \App\Province::all();
        return response()->json($provinces);
    }

    public function province(Request $request, $find){
        $province = null;

        if (is_numeric($find)){
            $province = \App\Province::where('cod_istat', $find)->first();  
            if (!$province){
                $province = \App\Province::where('id', $find)->first();            
            }          
        } else {
            $find = strtolower($find);
            $province = \App\Province::where('sigla', 'LIKE', '%'.$find.'%')->first();
            if (!$province){
                $province = \App\Province::where('nome', 'LIKE', '%'.$find.'%')->first();
            }
        }

        return response()->json($province);
    }

    public function cities(){
        $cities = \App\City::all();
        return response()->json($cities);
    }

    public function city(Request $request, $find){
        $city = null;

        if (is_numeric($find)){
            $city = \App\Province::where('cod_istat', $find)->first();  
            if (!$city){
                $city = \App\Province::where('id', $find)->first();            
            }          
        } else {
            $find = strtolower($find);
            $city = \App\Province::where('nome', 'LIKE', '%'.$find.'%')->first();
        }

        return response()->json($city);
    }

    public function provinceCities(Request $request, $find){
        $province = null;
        $cities = null;

        if (is_numeric($find)){
            $province = \App\Province::where('cod_istat', $find)->first();  
            if (!$province){
                $province = \App\Province::where('id', $find)->first();            
            }          
        } else {
            $find = strtolower($find);
            $province = \App\Province::where('sigla', 'LIKE', '%'.$find.'%')->first();
            if (!$province){
                $province = \App\Province::where('nome', 'LIKE', '%'.$find.'%')->first();
            }
        }

        if ($province){
            $cities = \App\City::where('id_provincia', $province->id)->get();
        }

        return response()->json($cities);
    }
}