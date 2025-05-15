

<?php
include('vt.php');
$sorgu = $connect->prepare("SELECT * FROM anasayfa");
$sorgu->execute();
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor
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

<div class="footer">
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
  <div class="sticky-container" id="stickyContainer">
    <div class="webgl-section" id="webglSection">
      <div class="canvas-container" id="canvasContainer">
        <canvas id="space"></canvas>
        <div class="animated-text" id="animatedText">
        <span><?= $sonuc['ustBaslik'] ?></span>
        <h2> <?= $sonuc['ustIcerik'] ?></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Additional 100vh section -->
  <div class="additional-section section-transition" id="additionalSection">
  <div class="additional-img-container" >
  <img class="additional-img" id="additionalContent" src="img/<?= $sonuc['foto'] ?>" alt="">
 </div>
 
    <div class="additional-content" id="additionalContent">
      <h2><span class="section-heading-lower"><?= $sonuc['altBaslik'] ?></h2>
      <?= $sonuc['altIcerik'] ?>
    </div>

  </div>

  <div class="bottom-bar">
    <div class="coordinates">
      <p>Kayra Saraçoğlu</p>
    </div>

    <div class="links">
    <a href="<?= $sonuc['link'] ?>">Tıkla</a>

    </div>

    <div class="info">
      <p>2405113505</p>
    </div>
  </div>

  <div class="dot-grid" id="dotGrid"></div>
</div>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script><script  src="js/script.js"></script>

</body>
</html>
