
<?php
$sayfa = 'İletişim';
include('vt.php');
?>

<!DOCTYPE html>
<html lang="tr" >
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kayra Saraçoğlu</title>


  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js" integrity="sha256-xH4q8N0pEzrZMaRmd7gQVcTZiFei+HfRTBPJ1OGXC0k=" crossorigin="anonymous"></script>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">



  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<link href="css/style.css" rel="stylesheet">


</head>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<body>

<div class="footer" style="min-height: 90vh;">
  <div class="container">
    <div class="nav">
      <div class="logo-container">
     <a href="index.php"> <h3>Kayra Saraçoğlu</h3></a>
      </div>
    </div>

    <div class="values">
    <a href="urunler.php"> <h3>Ürünler</h3></a>
   
    </div>

    <div class="contact">
    <a href="iletisim.php"> <h3>İletişim</h3></a>
     
    </div>
    <?php if (isset($_SESSION['username']) && isset($_SESSION['yetki'])): ?>
                 

                    <div class="social">

                 
      <h3>  <?php echo htmlspecialchars(strtoupper($_SESSION['username'])); ?></h3>
      <ul>
      <li><a href="sepet.php">Sepet</a></li>
      <?php if ($_SESSION['yetki'] === 'USER'): ?>
                        <li><a href="admin/userdashboard.php">Ayarlar</a></li>
                    <?php elseif ($_SESSION['yetki'] === 'ADMIN' || $_SESSION['yetki'] === 'GOD'): ?>
                        <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="cikis.php">Çıkış Yap</a></li>
      </ul>
    </div>

                <?php else: ?>
                
                    <div class="social">
                        <ul>
                        <a href="login.php"><h3>Giriş Yap</h3></a>
                        </ul>
                    </div>
                <?php endif; ?>
   
  </div>

  <!-- Sticky WebGL container -->
  <div class="sticky-container" id="stickyContainer" style="height: 60vh;">
    <div class="webgl-section" id="webglSection" style="height: fit-content;">
      <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: 60vh;">
        <canvas id="space"></canvas>
   
      
        <div class="row justify-content-center">
    <div class="card card-login mx-auto mt-5" style="background:none;">
        <div class="blur-background"></div>
        <div class="card-header" style="z-index: 2;">Giriş Yap</div>
        <div class="card-body" style="z-index: 2;">
            <form method="POST" id="login">
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="text" name="kullanici_adi" id="inputKadi"  class="form-control" placeholder="Kullanıcı Adı" required autofocus>
                        
                        <label for="inputKadi">Kullanıcı Adı</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" name="sifre" id="inputPassword"  class="form-control" placeholder="Şifre" required>
                        <label for="inputPassword">Şifre</label>
                    </div>
                </div>

                <button type="submit" name="giris_yap" class="btn btn-primary btn-block">Giriş Yap</button>

                <div class="text-center mt-3">
                    <a href="passwordreset.php">Şifremi Unuttum?</a> | 
                    <a href="register.php">Kayıt Ol</a>
                </div>

            
            </form>
        </div>
    </div>
</div>



    
      </div>
    </div>
  </div>



  <div class="dot-grid" id="dotGrid" style="width:100%"></div>
</div>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script><script  src="js/script.js"></script>

</body>
</html>

<?php
include('vt.php');


if(isset($_POST["giris_yap"])) {
	$kullaniciAdi = addslashes(trim($_POST["kullanici_adi"]));
	$sifre = addslashes(trim($_POST["sifre"]));

	// kullanıcı adı ve şifreyi aldık tek tırnak ve sağ-sol daki boşluklardan arındırdık.
	if(empty($kullaniciAdi) || empty($sifre)) { // kullanıcı adı veya şifreden biri boş ise bilgi ver
		
        echo "<script>
        alert('Kullanıcı adı veya şifreniz boş.!');
    </script>";
	}
    $sifre = md5($sifre);
    $sql = "SELECT id, username, password, yetki FROM kullanicilar WHERE username = '$kullaniciAdi' AND password = '$sifre'";

	$result = $conn->query($sql);
	
    if ($result->num_rows > 0) {
        session_start();

        $kullanici = $result->fetch_assoc();
      
        $_SESSION['giris_yapildi'] = true;
        $_SESSION['yetki'] = $kullanici['yetki']; // Yetkiyi oturuma yaz
        $_SESSION['username'] = $kullanici['username'];
        $_SESSION['id'] = $kullanici['id'];

        if ($kullanici['yetki'] === "GOD" || $kullanici['yetki'] === "ADMIN" ) {
            header("Location: admin/dashboard.php");
        }else{
            header("Location: index.php");
        }
        

        exit;
    } else {
      
        echo "<script>
        alert('Başarısız. Kullanıcı adı veya şifre hatalı!');
    </script>";
    }
}
?>