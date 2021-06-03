<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('frontend.companies');
    }

    public function show()
    {
        return view('frontend.company');
    }
}
