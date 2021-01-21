<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function requestJson1(Request $request)
    {
        return view('request');
    }

    public function requestJson2(Request $request)
    {
        $data = [
            'a' => $request->input('a'),
            'b' => $request->input('b'),
            'c' => $request->input('c')
        ];
        return $data;
    }
}
