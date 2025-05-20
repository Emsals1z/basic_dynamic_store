<?php include('ekler/head.php'); ?>

        <!-- Sticky WebGL container -->
        <div class="sticky-container" id="stickyContainer" style="height: 60vh;">
            <div class="webgl-section" id="webglSection" style="height: fit-content;">
                <div class="canvas-container" id="canvasContainer" style="flex-wrap: wrap;height: 60vh;">
                    <canvas id="space"></canvas>


                    <div class="row justify-content-center">
                        <div class="card card-login mx-auto mt-5" style="background:none;">
                            <div class="blur-background"></div>
                            <div class="card-header" style="z-index: 2;">Kayıt Ol</div>
                            <div class="card-body" style="z-index: 2;">
                                <form method="POST" id="register">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input type="text" name="username" id="inputKadiregister"
                                                class="form-control" placeholder="Kullanıcı Adı" required autofocus>

                                            <label for="inputKadiregister">Kullanıcı Adı</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <input type="password" name="pas" id="inputPasswordregister"
                                                class="form-control" placeholder="Şifre" required>
                                            <label for="inputPasswordregister">Şifre</label>
                                        </div>
                                    </div>

                                    <button type="submit" name="register" class="btn btn-primary btn-block">Kayıt
                                        Ol</button>



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
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js'></script>
    <script src="js/script.js"></script>

</body>

</html>


<?php
include('vt.php');

if (isset($_POST["register"])) {
    $kullanici_var = false;
    $username = trim($_POST["username"]);
    $password = (string) trim($_POST["pas"]);


    if (empty($username) || empty($password)) { 
        echo "<br> Kullanıcı adı veya şifreniz boş.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "<br> Şifreniz en az 6 karakter olmalıdır.";
        exit;
    }

    $sql = "SELECT * FROM kullanicilar WHERE username = :username";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':username' => $username]);

    if ($stmt->rowCount() > 0) {
        $kullanici_var = true;
    }

    if ($kullanici_var) {
        echo "<br> Zaten bu kullanıcı adında başka bir kullanıcı var.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO kullanicilar (username, password) VALUES (:username, :password)";
        $stmt = $connect->prepare($sql);

        $sonuc = $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password
        ]);

        if ($sonuc) {
            // Başarılı kayıt
            echo "<br> Yeni kayıt eklendi!";
            echo "<script>window.location.href='login.php';</script>";
            // header("Location: login.php");
        } else {
            // Başarısız
            echo "Kayıt sırasında hata oluştu!";
        }

        // $sql = "INSERT INTO kullanicilar (username, password) VALUES ('$username', '$password')";
        // if ($conn->query($sql) === TRUE) {
        //     echo "<br> Yeni kayıt eklendi!";
        //     header("Location: login.php");
        // } else {
        //     echo "Hata: " . $sql . "<br>" . $conn->error;
        // }

    }
}
?>