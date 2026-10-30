<?php

namespace App\Http\Controllers;

use App\Models\LotteryDrawDay;
use App\Models\LotteryGame;
use Illuminate\Http\Request;

class LotteryDrawDayController extends Controller
{
    public function index()
    {
        $drawDays = LotteryDrawDay::with('lotteryGame')->latest()->get();
        // Trazemos também os jogos que ainda não têm dias cadastrados para o select
        $games = LotteryGame::whereDoesntHave('drawDays')->get();

        return view('lottery-draw-days.index', compact('drawDays', 'games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lottery_game_id' => 'required|exists:lottery_games,id|unique:lottery_draw_days,lottery_game_id',
        ]);

        LotteryDrawDay::create([
            'lottery_game_id' => $request->lottery_game_id,
            'sunday'    => $request->has('sunday') ? 1 : 0,
            'monday'    => $request->has('monday') ? 1 : 0,
            'tuesday'   => $request->has('tuesday') ? 1 : 0,
            'wednesday' => $request->has('wednesday') ? 1 : 0,
            'thursday'  => $request->has('thursday') ? 1 : 0,
            'friday'    => $request->has('friday') ? 1 : 0,
            'saturday'  => $request->has('saturday') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Dias de sorteio cadastrados com sucesso!');
    }

    public function update(Request $request, LotteryDrawDay $lotteryDrawDay)
    {
        $lotteryDrawDay->update([
            'sunday'    => $request->has('sunday') ? 1 : 0,
            'monday'    => $request->has('monday') ? 1 : 0,
            'tuesday'   => $request->has('tuesday') ? 1 : 0,
            'wednesday' => $request->has('wednesday') ? 1 : 0,
            'thursday'  => $request->has('thursday') ? 1 : 0,
            'friday'    => $request->has('friday') ? 1 : 0,
            'saturday'  => $request->has('saturday') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Dias de sorteio atualizados com sucesso!');
    }

    public function destroy(LotteryDrawDay $lotteryDrawDay)
    {
        $lotteryDrawDay->delete();
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }
}
