<?php
session_start();
include 'Database/koneksi.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM transactions ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="dashboard.php" class="btn btn-warning mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>

        <h2 class="text-center">Riwayat Transaksi</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Awal</th>
                        <th>Diskon (%)</th>
                        <th>Harga Akhir</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                        <td>Rp<?php echo number_format($row['original_price'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['discount_percent']; ?>%</td>
                        <td>Rp<?php echo number_format($row['final_price'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
