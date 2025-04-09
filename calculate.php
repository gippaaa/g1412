<?php
session_start();
include 'Database/koneksi.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$final_price = null;
$original_price = null;
$discount_percent = null;
$total_discount = null;
$item_name = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $original_price = str_replace('.', '', $_POST['original_price']);
    $discount_percent = $_POST['discount_percent'];

    // Validasi backend agar diskon tidak lebih dari 100%
    if ($discount_percent > 100) {
        die("<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Diskon tidak valid! Persentase tidak boleh lebih dari 100%.',
                confirmButtonText: 'OK'
            }).then(() => { window.history.back(); });
        </script>");
    }

    $total_discount = $original_price * $discount_percent / 100;
    $final_price = $original_price - $total_discount;

    $query = "INSERT INTO transactions (item_name, original_price, discount_percent, final_price)
              VALUES ('$item_name', '$original_price', '$discount_percent', '$final_price')";
    $conn->query($query);

    $message = "Diskon berhasil dihitung!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Diskon</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #87CEEB);
            height: 100vh;
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
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container-box">
        <a href="dashboard.php" class="btn btn-warning mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h2 class="text-center">Perhitungan Diskon</h2>
        <form method="POST" id="discountForm">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Awal</label>
                <input type="text" id="original_price" name="original_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Persentase Diskon</label>
                <input type="number" id="discount_percent" name="discount_percent" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Hitung</button>
        </form>

        <!-- Hasil Perhitungan -->
        <?php if ($final_price !== null): ?>
            <div class="alert alert-info mt-3">
                <p><strong>Nama Barang:</strong> <?php echo htmlspecialchars($item_name); ?></p>
                <p><strong>Harga Awal:</strong> Rp <?php echo number_format($original_price, 0, ',', '.'); ?></p>
                <p><strong>Total Diskon:</strong> Rp <?php echo number_format($total_discount, 0, ',', '.'); ?></p>
                <p><strong>Harga Akhir:</strong> Rp <?php echo number_format($final_price, 0, ',', '.'); ?></p>
            </div>

            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?php echo $message; ?>',
                    timer: 3000,
                    showConfirmButton: false,
                });
            </script>
        <?php endif; ?>
    </div>

    <script>
        // Format angka otomatis dengan titik saat user mengetik harga
        document.getElementById('original_price').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Hapus semua karakter non-angka
            let formattedValue = new Intl.NumberFormat('id-ID').format(value); // Format dengan titik otomatis
            e.target.value = formattedValue;
        });

        // Validasi diskon saat tombol "Hitung" ditekan
        document.getElementById('discountForm').addEventListener('submit', function (e) {
            let discountInput = document.getElementById('discount_percent');
            let discountValue = parseFloat(discountInput.value);

            if (discountValue > 100) {
                e.preventDefault(); // Mencegah form dikirim
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Diskon tidak valid! Persentase tidak boleh lebih dari 100%.',
                    confirmButtonText: 'OK'
                });
                discountInput.value = ''; // Kosongkan input jika lebih dari 100%
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
