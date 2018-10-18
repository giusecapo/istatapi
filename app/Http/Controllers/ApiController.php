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
        $countries = \App\Country::orderBy('nome')->get();
        return $this->formatJSON($countries);     
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

        return $this->formatJSON($country);
    }

    public function regions(){
        $regions = \App\Region::orderBy('nome')->get();
        return $this->formatJSON($regions);
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

        return $this->formatJSON($region);
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

        return $this->formatJSON($provincesResponse);
    }

    public function provinces(){
        $provinces = \App\Province::orderBy('nome')->get();
        return $this->formatJSON($provinces);
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

        return $this->formatJSON($province);
    }

    public function cities(){
        $cities = \App\City::orderBy('nome')->get();
        return $this->formatJSON($cities);
    }

    public function city(Request $request, $find){
        $city = null;

        if (is_numeric($find)){
            $city = \App\City::where('cod_istat', $find)->first();  
            if (!$city){
                $city = \App\City::where('id', $find)->first();            
            }          
        } else {
            $find = strtolower($find);
            $city = \App\City::where('nome', 'LIKE', '%'.$find.'%')->first();
        }

        return $this->formatJSON($city);
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
            $find = urldecode($find);

            $province = \App\Province::where('sigla', 'LIKE', '%'.$find.'%')->first();
            if (!$province){
                $province = \App\Province::where('nome', 'LIKE', '%'.$find.'%')->first();
            }
        }

        if ($province){
            $cities = \App\City::where('id_provincia', $province->id)->orderBy('nome')->get();
        }

        return $this->formatJSON($cities);
    }

    function formatJSON($json){
        $responsecode = 200;
        
        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8',
                'Access-Control-Allow-Origin' => '*' 
            );
        
        return response()->json($json , $responsecode, $header, JSON_UNESCAPED_UNICODE);
    }
}