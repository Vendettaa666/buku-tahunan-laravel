<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $buku->nama_kelas }} - Buku Tahunan {{ $year }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-content">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/img/logosmk.png') }}" alt="Logo SMK">
                <p class="header-title">Buku Tahunan Siswa - {{ $year }}</p>
            </a>
        </div>
    </header>

     <!-- MAIN CONTENT -->
    <main class="container">
        <div class="book-header">
            <img src="{{ Storage::url($buku->cover_path) }}"
                 alt="{{ $buku->nama_kelas }}"
                 class="book-cover"
                 onerror="this.src='{{ asset('images/img/default-book.png') }}'">

            <div>
                <h1>
                    {{ $buku->nama_kelas }}
                    @if($isTeacherBook)
                        <span class="teacher-badge">Guru</span>
                    @endif
                </h1>
                <p><strong>Kategori:</strong> {{ $buku->kategori->nama }}</p>
                <p><strong>Tahun:</strong> {{ $year }}</p>
                @if(!empty($buku->penerbit))
                    <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
                @endif

                @if(!empty($buku->file_path))
                    <a href="{{ route('buku.download', ['id' => $buku->id, 'year' => $year]) }}"
                       class="download-btn">
                       <i class='bx bx-download'></i> Download Buku
                    </a>
                @endif
            </div>
        </div>

        @if(!empty($buku->file_path))
            <div class="pdf-viewer-container">
                <iframe src="{{ Storage::url($buku->file_path) }}#toolbar=0"
                        class="pdf-viewer">
                    Browser Anda tidak mendukung PDF. Silakan download <a href="{{ route('buku.download', ['id' => $buku->id, 'year' => $year]) }}">di sini</a>.
                </iframe>
            </div>
        @else
            <div class="alert">
                <i class='bx bx-error'></i> File buku tidak tersedia
            </div>
        @endif

        <a href="{{ route('years.show', $year) }}" class="back-btn">
            <i class='bx bx-arrow-back'></i> Kembali ke Katalog {{ $year }}
        </a>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h2 class="footer-title">BUKU TAHUNAN SISWA SMKN 1 LUMAJANG</h2>
                <div class="footer-social">
                    <a href="https://www.instagram.com/smkn1lumajang?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" aria-label="Instagram"><i class='bx bxl-instagram'></i></a>
                    <a href="https://web.facebook.com/people/SMKN-1-Lumajang/100071251050566/" aria-label="Facebook"><i class='bx bxl-facebook'></i></a>
                    <a href="https://www.tiktok.com/@smkn1lumajang?_t=8knQnkBiAXB&_r=1" aria-label="Tiktok"><i class='bx bxl-tiktok'></i></a>
                    <a href="https://www.youtube.com/@smkn1lumajangtv797" aria-label="Youtube"><i class='bx bxl-youtube'></i></a>
                    <a href="https://t.me/info_ppdb_smkn1lumajang_2024" aria-label="Spotify"><i class='bx bxl-telegram'></i></a>
                </div>
            </div>

            <div class="footer-info">
                <p class="copyright">© 2023 smkn1lmj. Buku Tahunan Siswa SMK Negeri 1 Lumajang</p>
                <p class="credits">Desain Oleh Jurnalistik SMK Negeri 1 Lumajang | Rekayasa Perangkat Lunak Gen-12</p>
            </div>
        </div>
    </footer>
</body>
</html> 
