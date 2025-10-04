<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Meal;

class PublicController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::first();
        $featuredMeals = Meal::available()
            ->with('restaurant')
            ->take(6)
            ->get();

        return view('public.home', compact('restaurant', 'featuredMeals'));
    }
}