<?php

namespace App\Http\Controllers;

use App\Models\daily_card;
use Illuminate\Http\Request;

class dailycard extends Controller
{
    public function index() {
        $today = (int) date('j');
        $dailyCard = daily_card::where('day', $today)->first();

        return view('customer.home', compact('dailyCard'));
    }

}
