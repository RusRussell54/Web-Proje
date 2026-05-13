<?php
// Form sadece POST ile gelmeliyse kontrol et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../iletisim.html');
    exit;
}

// Yardımcı fonksiyon: temizleme
function temizle(string $deger): string {
    return htmlspecialchars(strip_tags(trim($deger)), ENT_QUOTES, 'UTF-8');
}

$hatalar = [];

// Zorunlu alanlar
$ad     = temizle($_POST['ad']     ?? '');
$soyad  = temizle($_POST['soyad']  ?? '');
$email  = trim($_POST['email']     ?? '');
$telefon = temizle($_POST['telefon'] ?? '');
$konu   = temizle($_POST['konu']   ?? '');
$mesaj  = temizle($_POST['mesaj']  ?? '');
$iletisimTercihi = temizle($_POST['iletisimTercihi'] ?? '');
$kvkk   = isset($_POST['kvkk']) ? true : false;

// İsteğe bağlı
$bulusYolu = temizle($_POST['bulusYolu'] ?? '');
$yasAraligi = (int)($_POST['yasAraligi'] ?? 22);

// İlgi alanları (dizi)
$ilgiAlanlari = [];
if (isset($_POST['ilgiAlanlari']) && is_array($_POST['ilgiAlanlari'])) {
    foreach ($_POST['ilgiAlanlari'] as $alan) {
        $ilgiAlanlari[] = temizle($alan);
    }
}

// Sunucu tarafı doğrulama
if (strlen($ad) < 2)     $hatalar[] = 'Ad en az 2 karakter olmalıdır.';
if (strlen($soyad) < 2)  $hatalar[] = 'Soyad en az 2 karakter olmalıdır.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $hatalar[] = 'Geçerli bir e-posta adresi giriniz.';
if (!preg_match('/^[0-9]{10,11}$/', preg_replace('/[\s\-]/', '', $telefon))) $hatalar[] = 'Telefon 10-11 rakamdan oluşmalıdır.';
if (empty($konu))        $hatalar[] = 'Lütfen bir konu seçiniz.';
if (empty($iletisimTercihi)) $hatalar[] = 'İletişim tercihi seçiniz.';
if (count($ilgiAlanlari) === 0) $hatalar[] = 'En az bir ilgi alanı seçiniz.';
if (strlen($mesaj) < 10) $hatalar[] = 'Mesaj en az 10 karakter olmalıdır.';
if (!$kvkk)              $hatalar[] = 'KVKK metnini kabul etmeniz gerekmektedir.';

if (!empty($hatalar)) {
    header('Location: ../iletisim.html?durum=hata');
    exit;
}

$ilgiListesi = implode(', ', $ilgiAlanlari);
$kvkkMetin   = $kvkk ? 'Evet' : 'Hayır';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Alındı | Portföy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.html">
                <i class="bi bi-person-circle me-2"></i>Portföyüm
            </a>
        </div>
    </nav>

    <div class="container" style="padding-top: 100px; padding-bottom: 60px;">

        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>
                <strong>Form başarıyla alındı!</strong> <br> Gönderilen veriler aşağıda listelenmiştir.
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Gönderilen Form Verileri</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 35%;">Alan</th>
                            <th>Değer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="bi bi-person me-2 text-muted"></i>Ad</td>
                            <td><?= $ad ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-person me-2 text-muted"></i>Soyad</td>
                            <td><?= $soyad ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-envelope me-2 text-muted"></i>E-posta</td>
                            <td><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-telephone me-2 text-muted"></i>Telefon</td>
                            <td><?= $telefon ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-tag me-2 text-muted"></i>Konu</td>
                            <td><?= $konu ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-chat-dots me-2 text-muted"></i>İletişim Tercihi</td>
                            <td><?= $iletisimTercihi ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-heart me-2 text-muted"></i>İlgi Alanları</td>
                            <td><?= $ilgiListesi ?: '<em class="text-muted">Belirtilmedi</em>' ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-search me-2 text-muted"></i>Nasıl Buldu?</td>
                            <td><?= $bulusYolu ?: '<em class="text-muted">Belirtilmedi</em>' ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-bar-chart me-2 text-muted"></i>Yaş Aralığı</td>
                            <td><?= $yasAraligi ?></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-shield-check me-2 text-muted"></i>KVKK Onayı</td>
                            <td><?= $kvkkMetin ?></td>
                        </tr>
                        <tr>
                            <td class="align-top"><i class="bi bi-chat-text me-2 text-muted"></i>Mesaj</td>
                            <td style="white-space: pre-wrap;"><?= $mesaj ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="../iletisim.html" class="btn btn-outline-primary me-2">
                <i class="bi bi-arrow-left me-1"></i>Forma Geri Dön
            </a>
            <a href="../index.html" class="btn btn-primary">
                <i class="bi bi-house me-1"></i>Ana Sayfa
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
