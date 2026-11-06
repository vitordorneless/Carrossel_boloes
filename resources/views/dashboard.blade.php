<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-4">Relatório de Cliques por Mês</h3>

            <table class="min-w-full divide-y divide-gray-200 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mês / Ano</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Loja Virtual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clickStats as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->locale('pt_BR')->translatedFormat('F / Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">
                            {{ $stat->whatsapp_clicks }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-semibold">
                            {{ $stat->loja_virtual_clicks }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-bold">
                            {{ $stat->total_clicks }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum clique registrado ainda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>