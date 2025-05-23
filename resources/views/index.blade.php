<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('images/img/logosmk.png') }}" type="image/x-icon">
    <title>Buku Tahunan Siswa </title>
    <style>
        .highlight-card {
            position: relative;
            transform: scale(1.1);
            z-index: 2;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }

        .highlight-card::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid rgb(0, 0, 0);
            border-radius: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <header>
        <p>Buku</p>
        <span>Tahunan Siswa</span>
    </header>

    <section class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach($tahuns as $tahun)
                <div class="card swiper-slide {{ $tahun->tahun == '2025' ? 'highlight-card' : '' }}">
                    <div class="card_image">
                        <a href="{{ route('home_book', $tahun->tahun) }}">
                            @if($tahun->cover_image)
                                <img src="{{ Storage::url('cover_years/' . $tahun->cover_image) }}" alt="Buku Tahunan {{ $tahun->tahun }}">
                            @else
                                <!-- Fallback image jika tidak ada cover_image -->
                                <img src="{{ asset('images/img/covertahun' . $tahun->tahun . '.png') }}" alt="Buku Tahunan {{ $tahun->tahun }}" onerror="this.src='{{ asset('images/img/default-cover.png') }}'">
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach

            <!-- Fallback cards if no data from database -->
            @if($tahuns->isEmpty())
                <div class="card swiper-slide">
                    <div class="card_image">
                        <a href="{{ route('home_book', '2024') }}">
                            <img src="{{ asset('images/img/covertahun2024.png') }}" alt="Buku Tahunan 2024">
                        </a>
                    </div>
                </div>
                <div class="card swiper-slide highlight-card">
                    <div class="card_image">
                        <a href="{{ route('home_book', '2025') }}">
                            <img src="{{ asset('images/img/covertahun2025.png') }}" alt="Buku Tahunan 2025">
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="title-footer">
                <h2>SMK NEGERI 1 LUMAJANG</h2>
            </div>
            <div class="footer-content">
                <p>Jl. H. O.S. Cokroaminoto No.161, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316</p>
            </div>
            <div class="footer-copyright">
                <p>© 2025 SMK Negeri 1 Lumajang</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // Detect Safari
        const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        const isFirefox = /firefox/i.test(navigator.userAgent);

        if (isSafari || isFirefox) {
            // Remove Swiper entirely for Safari
            document.querySelector('.mySwiper').classList.add('simple-carousel');

            // Add simple CSS carousel styles
            const style = document.createElement('style');
            style.textContent = `
        .simple-carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .simple-carousel .swiper-wrapper {
            display: flex;
        }
        .simple-carousel .swiper-slide {
            scroll-snap-align: start;
            flex: 0 0 auto;
        }
    `;
            document.head.appendChild(style);
        } else {
            // Initialize Swiper normally for other browsers
            var swiper = new Swiper(".mySwiper", {
                loop: false,
                loopAdditionalSlides: 2,
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 300,
                    modifier: 1,
                    slideShadows: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                },
                initialSlide: getInitialSlide(),
            });
        }

        // Function to find the index of 2025 card
        function getInitialSlide() {
            const slides = document.querySelectorAll('.swiper-slide');
            let index = 0;
            slides.forEach((slide, i) => {
                if (slide.classList.contains('highlight-card')) {
                    index = i;
                }
            });
            return index;
        }
    </script>
</body>

</html>
