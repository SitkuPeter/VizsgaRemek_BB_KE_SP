@extends('layouts.app')

@section('content')
<!-- Main Section with Video Background -->
<div class="relative min-h-screen overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
        <source src="{{ asset('storage/img/Robotspininroulette.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Overlay for Improved Readability -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="text-center z-10">
            <h1 class="text-white text-4xl font-bold md:text-5xl lg:text-6xl">Üdvözöljük Online Kaszinónkban!</h1>
            <a href="{{ route('pages.games') }}" class="mt-6 inline-block px-8 py-3 text-lg font-semibold text-white bg-amber-600 rounded-md shadow hover:bg-amber-700 transition duration-300">
                Játék Megkezdése
            </a>
        </div>
    </div>
</div>

<!-- Payment Methods Section -->
<section class="container mx-auto my-16 px-4">
    <div class="max-w-4xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Payment Method 1 -->
          <div class="flex items-center gap-6 p-6 rounded-2xl bg-gray-300 shadow-md hover:shadow-lg transition-shadow">
            <img src="/storage/img/creditcard.png" alt="Bankkártya" class="w-16 h-16 object-contain">
            <h4 class="text-xl font-semibold text-gray-800">Bankkártya</h4>
          </div>
      
          <!-- Payment Method 2 -->
          <div class="flex items-center gap-6 p-6 rounded-2xl bg-gray-300 shadow-md hover:shadow-lg transition-shadow">
            <img src="/storage/img/Paypal.png" alt="PayPal" class="w-16 h-16 object-contain">
            <h4 class="text-xl font-semibold text-gray-800">PayPal</h4>
          </div>
      
          <!-- Payment Method 3 -->
          <div class="flex items-center gap-6 p-6 rounded-2xl bg-gray-300 shadow-md hover:shadow-lg transition-shadow">
            <img src="/storage/img/bitcoin.png" alt="Bitcoin" class="w-16 h-16 object-contain">
            <h4 class="text-xl font-semibold text-gray-800">Bitcoin</h4>
          </div>
        </div>
      </div>
    </div>
</section>

<!-- Casino Description Section -->
<section class="container mx-auto my-16 px-4">
    <div class="max-w-4xl mx-auto text-center fade-in">
        <p class="text-gray-500 text-lg leading-relaxed">
            Online kaszinónk a legjobb játékélményt nyújtja modern grafikai megoldásokkal és izgalmas játékokkal.
            Fedezze fel a legnépszerűbb nyerőgépeket, asztali játékokat és az élő kaszinó izgalmait!
        </p>
    </div>
</section>

<!-- Footer Section -->
<footer class="bg-neutral-200 dark:bg-neutral-500 text-black dark:text-white py-6">
    <div class="container mx-auto text-center">
        <p>
            Probléma esetén keressen:
            <a href="mailto:info@casino.hu" class="text-blue-400 hover:text-yellow-500 transition duration-300">info@casino.hu</a>
        </p>
    </div>
</footer>
@endsection

@section('scripts')
<!-- Fade-In Effect Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fadeInElements = document.querySelectorAll('.fade-in');
        fadeInElements.forEach(el => el.style.opacity = 0);

        function checkFade() {
            fadeInElements.forEach(el => {
                const elementTop = el.getBoundingClientRect().top;
                const elementHeight = el.offsetHeight;
                const windowHeight = window.innerHeight;

                if (elementTop + elementHeight / 2 < windowHeight) {
                    el.style.opacity = 1;
                    el.style.transition = 'opacity 1s ease-in-out';
                }
            });
        }

        window.addEventListener('scroll', checkFade);
        checkFade();
    });
</script>
@endsection