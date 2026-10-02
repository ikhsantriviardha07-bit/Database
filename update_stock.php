<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pesan = '';
$error = '';

$stmtAlat = $pdo->query("SELECT id, nama_alat, jumlah, kondisi FROM alat_lab");
$alatList = $stmtAlat->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $jumlah = $_POST['jumlah'] ?? null;

    if ($jumlah < 0 || !is_numeric($jumlah)) {
        $error = "Jumlah stock tidak boleh negatif atau berupa teks!";
    } else if (empty($id)) {
        $error = "Pilih alat terlebih dahulu!";
    } else {
        $stmtUpdate = $pdo->prepare("UPDATE alat_lab SET jumlah = :jumlah WHERE id = :id");
        $sukses = $stmtUpdate->execute([
            ':jumlah' => $jumlah,
            ':id' => $id
        ]);

        if ($sukses) {
            $pesan = "Berhasil mengupdate stock alat!";
            $stmtAlat = $pdo->query("SELECT id, nama_alat, jumlah, kondisi FROM alat_lab");
            $alatList = $stmtAlat->fetchAll();
        } else {
            $error = "Gagal mengupdate stock alat!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Stock Alat Lab</title>
</head>
<body>
    <h2>Update Stock Alat Lab</h2>
    <p><a href="dashboard.php">&laquo; Kembali ke Dashboard</a></p>

    <?php if ($pesan): ?><p style="color: green;"><?php echo htmlspecialchars($pesan); ?></p><?php endif; ?>
    <?php if ($error): ?><p style="color: red;"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>    

    <form method="POST" action="">
        <label>Pilih alat:</label><br>
        <select name="id" required>
            <option value="">-- Pilih Alat --</option>
            <?php foreach ($alatList as $alat): ?>
                <option value="<?php echo htmlspecialchars($alat['id']); ?>" <?php if (isset($_POST['id']) && $_POST['id'] == $alat['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($alat['nama_alat']); ?> (Stock: <?php echo htmlspecialchars($alat['jumlah']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Jumlah Stock baru:</label><br>
        <input type="number" name="jumlah" min="0" required><br><br>
        
        <button type="submit">Update Stock</button>
    </form>
</body>
</html>