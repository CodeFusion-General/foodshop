<?php
// Veritabanı bağlantısı
$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "foodshop";

// Create a connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Kullanıcıdan gelen POST verilerini al
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Kullanıcı adı kontrolü
$sql = "SELECT * FROM account WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    // Şifreyi doğrula
    if (password_verify($password, $hashedPassword)) {
        // Kullanıcı doğrulandı, oturum açma durumunu sakla
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $row['user_id'];

        // İsteği başka bir sayfaya yönlendir
        header('Location: http://localhost:8080/foodshop/index.php');
        exit();
    } else {
        // Kullanıcı doğrulanamadı, hata mesajını göster ve işlemi sonlandır
        echo '<script>alert("Wrong username or password.");</script>';
        echo '<script>window.location.href = "http://localhost:8080/foodshop/login.php";</script>';
        exit();
    }
} else {
    // Kullanıcı bulunamadı, hata mesajını göster ve işlemi sonlandır
    echo '<script>alert("Wrong username or password.");</script>';
    echo '<script>window.location.href = "http://localhost:8080/foodshop/login.php";</script>';
    exit();
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
