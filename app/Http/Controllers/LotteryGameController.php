<?php
namespace App\Http\Controllers;

use App\Models\LotteryGame;
use Illuminate\Http\Request;

class LotteryGameController extends Controller
{
    public function index()
    {
        $games = LotteryGame::latest()->get();
        return view('lottery-games.index', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:lottery_games,name',
        ]);

        LotteryGame::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Jogo cadastrado com sucesso!');
    }

    public function update(Request $request, LotteryGame $lotteryGame)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:lottery_games,name,' . $lotteryGame->id,
        ]);

        $lotteryGame->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Jogo atualizado com sucesso!');
    }

    public function destroy(LotteryGame $lotteryGame)
    {
        $lotteryGame->delete();
        return redirect()->back()->with('success', 'Jogo removido com sucesso!');
    }
}