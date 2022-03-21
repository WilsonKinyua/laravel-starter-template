<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inventory;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController
{
    public function index()
    {
        return view('home');
    }
}
