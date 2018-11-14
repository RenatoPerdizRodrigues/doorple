<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Config;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function getIndex(){
        $config = Config::select('configured')->get();
        if (empty($config[0])){
            return view('admin.config');
        }
        return view('admin.dashboard')->withConfig($config);
    }
}
