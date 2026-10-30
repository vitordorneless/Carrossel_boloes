<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valores Acumulados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 sm:px-8 space-y-6">

            @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <!-- Formulário de Cadastro / Atualização -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Definir Valor Acumulado Atual</h2>
                        <p class="mt-1 text-sm text-gray-600">Ao salvar um valor para um jogo que já possui acumulado, o anterior será substituído automaticamente.</p>
                    </header>

                    <form id="accumulatedForm" action="{{ route('lottery-accumulateds.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="lottery_game_id" value="Jogo da Loteria" />
                                <select id="lottery_game_id" name="lottery_game_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecione um jogo...</option>
                                    @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('lottery_game_id')" />
                            </div>

                            <div>
                                <x-input-label for="amount_masked" value="Valor Acumulado (R$)" />
                                <!-- Input HTML puro com classes do Tailwind idênticas ao Breeze, sem as setinhas -->
                                <input id="amount_masked" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="0,00" autocomplete="off" required />

                                <!-- Input oculto que envia o valor decimal limpo para o Laravel -->
                                <input type="hidden" id="amount" name="amount" />
                                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            </div>
                        </div>

                        <x-primary-button>{{ __('Salvar Acumulado') }}</x-primary-button>
                    </form>
                </section>
            </div>

            <!-- Listagem -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Acumulados Atuais</h2>
                    </header>

                    <div class="overflow-x-auto">
                        <table class="w-full mt-6 text-left border-collapse">
                            <thead>
                                <tr class="border-b text-xs text-gray-500 uppercase">
                                    <th class="py-2">Jogo</th>
                                    <th class="py-2">Valor Acumulado</th>
                                    <th class="py-2">Última Atualização</th>
                                    <th class="py-2 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($accumulateds as $item)
                                <tr class="border-b">
                                    <td class="py-3 font-medium text-gray-900">{{ $item->lotteryGame->name ?? 'N/A' }}</td>
                                    <td class="py-3 text-green-600 font-semibold">R$ {{ number_format($item->amount, 2, ',', '.') }}</td>
                                    <td class="py-3 text-gray-500">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 text-right">
                                        <form action="{{ route('lottery-accumulateds.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Deseja remover este acumulado?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Nenhum valor acumulado cadastrado no momento.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>

    <!-- Script da Máscara Monetária -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputMasked = document.getElementById('amount_masked');
            const inputReal = document.getElementById('amount');
            const form = document.getElementById('accumulatedForm');

            if (inputMasked) {
                inputMasked.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

                    if (value === '') {
                        inputMasked.value = '';
                        inputReal.value = '';
                        return;
                    }

                    // Converte para centavos e formata no padrão brasileiro
                    let numberValue = parseFloat(value) / 100;

                    inputMasked.value = numberValue.toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    // Guarda no input oculto o valor decimal puro (ex: 1500000.50)
                    inputReal.value = numberValue.toFixed(2);
                });
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!inputReal.value) {
                        e.preventDefault();
                        alert('Por favor, informe um valor acumulado válido.');
                    }
                });
            }
        });
    </script>
</x-app-layout>