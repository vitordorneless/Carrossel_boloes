<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bolões da Lotérica Mel</title>

    <!-- Tailwind CSS & JS via Vite -->
    @php
    $useViteDev = file_exists(public_path('hot'));
    @endphp

    @if ($useViteDev)
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @php
    $manifestPath = public_path('build/manifest.json');
    $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
    $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
    $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp

    @if($cssFile)
    <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    @else
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    @endif

    @if($jsFile)
    <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
    @endif
    @endif
</head>

<body class="bg-white text-gray-900 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Topo -->
    <header class="border-b border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-black text-indigo-600 tracking-wider uppercase">Lotérica Mel</h1>

            @if (Route::has('login'))
            <nav class="space-x-4">
                @auth
                <!--<a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Dashboard</a>-->
                @else
                <!--<a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600">Entrar</a>-->
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
                    Bolões da Lotérica Mel - 017858
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
                    <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 16px; width: 100%;">
                        <!-- Botão WhatsApp -->
                        <a href="{{ route('click.track', ['type' => 'whatsapp', 'redirect' => $pool->whatsapp_link ?? $pool->link_whatsapp ?? '#']) }}"
                            target="_blank"
                            style="background-color: #25D366; color: #ffffff; font-weight: 700; padding: 10px 16px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; font-size: 14px;">
                            <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            <span>Reserve por aqui</span>
                        </a>

                        <!-- Botão Loja Virtual -->
                        <a href="{{ route('click.track', ['type' => 'loja_virtual', 'redirect' => $pool->caixa_link ?? $pool->link_loja ?? '#']) }}"
                            target="_blank"
                            style="background-color: #005CA9; color: #ffffff; font-weight: 700; padding: 10px 16px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; font-size: 14px;">
                            <svg style="width: 20px; height: 20px; fill: currentColor;" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                            </svg>
                            <span>Compre na nossa loja</span>
                        </a>
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