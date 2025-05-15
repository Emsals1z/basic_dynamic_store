<?php 
include("../vt.php"); // veritabanı bağlantımızı sayfamıza ekliyoruz.
if ($_POST) { // Post olup olmadığını kontrol ediyoruz.
	
	$alan = $_POST['alan']; // Post edilen değerleri değişkenlere aktarıyoruz
	$deger = $_POST['deger'];
	
	//+ (artı) değerini post edemediğimizden {0} ile gönderip burada tekrar + ya çeviriyoruz
	$deger = str_replace('{0}','+',$deger); 
	
	$id = $_POST['id'];


		
		if ($connect->query("UPDATE urunler SET $alan = '$deger' WHERE id =$id")) // Veri güncelleme sorgumuzu yazıyoruz.
		{
			echo true; // Eğer güncelleme sorgusu çalıştıysa geriye true döndürüyoruz
		}
		else
		{
			echo false; // id bulunamadıysa veya sorguda hata varsa false döndürüyoruz
		}



}

?>
