<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryGame extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    public function drawDays()
{
    return $this->hasOne(LotteryDrawDay::class);
}
}
