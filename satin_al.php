<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Giriş yapmalısınız.'); window.location.href = 'login.php';</script>";
    exit;
}

include('vt.php');
$kullanici_id = $_SESSION['id'];


$sorgu = $connect->prepare("SELECT urun_id, adet FROM sepet WHERE kullanici_id = ?");
$sorgu->execute([$kullanici_id]);
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if (empty($urunler)) {
    echo "<script>alert('Sepetinizde ürün yok.'); window.location.href = 'sepet.php';</script>";
    exit;
}


foreach ($urunler as $urun) {
  
    // $kontrol = $connect->prepare("SELECT adet FROM siparisler WHERE kullanici_id = ? AND urun_id = ?");
    // $kontrol->execute([$kullanici_id, $urun['urun_id']]);
    // $varMi = $kontrol->fetch(PDO::FETCH_ASSOC);

    // if ($varMi) {
    
    //     $yeniAdet = $varMi['adet'] + $urun['adet'];
    //     $guncelle = $connect->prepare("UPDATE siparisler SET adet = ? WHERE kullanici_id = ? AND urun_id = ?");
    //     $guncelle->execute([$yeniAdet, $kullanici_id, $urun['urun_id']]);
    // } else {
   
    //     $ekle = $connect->prepare("INSERT INTO siparisler (kullanici_id, urun_id, adet) VALUES (?, ?, ?)");
    //     $ekle->execute([$kullanici_id, $urun['urun_id'], $urun['adet']]);
    // }
   
   
        $ekle = $connect->prepare("INSERT INTO siparisler (kullanici_id, urun_id, adet) VALUES (?, ?, ?)");
        $ekle->execute([$kullanici_id, $urun['urun_id'], $urun['adet']]);
    
}


$temizle = $connect->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
$temizle->execute([$kullanici_id]);

echo "<script>alert('Satın alma başarılı!'); window.location.href = 'index.php';</script>";
?>
