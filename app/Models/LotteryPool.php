<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryPool extends Model
{
    use HasFactory;

    protected $fillable = [
        'lottery_game_id',
        'lottery_draw_day_id',
        'lottery_accumulated_id',
        'draw_date',
        'quota_value',
        'quota_quantity',
        'numbers_count',
        'whatsapp_link',
        'caixa_link',
    ];

    public function lotteryGame()
    {
        return $this->belongsTo(LotteryGame::class);
    }

    public function drawDay()
    {
        return $this->belongsTo(LotteryDrawDay::class, 'lottery_draw_day_id');
    }

    public function accumulated()
    {
        return $this->belongsTo(LotteryAccumulated::class, 'lottery_accumulated_id');
    }
}
