<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;

class MenuController extends Controller
{
    public function index()
    {
        $meals = Meal::available()
            ->with('restaurant')
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('public.menu', compact('meals'));
    }
}