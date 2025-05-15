
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
  <div class="sticky-container" id="stickyContainer" style="height: fit-content;">
    <div class="webgl-section" id="webglSection" style="height: fit-content;">
      <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: fit-content;">
        <canvas id="space"></canvas>
   
        <section class="page-section about-heading" style="background-color: #1111119c;width: 100%;">
        

            <div class="about-heading-content">
                <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                        <div class="bg-faded rounded p-5">
                            <h2 class="section-heading mb-4">
                                <span class="section-heading-upper">İLETİŞİM</span>
                            </h2>

                            <form action="iletisim.php" method="POST">

                                <div class="form-group">
                                    <input type="text" name="ad" required class="form-control px-3 py-3"
                                           placeholder="Adınız">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" required class="form-control px-3 py-3"
                                           placeholder="Email Adresiniz">
                                </div>
                                <div class="form-group">
                                <textarea name="mesaj" cols="30" required rows="7" class="form-control px-3 py-3"
                                          placeholder="Mesaj"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Gönder" class="btn btn-primary py-3 px-5">
                                    <script type="text/javascript" src="js/sweetalert.min.js"></script>
                                    <?php

                                    if ($_POST) {

                                        $kaydet = $connect->prepare("INSERT INTO iletisim SET ad=:ad, email=:email, mesaj=:mesaj");
                                        $insert = $kaydet->execute(array(
                                            'ad' => htmlspecialchars($_POST['ad']),
                                            'email' => htmlspecialchars($_POST['email']),
                                            'mesaj' => htmlspecialchars($_POST['mesaj']),
                                        ));
                                        if ($insert) {

                                            echo '<script>swal("Başarılı","Mesajınız bize ulaştı","success");</script>';
                                        } else {
                                            echo '<script>swal("Hata","Daha sonra tekrar deneyin","error");</script>';
                                        }
                                    }

                                    ?>


                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        
    </section>



    
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
