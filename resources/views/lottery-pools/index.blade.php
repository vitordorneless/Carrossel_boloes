<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciamento de Bolões') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <!-- Formulário de Cadastro -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Cadastrar Novo Bolão</h2>
                    </header>

                    <form id="poolForm" action="{{ route('lottery-pools.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                            <!-- Jogo -->
                            <div>
                                <x-input-label for="lottery_game_id" value="Jogo da Loteria" />
                                <select id="lottery_game_id" name="lottery_game_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecione...</option>
                                    @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('lottery_game_id')" />
                            </div>

                            <!-- Dia que corre -->
                            <div>
                                <x-input-label for="lottery_draw_day_id" value="Configuração de Dias" />
                                <select id="lottery_draw_day_id" name="lottery_draw_day_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecione...</option>
                                    @foreach($drawDays as $day)
                                    <option value="{{ $day->id }}">{{ $day->lotteryGame->name ?? 'Jogo' }} (Dias config)</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('lottery_draw_day_id')" />
                            </div>

                            <!-- Acumulado -->
                            <div>
                                <x-input-label for="lottery_accumulated_id" value="Valor Acumulado (Opcional)" />
                                <select id="lottery_accumulated_id" name="lottery_accumulated_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Nenhum / Selecione...</option>
                                    @foreach($accumulateds as $acc)
                                    <option value="{{ $acc->id }}">{{ $acc->lotteryGame->name ?? '' }} - R$ {{ number_format($acc->amount, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('lottery_accumulated_id')" />
                            </div>

                            <!-- Data do Sorteio -->
                            <div>
                                <x-input-label for="draw_date" value="Data do Sorteio" />
                                <input id="draw_date" name="draw_date" type="date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('draw_date')" />
                            </div>

                            <!-- Valor da Cota (Com máscara monetária) -->
                            <div>
                                <x-input-label for="quota_value_masked" value="Valor da Cota (R$)" />
                                <input id="quota_value_masked" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="0,00" autocomplete="off" required />
                                <input type="hidden" id="quota_value" name="quota_value" />
                                <x-input-error class="mt-2" :messages="$errors->get('quota_value')" />
                            </div>

                            <!-- Quantidade de Cotas -->
                            <div>
                                <x-input-label for="quota_quantity" value="Quantidade de Cotas" />
                                <input id="quota_quantity" name="quota_quantity" type="number" min="1" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('quota_quantity')" />
                            </div>

                            <!-- Número de Dezenas -->
                            <div>
                                <x-input-label for="numbers_count" value="Número de Dezenas" />
                                <input id="numbers_count" name="numbers_count" type="number" min="1" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('numbers_count')" />
                            </div>

                            <!-- Link do WhatsApp -->
                            <div>
                                <x-input-label for="whatsapp_link" value="Link do WhatsApp" />
                                <input id="whatsapp_link" name="whatsapp_link" type="url" placeholder="https://wa.me/..." class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('whatsapp_link')" />
                            </div>

                            <!-- Link do Loterias Caixa -->
                            <div>
                                <x-input-label for="caixa_link" value="Link Loterias Caixa (Opcional)" />
                                <input id="caixa_link" name="caixa_link" type="url" placeholder="https://loterias.caixa.gov.br/..." class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                <x-input-error class="mt-2" :messages="$errors->get('caixa_link')" />
                            </div>

                        </div>

                        <div class="pt-4">
                            <x-primary-button>{{ __('Salvar Bolão') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>

            <!-- Listagem de Bolões -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Bolões Cadastrados</h2>
                    </header>

                    <div class="overflow-x-auto">
                        <table class="w-full mt-6 text-left border-collapse">
                            <thead>
                                <tr class="border-b text-xs text-gray-500 uppercase">
                                    <th class="py-2">Jogo</th>
                                    <th class="py-2">Data Sorteio</th>
                                    <th class="py-2">Cota</th>
                                    <th class="py-2">Cotas Disp.</th>
                                    <th class="py-2">Dezenas</th>
                                    <th class="py-2">Acumulado</th>
                                    <th class="py-2 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($pools as $pool)
                                <tr class="border-b">
                                    <td class="py-3 font-medium text-gray-900">{{ $pool->lotteryGame->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ \Carbon\Carbon::parse($pool->draw_date)->format('d/m/Y') }}</td>
                                    <td class="py-3 text-green-600 font-semibold">R$ {{ number_format($pool->quota_value, 2, ',', '.') }}</td>
                                    <td class="py-3">{{ $pool->quota_quantity }}</td>
                                    <td class="py-3">{{ $pool->numbers_count }}</td>
                                    <td class="py-3">
                                        @if($pool->accumulated)
                                        R$ {{ number_format($pool->accumulated->amount, 2, ',', '.') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="py-3 text-right space-x-2">
                                        <a href="{{ $pool->whatsapp_link }}" target="_blank" class="text-green-600 hover:text-green-900 font-semibold text-xs">WhatsApp</a>
                                        @if($pool->caixa_link)
                                        <a href="{{ $pool->caixa_link }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-semibold text-xs">Caixa</a>
                                        @endif
                                        <form action="{{ route('lottery-pools.destroy', $pool) }}" method="POST" class="inline" onsubmit="return confirm('Deseja excluir este bolão?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-gray-500">Nenhum bolão cadastrado no momento.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>

    <!-- Script da Máscara Monetária para o Valor da Cota -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputMasked = document.getElementById('quota_value_masked');
            const inputReal = document.getElementById('quota_value');

            if (inputMasked) {
                inputMasked.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');

                    if (value === '') {
                        inputMasked.value = '';
                        inputReal.value = '';
                        return;
                    }

                    let numberValue = parseFloat(value) / 100;

                    inputMasked.value = numberValue.toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    inputReal.value = numberValue.toFixed(2);
                });
            }
        });
    </script>
</x-app-layout>