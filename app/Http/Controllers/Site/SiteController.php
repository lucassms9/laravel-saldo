<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    
    public function index()
    {
        # code...
        return view('site.home.index');
    }
}
