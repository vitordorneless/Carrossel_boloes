<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryDrawDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'lottery_game_id',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday'
    ];
    
    public function lotteryGame()
    {
        return $this->belongsTo(LotteryGame::class);
    }
}
