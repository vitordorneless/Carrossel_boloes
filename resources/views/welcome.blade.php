<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bolões da Lotérica Mel</title>

    <!-- Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Topo -->
    <header class="border-b border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-black text-indigo-600 tracking-wider uppercase">Lotérica Mel</h1>
            
            @if (Route::has('login'))
                <nav class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Entrar</a>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="py-12 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Título Principal -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                    Bolões da Lotérica Mel
                </h2>
                <p class="mt-3 text-lg text-gray-500">
                    Confira nossos bolões disponíveis, escolha sua sorte e participe!
                </p>
            </div>

            <!-- Carrossel em Cards -->
            @if($pools->count() > 0)
                <div class="flex overflow-x-auto space-x-6 pb-6 pt-2 snap-x snap-mandatory">
                    @foreach($pools as $pool)
                        <div class="flex-shrink-0 w-80 bg-white border border-gray-200 rounded-2xl shadow-lg p-6 flex flex-col justify-between snap-start hover:shadow-xl transition-shadow duration-300">
                            
                            <!-- Cabeçalho do Card -->
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-bold text-xs uppercase tracking-wider rounded-full">
                                        {{ $pool->lotteryGame->name ?? 'Loteria' }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-medium">
                                        Dezenas: {{ $pool->numbers_count }}
                                    </span>
                                </div>

                                <!-- Valor Acumulado -->
                                <div class="mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs uppercase tracking-wider text-gray-400 font-semibold">Acumulado Estimado</span>
                                    <span class="text-xl font-black text-emerald-600">
                                        @if($pool->accumulated)
                                            R$ {{ number_format($pool->accumulated->amount, 2, ',', '.') }}
                                        @else
                                            R$ 0,00
                                        @endif
                                    </span>
                                </div>

                                <!-- Detalhes do Sorteio e Cotas -->
                                <div class="space-y-2 text-sm text-gray-600 mb-6">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Data do Sorteio:</span>
                                        <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($pool->draw_date)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Valor da Cota:</span>
                                        <span class="font-bold text-indigo-600">R$ {{ number_format($pool->quota_value, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Cotas Disponíveis:</span>
                                        <span class="font-bold text-gray-900">{{ $pool->quota_quantity }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Rodapé do Card com Estilos Diretos nos Botões -->
                            <div class="space-y-3 pt-4 border-t border-gray-100">
                                <!-- Botão WhatsApp -->
                                <a href="{{ $pool->whatsapp_link }}" target="_blank" style="background-color: #25D366;" class="w-full flex items-center justify-center text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-opacity hover:opacity-90 shadow-sm">
                                    Reserve por aqui
                                </a>

                                <!-- Botão Loterias Caixa -->
                                @if($pool->caixa_link)
                                    <a href="{{ $pool->caixa_link }}" target="_blank" style="background-color: #0066B3;" class="w-full flex items-center justify-center text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-opacity hover:opacity-90 shadow-sm">
                                        Compre na nossa loja
                                    </a>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <p class="text-gray-500 text-lg">Nenhum bolão disponível no momento. Volte logo!</p>
                </div>
            @endif

        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} Lotérica Mel. Todos os direitos reservados.</p>
    </footer>

</body>
</html>