-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                10.4.32-MariaDB - mariadb.org binary distribution
-- Sunucu İşletim Sistemi:       Win64
-- HeidiSQL Sürüm:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- phpders için veritabanı yapısı dökülüyor
CREATE DATABASE IF NOT EXISTS `phpders` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci */;
USE `phpders`;

-- tablo yapısı dökülüyor phpders.anasayfa
CREATE TABLE IF NOT EXISTS `anasayfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) NOT NULL,
  `ustBaslik` varchar(250) NOT NULL,
  `ustIcerik` varchar(6000) NOT NULL,
  `link` char(50) NOT NULL,
  `altBaslik` char(250) NOT NULL,
  `altIcerik` varchar(6000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpders.anasayfa: 1 rows tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `anasayfa` DISABLE KEYS */;
INSERT INTO `anasayfa` (`id`, `foto`, `ustBaslik`, `ustIcerik`, `link`, `altBaslik`, `altIcerik`) VALUES
	(1, '20240808_113654.jpg', 'Siz çoksunuz ama bir TÜRK\'üz', '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <p>bu yazı admin panelinden ayarlandı</p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ', 'https://emsalsiz.tr', 'TÜRK', '<p>Ey Benito Musolini! Ey gayet yüce,</p>\r\n<p>italyanlar başvekili muhterem Düce!</p>\r\n<p>Duydum ki, yelkenleri edip de fora</p>\r\n<p>Gelecekmiş orduların yeşil Bosfora.</p>\r\n<p>Buyursunlar... Bizim için şavaş düğündür;</p>\r\n<p>Din Arab\'ın, hukuk sizin, harp Türk\'lüğündür.</p>\r\n<p>Açlar nasıl bir istekle koşarsa aşa</p>\r\n<p>Türk eri de öyle gider kanlı savaşa.</p>\r\n<p>Hem karadan, hem denizden ordular indir!</p>\r\n<p>Çarpışalım, en doğru söz süngülerindir!</p>\r\n<p>Kalem, fırça, mermer nedir? Birer oyuncak!</p>\r\n<p>Şaheserler sungtilerle yazılır ancak!</p>\r\n<p>Çağri Beg\'le Tuğrul Beg\'in kurduğu devlet</p>\r\n<p>Italyalı melezlerden üsttündür elbet;</p>\r\n<p>Bizim eski uşakları alda yanına</p>\r\n<p>Balkanlardan doğru yürü er meydanına;</p>\r\n<p>Çelik zırhlı kartalları göklere saldır...</p>\r\n<p>Fakat zafer sizin için söz ve masaldır...</p>\r\n<p>Dirilerek başınıza geçse de Sezar</p>\r\n<p>Yine olur Anadolu size bir mezar.</p>\r\n<p>Belki fazla bel bağladın şimal komşuna,</p>\r\n<p>Biz güleriz Cermenliğin kuduruşuna,</p>\r\n<p>Tanıyoruz Atilla\'dan beri Cermeni,</p>\r\n<p>Farklı mıdır Prusyalı yahut Ermeni?</p>\r\n<p>Senin dostun Cermanyaya biz Nemşe deriz,</p>\r\n<p>Bir gün yine Bec onünde düğün ederiz.</p>\r\n');
/*!40000 ALTER TABLE `anasayfa` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpders.iletisim
CREATE TABLE IF NOT EXISTS `iletisim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- phpders.iletisim: 2 rows tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `iletisim` DISABLE KEYS */;
INSERT INTO `iletisim` (`id`, `ad`, `email`, `mesaj`, `tarih`) VALUES
	(35, 'deneme', 'deneme@mail.com', 'denemesasda', '2025-04-30 19:32:53'),
	(36, 'deneme', 'deneme@maşil.com', 'sadfdsfdsf', '2025-05-01 01:24:36');
/*!40000 ALTER TABLE `iletisim` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpders.kullanicilar
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `yetki` varchar(50) NOT NULL DEFAULT 'USER',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- phpders.kullanicilar: 4 rows tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `kullanicilar` DISABLE KEYS */;
INSERT INTO `kullanicilar` (`id`, `username`, `password`, `yetki`) VALUES
	(23, 'kayra', '202cb962ac59075b964b07152d234b70', 'GOD'),
	(24, 'userdeneme', '81dc9bdb52d04dc20036dbd8313ed055', 'USER'),
	(26, 'deneme2', '827ccb0eea8a706c4c34a16891f84e7b', 'USER'),
	(27, 'kayradeneme', '827ccb0eea8a706c4c34a16891f84e7b', 'USER');
/*!40000 ALTER TABLE `kullanicilar` ENABLE KEYS */;

-- tablo yapısı dökülüyor phpders.sepet
CREATE TABLE IF NOT EXISTS `sepet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `adet` int(11) DEFAULT 1,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpders.sepet: ~0 rows (yaklaşık) tablosu için veriler indiriliyor

-- tablo yapısı dökülüyor phpders.siparisler
CREATE TABLE IF NOT EXISTS `siparisler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL DEFAULT 1,
  `siparis_tarihi` datetime DEFAULT current_timestamp(),
  `durum` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpders.siparisler: ~6 rows (yaklaşık) tablosu için veriler indiriliyor
INSERT INTO `siparisler` (`id`, `kullanici_id`, `urun_id`, `adet`, `siparis_tarihi`, `durum`) VALUES
	(16, 24, 12, 1, '2025-05-01 01:02:51', 'hazırlanıyor'),
	(17, 24, 6, 1, '2025-05-01 01:04:33', 'kargolandı'),
	(18, 24, 10, 4, '2025-05-01 01:25:16', 'kargolandı'),
	(19, 24, 10, 2, '2025-05-01 13:45:24', 'kargolandı'),
	(20, 24, 10, 1, '2025-05-01 13:45:37', 'tamamlandı'),
	(21, 24, 4, 1, '2025-05-01 13:50:12', 'kargolandı'),
	(22, 24, 6, 2, '2025-05-01 13:50:12', 'tamamlandı');

-- tablo yapısı dökülüyor phpders.urunler
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` char(50) NOT NULL,
  `baslik` char(250) NOT NULL,
  `ustBaslik` char(250) NOT NULL,
  `icerik` text NOT NULL,
  `aktif` tinyint(4) NOT NULL,
  `sira` int(11) NOT NULL,
  `fiyat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- phpders.urunler: 5 rows tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `urunler` DISABLE KEYS */;
INSERT INTO `urunler` (`id`, `foto`, `baslik`, `ustBaslik`, `icerik`, `aktif`, `sira`, `fiyat`) VALUES
	(4, 'urun1.png', 'Ürün1', 'Ürün1', '<p>We take pride in our work, and it shows. Every time you order a beverage from us, we guarantee that it will be an experience worth having. Whether it\'s our world famous Venezuelan Cappuccino, a refreshing iced herbal tea, or something as simple as a cup of speciality sourced black coffee, you will be coming back for more.</p>', 1, 100, 150),
	(11, 'urun4.png', 'Ürün4', 'Ürün4', '<p>içerik</p>', 1, 500, 300),
	(6, 'urun2.png', 'Ürün2', 'Ürün2', '<p>Our seasonal menu features delicious snacks, baked goods, and even full meals perfect for breakfast or lunchtime. We source our ingredients from local, oragnic farms whenever possible, alongside premium vendors for specialty goods.</p>', 1, 200, 200),
	(12, 'urun5.png', 'Ürün5', 'Ürün5', '<blockquote><ol><li>sadsaasdsa</li></ol></blockquote>', 1, 1200, 200),
	(10, 'urun3.png', 'Ürün3', 'Ürün3', '<p>sdsad</p>', 1, 300, 100);
/*!40000 ALTER TABLE `urunler` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
