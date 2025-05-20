<?php
session_start();
include('vt.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["giris_yap"])) {
    $username = trim($_POST["kullanici_adi"]);
    $password = (string) trim($_POST["sifre"]);

    if (empty($username) || empty($password)) {
        $error = "Kullanıcı adı veya şifre boş bırakılamaz.";
    } else {
        $query = "SELECT * FROM kullanicilar WHERE username = :username";
        $stmt = $connect->prepare($query);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['giris_yapildi'] = true;
            $_SESSION['yetki'] = $user['yetki'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['id'] = $user['id'];

            if ($user['yetki'] === "GOD" || $user['yetki'] === "ADMIN") {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Kullanıcı adı veya şifre hatalı!";
        }
    }
}
?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center mt-3">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php include('ekler/head.php'); ?>

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



<?php include('ekler/footer.php'); ?>

