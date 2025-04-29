@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">{{ $user->name }} statisztikái</h1>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div
                class="bg-neutral-200 dark:bg-neutral-700 p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Egyenleg</h2>
                <p class="text-2xl font-bold">{{ $user->balance }} $</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Összes Játék</h2>
                <p class="text-2xl font-bold">{{ $user->gameStat->total_games_played }}</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Győzelmek</h2>
                <p class="text-2xl font-bold">{{ $user->gameStat->total_wins }}</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Vereségek</h2>
                <p class="text-2xl font-bold">{{ $user->gameStat->total_losses }}</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Összes Nyeremény</h2>
                <p class="text-2xl font-bold">{{ $user->gameStat->total_winnings }} $</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Összes Veszteség</h2>
                <p class="text-2xl font-bold">{{ $user->gameStat->total_losses_amount }} $</p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Nettó Profit</h2>
                <p
                    class="text-2xl font-bold {{ $user->gameStat->total_winnings - $user->gameStat->total_losses_amount >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ $user->gameStat->total_winnings - $user->gameStat->total_losses_amount }} $
                </p>
            </div>

            <div
                class="bg-neutral-200 dark:bg-neutral-700 dark:text-white p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300">
                <h2 class="text-lg font-semibold">Utolsó Játék</h2>
                <p class="text-xl font-bold">{{ $user->gameStat->last_played_at }}</p>
            </div>
        </div>

        <!-- Játék statisztikák és kördiagramok -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            @if (!empty($user->gameStat->game_statistics) && is_array($user->gameStat->game_statistics))
                @foreach ($user->gameStat->game_statistics as $game => $stats)
                    <div
                        class="bg-neutral-200 dark:bg-neutral-700 p-4 rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 hover:dark:bg-neutral-800 hover:bg-neutral-300 mb-6">
                        <h2 class="text-lg font-semibold text-center">{{ ucfirst($game) }}</h2>

                        <div class="chart-container">
                            <canvas id="chart-{{ Str::slug($game, '_') }}"></canvas>
                        </div>

                        <p class="text-center mt-2">
                            <span class="text-green-400 font-bold">{{ $stats['wins'] }}</span> Win |
                            <span class="text-red-400 font-bold">{{ $stats['losses'] }}</span> Loss
                        </p>
                    </div>
                @endforeach
            @else
                <div class="flex justify-center col-span-2 md:col-span-4">
                    <div
                        class="bg-yellow-500 dark:bg-yellow-600 text-white text-center p-4 rounded-lg shadow-md w-full md:w-1/2 transition-all duration-300 transform hover:scale-105">
                        <p class="text-lg font-semibold">Még nem játszottál egyetlen játékot sem!</p>
                        <p class="text-sm">Kezdj el játszani, hogy itt megjelenjenek a statisztikáid.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            /* Ezzel biztosítod, hogy kitöltse a rendelkezésre álló teret */
            max-width: 300px;
            /* Ne legyen túl nagy */
            height: auto;
            margin: auto;
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let gameStatistics = @json($user->gameStat->game_statistics);

            if (!gameStatistics || Object.keys(gameStatistics).length === 0) {
                console.warn("Nincs elérhető játék statisztika, így a diagramok nem jelennek meg.");
                return; // Ha nincs adat, ne próbáljunk meg diagramokat generálni
            }

            Object.entries(gameStatistics).forEach(([game, stats]) => {
                let canvasId = `chart-${game.replace(/[^a-zA-Z0-9_]/g, "_")}`;
                let canvasElement = document.getElementById(canvasId);

                if (!canvasElement) {
                    console.error(`HIBA: Nem található canvas elem: ${canvasId}`);
                    return;
                }

                new Chart(canvasElement, {
                    type: "doughnut",
                    data: {
                        labels: ["Wins", "Losses"],
                        datasets: [{
                            data: [stats.wins, stats.losses],
                            backgroundColor: ["#4CAF50", "#F44336"]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
