

<?php
include('vt.php');
$sorgu = $connect->prepare("SELECT * FROM anasayfa");
$sorgu->execute();
$sonuc = $sorgu->fetch();//sorgu çalıştırılıp veriler alınıyor
?>
<?php include('ekler/head.php'); ?>

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

<?php include('ekler/footer.php'); ?>
