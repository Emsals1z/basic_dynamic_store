<?php



if ($_GET) {

    $sayfa = $_GET["sayfa"];
    include("../vt.php"); // veritabanı bağlantımızı sayfamıza ekliyoruz.
    $sorgu = $connect->prepare("SELECT * FROM $sayfa Where id=:id");
    $sorgu->execute(['id' => (int)$_GET["id"]]);
    $sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor
    

    // id'si seçilen veriyi silme sorgumuzu yazıyoruz.
    $where = ['id' => (int)$_GET['id']];
    $durum = $connect->prepare("DELETE FROM $sayfa WHERE id=:id")->execute($where);
    if ($durum) {
        header("location:$sayfa.php"); // Eğer sorgu çalışırsa index.php sayfasına gönderiyoruz.
    }
}
?>