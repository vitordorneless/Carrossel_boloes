<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jogos da Loteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form de Cadastro -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Cadastrar Novo Jogo</h2>
                    </header>

                    <form action="{{ route('lottery-games.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Nome do Jogo" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <x-primary-button>{{ __('Salvar Jogo') }}</x-primary-button>
                    </form>
                </section>
            </div>

            <!-- Listagem -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Jogos Cadastrados</h2>
                    </header>

                    <table class="w-full mt-6 text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">ID</th>
                                <th class="py-2">Nome</th>
                                <th class="py-2 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($games as $game)
                                <tr class="border-b">
                                    <td class="py-2">{{ $game->id }}</td>
                                    <td class="py-2">{{ $game->name }}</td>
                                    <td class="py-2 text-right">
                                        <form action="{{ route('lottery-games.destroy', $game) }}" method="POST" class="inline" onsubmit="return confirm('Deseja excluir este jogo?')">
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
                                    <td colspan="3" class="py-4 text-center text-gray-500">Nenhum jogo cadastrado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>