<?php

namespace App\Http\Controllers;

use App\Models\LotteryPool;
use App\Models\LotteryGame;
use App\Models\LotteryDrawDay;
use App\Models\LotteryAccumulated;
use Illuminate\Http\Request;

class LotteryPoolController extends Controller
{
    public function index()
    {
        $pools = LotteryPool::with(['lotteryGame', 'drawDay', 'accumulated'])->latest()->get();

        // Dados auxiliares para popular os selects do formulário
        $games = LotteryGame::all();
        $drawDays = LotteryDrawDay::with('lotteryGame')->get();
        $accumulateds = LotteryAccumulated::with('lotteryGame')->get();

        return view('lottery-pools.index', compact('pools', 'games', 'drawDays', 'accumulateds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lottery_game_id'        => 'required|exists:lottery_games,id',
            'lottery_draw_day_id'    => 'required|exists:lottery_draw_days,id',
            'lottery_accumulated_id' => 'nullable|exists:lottery_accumulateds,id',
            'draw_date'              => 'required|date',
            'quota_value'            => 'required|numeric|min:0',
            'quota_quantity'         => 'required|integer|min:1',
            'numbers_count'          => 'required|integer|min:1',
            'whatsapp_link'          => 'required|url',
            'caixa_link'             => 'nullable|url',
        ]);

        LotteryPool::create($request->all());

        return redirect()->back()->with('success', 'Bolão cadastrado com sucesso!');
    }

    public function update(Request $request, LotteryPool $lotteryPool)
    {
        $request->validate([
            'lottery_game_id'        => 'required|exists:lottery_games,id',
            'lottery_draw_day_id'    => 'required|exists:lottery_draw_days,id',
            'lottery_accumulated_id' => 'nullable|exists:lottery_accumulateds,id',
            'draw_date'              => 'required|date',
            'quota_value'            => 'required|numeric|min:0',
            'quota_quantity'         => 'required|integer|min:1',
            'numbers_count'          => 'required|integer|min:1',
            'whatsapp_link'          => 'required|url',
            'caixa_link'             => 'nullable|url',
        ]);

        $lotteryPool->update($request->all());

        return redirect()->back()->with('success', 'Bolão atualizado com sucesso!');
    }

    public function destroy(LotteryPool $lotteryPool)
    {
        $lotteryPool->delete();
        return redirect()->back()->with('success', 'Bolão removido com sucesso!');
    }
}
