<?php

namespace App\Http\Controllers;

use App\Models\LotteryPool;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {        
        $pools = LotteryPool::with(['lotteryGame', 'accumulated', 'drawDay'])->latest()->get();
        return view('welcome', compact('pools'));
    }
}
