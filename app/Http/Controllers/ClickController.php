<?php

namespace App\Http\Controllers;

use App\Models\ClickCount;
use App\Models\LotteryPool;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function track(Request $request, $type)
    {
        if (in_array($type, ['whatsapp', 'loja_virtual'])) {
            ClickCount::create(['type' => $type]);
        }

        $targetUrl = $request->query('redirect');

        if ($targetUrl) {
            return redirect()->away($targetUrl);
        }

        return redirect()->back();
    }
}
