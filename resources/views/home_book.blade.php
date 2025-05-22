<?php
require_once __DIR__ . '/../../../config.php';
session_start();

try {
    // Ambil semua kategori dari database
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Ambil data buku berdasarkan kategori (kecuali guru dan osis)
    $booksByCategory = [];
    foreach ($categories as $id => $name) {
        if ($id != 2 && $id != 5) { // Skip kategori guru (2) dan osis (4)
            $stmt = $pdo->prepare("SELECT * FROM books WHERE category_id = ? AND tahun_akademik_id = 1");
            $stmt->execute([$id]);
            $books = $stmt->fetchAll();

            if (!empty($books)) {
                $booksByCategory[$id] = [
                    'name' => $name,
                    'books' => $books
                ];
            }
        }
    }

    // Ambil data khusus guru (kategori 2)
    $stmt = $pdo->query("SELECT * FROM books WHERE category_id = 2 AND tahun_akademik_id = 1");
    $teacherBooks = $stmt->fetchAll();

    // Ambil data khusus osis (kategori 5)
    $stmt = $pdo->query("SELECT * FROM books WHERE category_id = 5 AND tahun_akademik_id = 1");
    $osisBooks = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tahunan Siswa - 2024</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/dua_empat.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="<?= BASE_URL ?>public/assets/img/logosmk.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL ?>admin/public/css/style.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="<?= BASE_URL ?>index.php">
                <img src="<?= BASE_URL ?>public/assets/img/logosmk.png" alt="Logo SMK">
                <p class="header-title">Buku Tahunan Siswa - 2024</p>
            </a>
        </div>
        <a href="<?= BASE_URL ?>views/auth/login.php">
            <button class="download-button">Download</button>
        </a>
    </header>

    <main>
        <section class="content">
            <div class="video-container">
        <div class="custom-video-frame">
            <img src="<?= BASE_URL ?>public/assets/img/border.png" class="frame-image" alt="Video Frame">
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
                <!-- Bagian Guru -->
                <?php if (!empty($teacherBooks)): ?>
                    <?php foreach ($teacherBooks as $book): ?>
                        <div class="button-card">
                            <a href="<?= BASE_URL ?>views/years/detail.php?id=<?= $book['id'] ?>&year=2024" class="card-link">
                                <img src="<?= BASE_URL ?>admin/public/uploads/<?= $book['cover_path'] ?>"
                                     alt="<?= htmlspecialchars($book['judul']) ?>"
                                     class="card-image"
                                     onerror="this.src='<?= BASE_URL ?>public/assets/img/buttonimage.png'">
                                <span class="card-overlay"><?= htmlspecialchars($book['judul']) ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Bagian OSIS -->
                <?php if (!empty($osisBooks)): ?>

                    <?php foreach ($osisBooks as $book): ?>
                        <div class="button-card-osis">
                            <a href="<?= BASE_URL ?>views/years/detail.php?id=<?= $book['id'] ?>&year=2024" class="card-link">
                                <img src="<?= BASE_URL ?>admin/public/uploads/<?= $book['cover_path'] ?>"
                                     alt="<?= htmlspecialchars($book['judul']) ?>"
                                     class="card-image"
                                     onerror="this.src='<?= BASE_URL ?>public/assets/img/osis-buttoncard.png'">
                                <span class="card-overlay"><?= htmlspecialchars($book['judul']) ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- TAMPILAN UNTUK SEMUA KATEGORI KECUALI GURU -->
        <?php if (!empty($booksByCategory)): ?>
            <?php foreach ($booksByCategory as $category): ?>
                <section class="content-book">
                    <p><?= htmlspecialchars($category['name']) ?></p>
                    <div class="buku-kelas">
                        <?php foreach ($category['books'] as $book): ?>
                            <div class="buku-kelas-card">
                                <img src="<?= BASE_URL ?>admin/public/uploads/<?= $book['cover_path'] ?>" alt="<?= htmlspecialchars($book['judul']) ?>" onerror="this.src='<?= BASE_URL ?>public/assets/buku-perkelas/osis55.png'">
                                <h1><?= htmlspecialchars($book['judul']) ?></h1>
                                <h2>Oleh <?= htmlspecialchars($book['penerbit'] ?? 'SMKN 1 Lumajang') ?></h2>
                                <hr style="height:0.05em; border-width:0; background-color:black; margin-bottom:10px">
                                <!-- Di bagian loop buku, ubah link menjadi: -->
<a href="<?= BASE_URL ?>views/years/detail.php?id=<?= $book['id'] ?>&year=2024">
    <button>Lihat selengkapnya</button>
</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <section class="content-book">
                <p>Tidak ada data buku tersedia</p>
            </section>
        <?php endif; ?>
    </main>

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
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.video-carousel');
    const slides = document.querySelectorAll('.video-slide');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    let currentIndex = 0;

    function updateCarousel() {
        slides.forEach((slide, index) => {
            if (index === currentIndex) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
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

    // Inisialisasi
    updateCarousel();
});
</script>
</body>
</html>
