<?php

namespace UniLibDemo\Controllers;

use UniLibDemo\Models\IceCream;

class IceCreamController {
    function index() 
    {
        $im = IceCream::I();
        return view('index', [
            'icecream' => $im->all() 
        ]);
    }
}