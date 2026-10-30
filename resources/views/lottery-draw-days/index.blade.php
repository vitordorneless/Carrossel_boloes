<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dias de Sorteio dos Jogos') }}
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
                        <h2 class="text-lg font-medium text-gray-900">Vincular Dias de Sorteio</h2>
                    </header>

                    <form action="{{ route('lottery-draw-days.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
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

                        <!-- Checkboxes dos Dias da Semana -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="sunday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Domingo</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="monday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Segunda-feira</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="tuesday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Terça-feira</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="wednesday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Quarta-feira</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="thursday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Quinta-feira</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="friday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Sexta-feira</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="saturday" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="text-sm text-gray-700">Sábado</span>
                            </label>
                        </div>

                        <x-primary-button>{{ __('Salvar Dias') }}</x-primary-button>
                    </form>
                </section>
            </div>

            <!-- Listagem -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Jogos e Dias Configurados</h2>
                    </header>

                    <div class="overflow-x-auto">
                        <table class="w-full mt-6 text-left border-collapse">
                            <thead>
                                <tr class="border-b text-xs text-gray-500 uppercase">
                                    <th class="py-2">Jogo</th>
                                    <th class="py-2 text-center">Dom</th>
                                    <th class="py-2 text-center">Seg</th>
                                    <th class="py-2 text-center">Ter</th>
                                    <th class="py-2 text-center">Qua</th>
                                    <th class="py-2 text-center">Qui</th>
                                    <th class="py-2 text-center">Sex</th>
                                    <th class="py-2 text-center">Sáb</th>
                                    <th class="py-2 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($drawDays as $day)
                                <tr class="border-b">
                                    <td class="py-3 font-medium text-gray-900">{{ $day->lotteryGame->name ?? 'N/A' }}</td>
                                    <td class="py-3 text-center">{{ $day->sunday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->monday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->tuesday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->wednesday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->thursday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->friday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-center">{{ $day->saturday ? '✔️' : '-' }}</td>
                                    <td class="py-3 text-right">
                                        <form action="{{ route('lottery-draw-days.destroy', $day) }}" method="POST" class="inline" onsubmit="return confirm('Deseja excluir a configuração deste jogo?')">
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
                                    <td colspan="9" class="py-4 text-center text-gray-500">Nenhum dia de sorteio configurado ainda.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>