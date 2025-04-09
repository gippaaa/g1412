<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Array motivasi & tips
$quotes = [
    "Belanja cerdas, hemat di tangan Anda!",
    "Gunakan diskon dengan bijak, jangan tergoda beli yang tidak perlu!",
    "Diskon besar bukan berarti harus beli, periksa kebutuhan Anda dulu.",
    "Simpan uang lebih banyak dengan membandingkan harga sebelum membeli.",
    "Gunakan promo dengan strategi, jangan asal tergoda diskon tinggi!"
];

// Ambil motivasi acak
$random_quotes = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #87CEEB);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .nav-box {
            border: 1px solid #ddd;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
            background: white;
            margin-top: 20px;
        }
        .motivasi-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f8f9fa;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container-box">
        <h1 class="text-center">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Motivasi & Tips Diskon -->
        <div class="motivasi-box">
            <h4>💡 Tips Hari Ini:</h4>
            <p><?php echo $random_quotes; ?></p>
        </div>

        <!-- Menu Navigasi -->
        <div class="nav-box mt-4">
            <div class="d-flex justify-content-center gap-3">
                <a href="calculate.php" class="btn btn-primary"><i class="fas fa-calculator"></i> Perhitungan Diskon</a>
                <a href="history.php" class="btn btn-info"><i class="fas fa-history"></i> Riwayat Transaksi</a>
                <a href="logout.php" id="logout-link" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>

    <script>
        // Konfirmasi Logout dengan SweetAlert2
        document.getElementById('logout-link').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan logout dari akun ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });
    </script>
</body>
</html>