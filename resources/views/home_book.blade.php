<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tahunan Siswa - {{ $tahun }}</title>
    <link rel="stylesheet" href="{{ asset('css/home_book.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="{{ asset('images/img/logosmk.png') }}" type="image/x-icon">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/img/logosmk.png') }}" alt="Logo SMK">
                <p class="header-title">Buku Tahunan Siswa - {{ $tahun }}</p>
            </a>
        </div>
        {{-- <a href="{{ route('login') }}">
            <button class="download-button">Download</button>
        </a> --}}
    </header>

    <main>
        <section class="content">
            <div class="video-container">
                <div class="custom-video-frame">
                    <img src="{{ asset('images/img/border.png') }}" class="frame-image" alt="Video Frame">
                    <div class="video-carousel">
                        <div class="video-slide active">
                            <div class="youtube-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/IUqF6cAKR6Q?si=HBdTR8qiECEJW-E-&autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="video-slide">
                            <div class="youtube-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/bgdK78s-5Y0?si=0UaaNkXPwmjUADiD" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-controls">
                        <button class="carousel-prev" aria-label="Previous video">‹</button>
                        <button class="carousel-next" aria-label="Next video">›</button>
                    </div>
                </div>
            </div>

            <!-- TAMPILAN KHUSUS GURU DAN OSIS DI LAYOUT CONTAINER -->
            <div class="layout-container">
                <!-- Bagian Guru (Kategori 1) -->
                @if(!empty($booksByCategory[1]) && count($booksByCategory[1]['books']) > 0)
                    @foreach($booksByCategory[1]['books'] as $book)
                        <div class="button-card">
                            <a href="{{ route('buku.detail', ['id' => $book->id, 'year' => $tahun]) }}" class="card-link">
                                <div class="image-container">
                                    <img src="{{ Storage::url($book->cover_path) }}"
                                         alt="{{ $book->nama_kelas }}"
                                         class="card-image"
                                         onerror="this.src='{{ asset('images/img/default-book.png') }}'">
                                </div>
                                <div class="card-label">{{ $book->nama_kelas }}</div>
                            </a>
                        </div>
                    @endforeach
                @endif

                <!-- Bagian OSIS (Kategori 2) -->
                @if(!empty($booksByCategory[2]) && count($booksByCategory[2]['books']) > 0)
                    @foreach($booksByCategory[2]['books'] as $book)
                        <div class="button-card-osis">
                            <a href="{{ route('buku.detail', ['id' => $book->id, 'year' => $tahun]) }}" class="card-link">
                                <div class="image-container">
                                    <img src="{{ Storage::url($book->cover_path) }}"
                                         alt="{{ $book->nama_kelas }}"
                                         class="card-image"
                                         onerror="this.src='{{ asset('images/img/default-book.png') }}'">
                                </div>
                                <div class="card-label">{{ $book->nama_kelas }}</div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        <!-- TAMPILAN KHUSUS UNTUK KATEGORI SISWA -->
        @php
            // Definisi kategori yang akan ditampilkan di bagian atas
            $priorityCategories = [];

            // Cari kategori "Siswa" atau "Siswi" berdasarkan nama
            foreach($booksByCategory as $catId => $cat) {
                $name = strtolower($cat['name']);
                if (str_contains($name, 'siswa') || str_contains($name, 'siswi')) {
                    $priorityCategories[$catId] = $cat;
                }
            }

            // Debug: Tampilkan semua kategori yang tersedia
            if(config('app.debug')) {
                echo "<!-- Available Categories: ";
                foreach($booksByCategory as $catId => $cat) {
                    echo $catId . ":" . $cat['name'] . ", ";
                }
                echo " -->";
            }
        @endphp

        <!-- Tampilkan kategori siswa/siswi terlebih dahulu -->
        @foreach($priorityCategories as $categoryId => $category)
            <section class="content-book">
                <h2>{{ $category['name'] }}</h2>
                <div class="buku-kelas">
                    @foreach($category['books'] as $book)
                        <div class="buku-kelas-card">
                            <img src="{{ Storage::url($book->cover_path) }}"
                                 alt="{{ $book->nama_kelas }}"
                                 onerror="this.src='{{ asset('images/img/default-book.png') }}'">

                            <h1>{{ $book->nama_kelas }}</h1>
                            <h2>Oleh {{ $book->penerbit ?? 'SMKN 1 Lumajang' }}</h2>
                            <hr style="height:0.05em; border-width:0; background-color:black; margin-bottom:10px">
                            <a href="{{ route('buku.detail', ['id' => $book->id, 'year' => $tahun]) }}">
                                <button>Lihat selengkapnya</button>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <!-- TAMPILAN UNTUK SEMUA KATEGORI KECUALI GURU, OSIS, DAN SISWA/SISWI -->
        @if(!empty($booksByCategory))
            @php
                // Kategori yang sudah ditampilkan khusus
                $excludedCategories = array_merge([1, 2], array_keys($priorityCategories), [0]);
            @endphp

            @foreach($booksByCategory as $categoryId => $category)
                @if(!in_array($categoryId, $excludedCategories))
                    <section class="content-book">
                        <h2>{{ $category['name'] }}</h2>
                        <div class="buku-kelas">
                            @foreach($category['books'] as $book)
                                <div class="buku-kelas-card">
                                    <img src="{{ Storage::url($book->cover_path) }}"
                                         alt="{{ $book->nama_kelas }}"
                                         onerror="this.src='{{ asset('images/img/default-book.png') }}'">

                                    <h1>{{ $book->nama_kelas }}</h1>
                                    <h2>Oleh {{ $book->penerbit ?? 'SMKN 1 Lumajang' }}</h2>
                                    <hr style="height:0.05em; border-width:0; background-color:black; margin-bottom:10px">
                                    <a href="{{ route('buku.detail', ['id' => $book->id, 'year' => $tahun]) }}">
                                        <button>Lihat selengkapnya</button>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach

            <!-- TAMPILAN UNTUK BUKU TANPA KATEGORI -->
            @if(!empty($booksByCategory[0]) && count($booksByCategory[0]['books']) > 0)
                <section class="content-book">
                    <h2>{{ $booksByCategory[0]['name'] }}</h2>
                    <div class="buku-kelas">
                        @foreach($booksByCategory[0]['books'] as $book)
                            <div class="buku-kelas-card">
                                <img src="{{ Storage::url($book->cover_path) }}"
                                     alt="{{ $book->nama_kelas }}"
                                     onerror="this.src='{{ asset('images/img/default-book.png') }}'">

                                <h1>{{ $book->nama_kelas }}</h1>
                                <h2>Oleh {{ $book->penerbit ?? 'SMKN 1 Lumajang' }}</h2>
                                <hr style="height:0.05em; border-width:0; background-color:black; margin-bottom:10px">
                                <a href="{{ route('buku.detail', ['id' => $book->id, 'year' => $tahun]) }}">
                                    <button>Lihat selengkapnya</button>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @else
            <section class="content-book">
                <p>Tidak ada data buku tersedia untuk tahun {{ $tahun }}</p>
                <div style="text-align: center; margin: 20px;">
                    <a href="{{ route('home') }}" style="color: #007bff; text-decoration: none;">
                        ← Kembali ke halaman utama
                    </a>
                </div>
            </section>
        @endif
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h2 class="footer-title">BUKU TAHUNAN SISWA SMKN 1 LUMAJANG</h2>
                <div class="footer-social">
                    <a href="https://www.instagram.com/smkn1lumajang" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
                    <a href="https://web.facebook.com/people/SMKN-1-Lumajang/100071251050566/" aria-label="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="https://www.tiktok.com/@smkn1lumajang" aria-label="Tiktok"><i class='bx bxl-tiktok'></i></a>
                    <a href="https://www.youtube.com/@smkn1lumajangtv797" aria-label="Youtube"><i class='bx bxl-youtube'></i></a>
                    <a href="https://t.me/info_ppdb_smkn1lumajang_2024" aria-label="Telegram"><i class='bx bxl-telegram'></i></a>
                </div>
            </div>

            <div class="footer-info">
                <p class="copyright">© 2023 smkn1lmj. Buku Tahunan Siswa SMK Negeri 1 Lumajang</p>
                <p class="credits">Desain Oleh Jurnalistik SMK Negeri 1 Lumajang | Rekayasa Perangkat Lunak Gen-12</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.querySelector('.video-carousel');
            const slides = document.querySelectorAll('.video-slide');
            const prevBtn = document.querySelector('.carousel-prev');
            const nextBtn = document.querySelector('.carousel-next');
            let currentIndex = 0;

            function updateCarousel() {
                slides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentIndex);
                });
            }

            prevBtn.addEventListener('click', function() {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
                updateCarousel();
            });

            nextBtn.addEventListener('click', function() {
                currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            });

            // Initialize
            updateCarousel();
        });
    </script>
</body>
</html>
