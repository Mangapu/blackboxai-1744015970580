<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/SuratController.php';

$auth = new AuthController();
$auth->redirectIfNotLoggedIn();

$suratController = new SuratController();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_surat = $_POST['nomor_surat'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $perihal = $_POST['perihal'] ?? '';
    $pengirim = $_POST['pengirim'] ?? '';

    if ($suratController->addSuratMasuk($nomor_surat, $tanggal, $perihal, $pengirim)) {
        $success = 'Surat masuk berhasil ditambahkan';
    } else {
        $error = 'Gagal menambahkan surat masuk. Nomor surat mungkin sudah ada.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Surat Masuk - Kecamatan Masama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>
    
    <div class="flex">
        <?php include 'includes/nav.php'; ?>
        
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Input Surat Masuk</h1>
                <a href="dashboard.php" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nomor_surat" class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                            <input type="text" id="nomor_surat" name="nomor_surat" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: 001/UM/MASAMA/2023">
                        </div>
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                            <input type="date" id="tanggal" name="tanggal" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                        <input type="text" id="perihal" name="perihal" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Perihal surat">
                    </div>
                    <div>
                        <label for="pengirim" class="block text-sm font-medium text-gray-700">Pengirim</label>
                        <input type="text" id="pengirim" name="pengirim" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Nama instansi pengirim">
                    </div>
                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i> Simpan Surat
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>