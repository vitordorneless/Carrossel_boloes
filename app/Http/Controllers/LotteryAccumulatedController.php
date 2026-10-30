<?php

namespace App\Http\Controllers;

use App\Models\LotteryAccumulated;
use App\Models\LotteryGame;
use Illuminate\Http\Request;

class LotteryAccumulatedController extends Controller
{
    public function index()
    {
        $accumulateds = LotteryAccumulated::with('lotteryGame')->latest()->get();
        $games = LotteryGame::all(); // Todos os jogos disponíveis para cadastro/atualização

        return view('lottery-accumulateds.index', compact('accumulateds', 'games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lottery_game_id' => 'required|exists:lottery_games,id',
            'amount'          => 'required|numeric|min:0',
        ]);

        // Remove qualquer acumulado anterior deste jogo específico para manter apenas o atual
        LotteryAccumulated::where('lottery_game_id', $request->lottery_game_id)->delete();

        // Cria o novo acumulado atual
        LotteryAccumulated::create([
            'lottery_game_id' => $request->lottery_game_id,
            'amount'          => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Valor acumulado atualizado com sucesso!');
    }

    public function update(Request $request, LotteryAccumulated $lotteryAccumulated)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $lotteryAccumulated->update([
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with('success', 'Valor acumulado atualizado com sucesso!');
    }

    public function destroy(LotteryAccumulated $lotteryAccumulated)
    {
        $lotteryAccumulated->delete();
        return redirect()->back()->with('success', 'Acumulado removido com sucesso!');
    }
}
