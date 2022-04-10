<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ch = curl_init();
        $url = "https://openexchangerates.org/api/currencies.json";

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $resp = curl_exec($ch);
        if($e = curl_error($ch)){
            echo $e;
        }
        else{
            $obj = json_decode($resp);
                foreach ($obj as $key => $value) {
                    $currency = New Currency();
                    $currency -> short_name = $key;
                    $currency ->country = $value;

                    echo $currency;
                    if ($currency->save())
                    {

                    }
                }
            return new ProductResource($currency);
        }
        curl_close($ch);
    }
}
