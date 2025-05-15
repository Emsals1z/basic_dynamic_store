<?php
session_start();
include('vt.php');

if (!isset($_SESSION['id']) || !isset($_POST['urun_id'])) {
    echo 'Geçersiz işlem';
    exit;
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$kullanici_id = intval($_SESSION['id']);
$urun_id = intval($_POST['urun_id']);

// Kullanıcı adını veritabanından alıyoruz
$sorgu = $connect->prepare("SELECT username FROM kullanicilar WHERE id = ?");
$sorgu->execute([$kullanici_id]);
$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$kullanici) {
    echo 'Kullanıcı bulunamadı.';
    exit;
}

$kullanici_adi = $kullanici['username'];  // Kullanıcı adı
$urun_adi = "Ürün Adı"; // Örnek olarak ürün adı; veritabanından çekmeniz gerekecek
$urun_fiyat = 100; // Örnek fiyat; veritabanından çekmeniz gerekecek

// Ürünün geçerli olup olmadığını kontrol etme
$sorgu = $connect->prepare("SELECT COUNT(*) FROM urunler WHERE id = ? AND aktif = 1");
$sorgu->execute([$urun_id]);

if ($sorgu->fetchColumn() == 0) {
    echo 'Ürün geçerli değil.';
    exit;
}
$sorgu = $connect->prepare("SELECT baslik FROM urunler WHERE id = ? AND aktif = 1");
$sorgu->execute([$urun_id]);

$urun = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$urun) {
    echo 'Ürün bulunamadı.';
    exit;
}
$urun_adi = $urun['baslik'];
// Sepette bu üründen var mı kontrol etme
$kontrol = $connect->prepare("SELECT adet,id FROM sepet WHERE kullanici_id = ? AND urun_id = ?");
$kontrol->execute([$kullanici_id, $urun_id]);
$mevcut = $kontrol->fetch(PDO::FETCH_ASSOC);

if ($mevcut) {
    $sepet_id = $mevcut['id']; // <-- Sepet ID burada
    // Adet artırma
    $guncelle = $connect->prepare("UPDATE sepet SET adet = adet + 1 WHERE kullanici_id = ? AND urun_id = ?");
    if ($guncelle->execute([$kullanici_id, $urun_id])) {
        echo 'Sepetteki ürün adedi artırıldı.';
    } else {
        echo 'Adet güncellenemedi.';
    }
} else {
    // Yeni ürün ekleme
    $ekle = $connect->prepare("INSERT INTO sepet (kullanici_id, urun_id, adet) VALUES (?, ?, 1)");
    if ($ekle->execute([$kullanici_id, $urun_id])) {
        echo 'Ürün sepete eklendi.';
        $sepet_id = $connect->lastInsertId(); // <-- SEPET ID buradan alınır
    } else {
        echo 'Ekleme başarısız.';
    }
}

$dosya = 'sepet.xlsx';

if (file_exists($dosya)) {
    $spreadsheet = IOFactory::load($dosya);
} else {
    $spreadsheet = new Spreadsheet();
}

$sheet = $spreadsheet->getActiveSheet();

// Eğer dosya boşsa, başlık satırını ekliyoruz
if ($sheet->getCell('A1')->getValue() == '') {
    $sheet->setCellValue('A1', 'Sepet ID');
    $sheet->setCellValue('B1', 'Kullanıcı Adı');
    $sheet->setCellValue('C1', 'Ürün ID');
    $sheet->setCellValue('D1', 'Ürün Adı');
    $sheet->setCellValue('E1', 'Adet');
    $sheet->setCellValue('F1', 'Fiyat');
    $sheet->setCellValue('G1', 'Toplam');
}

$sonSatir = $sheet->getHighestRow() + 1;
$toplam = $urun_fiyat * 1; // Adet 1 olarak eklendi

// Sepet verilerini ekliyoruz
$sheet->setCellValue('A' . $sonSatir, $sepet_id); // Sepet ID
$sheet->setCellValue('B' . $sonSatir, $kullanici_adi); // Kullanıcı Adı
$sheet->setCellValue('C' . $sonSatir, $urun_id); // Ürün ID
$sheet->setCellValue('D' . $sonSatir, $urun_adi); // Ürün Adı
$sheet->setCellValue('E' . $sonSatir, 1); // Adet
$sheet->setCellValue('F' . $sonSatir, $urun_fiyat); // Fiyat
$sheet->setCellValue('G' . $sonSatir, $toplam); // Toplam

// Dosyayı kaydediyoruz
$writer = new Xlsx($spreadsheet);
$writer->save($dosya);

echo "Ürün sepete eklendi ve Excel dosyasına kaydedildi.";
?>
