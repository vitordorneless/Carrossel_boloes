<?php

namespace App\Http\Controllers;

use App\Models\ClickCount;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $clickStats = ClickCount::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("SUM(CASE WHEN type = 'whatsapp' THEN 1 ELSE 0 END) as whatsapp_clicks"),
                DB::raw("SUM(CASE WHEN type = 'loja_virtual' THEN 1 ELSE 0 END) as loja_virtual_clicks"),
                DB::raw("COUNT(*) as total_clicks")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('dashboard', compact('clickStats'));
    }
}
