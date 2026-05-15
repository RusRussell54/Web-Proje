<?php
// Sadece POST isteği kabul edilir
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit;
}

// Tanımlı kullanıcı bilgileri
$gecerli_email = 'b231210035@sakarya.edu.tr';
$gecerli_sifre = 'b231210035';

// Gelen veriyi temizle
$kullaniciAdi = trim($_POST['kullaniciAdi'] ?? '');
$sifre        = trim($_POST['sifre']        ?? '');

// Boş alan kontrolü
if ($kullaniciAdi === '' || $sifre === '') {
    header('Location: ../login.html?hata=bos');
    exit;
}

// E-posta format kontrolü
if (!filter_var($kullaniciAdi, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../login.html?hata=mail');
    exit;
}

// Kimlik doğrulama
if ($kullaniciAdi !== $gecerli_email || $sifre !== $gecerli_sifre) {
    header('Location: ../login.html?hata=yanlis');
    exit;
}

// Başarılı giriş: öğrenci numarasını e-postadan çıkar
$ogrenciNo = explode('@', $kullaniciAdi)[0];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoşgeldiniz | Portföy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-bg">
        <div class="login-kart bg-white p-4 p-md-5 rounded-4 shadow-lg w-100 text-center" style="max-width:440px;">

            <div class="mb-4">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center
                            justify-content-center mb-3" style="width:70px; height:70px;">
                    <i class="bi bi-check-lg fs-2"></i>
                </div>
                <h3 class="fw-bold">Giriş Başarılı</h3>
                <p class="text-muted">Hoşgeldiniz</p>
                <p class="fs-5 fw-semibold text-success">
                    <?php echo htmlspecialchars($ogrenciNo, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>

            <a href="../index.html" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-house me-2"></i>Ana Sayfaya Git
            </a>

            <div class="mt-3">
                <a href="../login.html" class="text-muted text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i>Farklı hesapla giriş yap
                </a>
            </div>

        </div>
    </div>
</body>
</html>
