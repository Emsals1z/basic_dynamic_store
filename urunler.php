


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
       
<?php

include('vt.php');



$sorgu = $connect->prepare("SELECT * FROM urunler where aktif=1 order by sira");
$sorgu->execute();
$yon = 'sag';

while ($sonuc = $sorgu->fetch()) {
    ?>

<section class="section" style="width:70%;">
    <div class="section-div">
        <div class="product-item row mb-5 align-items-center" style="padding: 10px;">
            <?php if ($yon == 'sag'): ?>
                <div class="col-md-6" style="justify-content: center; display: flex;">
                    <img class="img-fluid rounded" src="img/<?= $sonuc['foto'] ?>" alt="" style="max-height: 26vh;">
                </div>
                <div class="col-md-6" style="text-align: start;">
                    <h2><?= $sonuc['baslik'] ?></h2>
                    <h5 class="text-muted"><?= $sonuc['ustBaslik'] ?></h5>
                    <p><?= $sonuc['icerik'] ?></p>
                    <p><strong>Fiyat:</strong> <?= number_format($sonuc['fiyat'], 2) ?> ₺</p>
                    <button class="btn btn-success sepete-ekle" data-id="<?= $sonuc['id'] ?>">Sepete Ekle</button>
                </div>
            <?php else: ?>
                <div class="col-md-6 order-md-2" style="justify-content: center; display: flex;">
                    <img class="img-fluid rounded" src="img/<?= $sonuc['foto'] ?>" alt="" style="max-height: 26vh;">
                </div>
                <div class="col-md-6 order-md-1" style="text-align: end;">
                    <h2><?= $sonuc['baslik'] ?></h2>
                    <h5 class="text-muted"><?= $sonuc['ustBaslik'] ?></h5>
                    <p><?= $sonuc['icerik'] ?></p>
                    <p><strong>Fiyat:</strong> <?= number_format($sonuc['fiyat'], 2) ?> ₺</p>
                    <button class="btn btn-success sepete-ekle" data-id="<?= $sonuc['id'] ?>">Sepete Ekle</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



    <?php
    if ($yon == 'sag') $yon = 'sol';
    else $yon = 'sag';

} //while sonu

?>
      </div>
    </div>
  </div>



  <div class="dot-grid" id="dotGrid" style="width:100%"></div>
</div>
<!-- partial -->
  <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script><script  src="js/urunscript.js"></script>

</body>
<script>
$(document).on('click', '.sepete-ekle', function () {
    const urunId = $(this).data('id');

    $.ajax({
        url: 'sepet_ekle.php',
        method: 'POST',
        data: { urun_id: urunId },
        success: function (response) {
            alert(response);
        },
        error: function () {
            alert('Bir hata oluştu.');
        }
    });
});

</script>
</html>


