<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LotteryGame;
use App\Models\LotteryDrawDay;
use App\Models\LotteryPool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotteryPoolTest extends TestCase
{
    use RefreshDatabase; // Reseta o banco de dados de teste a cada execução

    public function test_authenticated_user_can_view_lottery_pools_page()
    {
        // Cria e autentica um usuário
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('lottery-pools.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_create_a_lottery_pool()
    {
        $user = User::factory()->create();

        // Cria as dependências obrigatórias
        $game = LotteryGame::create(['name' => 'Mega-Sena', 'is_active' => true]);
        $drawDay = LotteryDrawDay::create([
            'lottery_game_id' => $game->id,
            'wednesday' => 1,
            'saturday' => 1,
        ]);

        // Dados simulados do formulário
        $poolData = [
            'lottery_game_id' => $game->id,
            'lottery_draw_day_id' => $drawDay->id,
            'draw_date' => '2026-11-10',
            'quota_value' => 50.00,
            'quota_quantity' => 10,
            'numbers_count' => 6,
            'whatsapp_link' => 'https://wa.me/5551999999999',
            'caixa_link' => 'https://loterias.caixa.gov.br',
        ];

        // Simula o envio do POST para salvar o bolão
        $response = $this->actingAs($user)->post(route('lottery-pools.store'), $poolData);

        // Verifica se redirecionou com sucesso (geralmente redirect back)
        $response->assertSessionHas('success');

        // Confirma que o dado foi gravado na tabela
        $this->assertDatabaseHas('lottery_pools', [
            'lottery_game_id' => $game->id,
            'quota_quantity' => 10,
        ]);
    }
}
