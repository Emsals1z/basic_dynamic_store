
<?php include('ekler/head.php'); ?>

  <!-- Sticky WebGL container -->
  <div class="sticky-container" id="stickyContainer" style="height: 60vh;">
    <div class="webgl-section" id="webglSection" style="height: fit-content;">
      <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: 60vh;">
        <canvas id="space"></canvas>
   
      
        <div class="row justify-content-center">
    <div class="card card-login mx-auto mt-5" style="background:none;">
        <div class="blur-background"></div>
        <div class="card-header" style="z-index: 2;">Şifre Sıfırla</div>
        <div class="card-body" style="z-index: 2;">
         <form method="POST" id="pasreset">
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
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" name="newsifre" id="inputPassword2"  class="form-control" placeholder="Şifre" required>
                        <label for="inputPassword2">Yeni Şifre</label>
                    </div>
                </div>
                <button type="submit" name="resetle" class="btn btn-danger btn-block">Şifre Sıfırla</button>

               
            
            </form>
        </div>
    </div>
</div>



    
      </div>
    </div>
  </div>



<?php include('ekler/footer.php'); ?>


<?php
include('vt.php');

if (isset($_POST["resetle"])) {
    $kullaniciAdi = trim($_POST["kullanici_adi"]);
    $sifre = (string) trim($_POST["sifre"]);
    $newsifre = trim($_POST["newsifre"]);

    if (empty($kullaniciAdi) || empty($sifre)) {
        echo "<br>Kullanıcı adı veya şifreniz boş.";
        exit;
    }

    if (empty($newsifre)) {
        echo "<br>Yeni şifreyi yazmalısın.";
        exit;
    }

    $sql = "SELECT id, username, password FROM kullanicilar WHERE username = :username";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':username' => $kullaniciAdi]);
    $user = $stmt->fetch();

    if ($user && password_verify($sifre, $user['password'])) {
    
        $hashed_new_password = password_hash($newsifre, PASSWORD_DEFAULT);

  
        $updateSql = "UPDATE kullanicilar SET password = :newpassword WHERE id = :id";
        $updateStmt = $connect->prepare($updateSql);
        $updated = $updateStmt->execute([
            ':newpassword' => $hashed_new_password,
            ':id' => $user['id']
        ]);

        if ($updated) {
            echo "<br>Şifre başarıyla güncellendi.";
            header("Location: login.php");
            exit;
        } else {
            echo "<br>Şifre güncellenirken bir hata oluştu.";
        }
    } else {
        echo "<br>Başarısız. Kullanıcı adı veya şifre hatalı.";
    }
}
?>
