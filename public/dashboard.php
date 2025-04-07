<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/SuratController.php';

$auth = new AuthController();
$auth->redirectIfNotLoggedIn();

$suratController = new SuratController();

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_masuk'])) {
        $suratController->deleteSuratMasuk($_POST['delete_id']);
    } elseif (isset($_POST['delete_keluar'])) {
        $suratController->deleteSuratKeluar($_POST['delete_id']);
    }
    header('Location: dashboard.php');
    exit();
}

$totalMasuk = $suratController->getTotalSuratMasuk();
$totalKeluar = $suratController->getTotalSuratKeluar();
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;
$suratMasuk = $suratController->getSuratMasuk($searchTerm);
$suratKeluar = $suratController->getSuratKeluar($searchTerm);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Surat Kecamatan Masama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>
    
    <div class="flex">
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
            
            <!-- Debug Info -->
            <?php if ($searchTerm): ?>
            <div class="bg-blue-50 p-4 mb-4 rounded-lg">
                <p class="text-sm">Hasil pencarian untuk: <span class="font-semibold"><?= htmlspecialchars($searchTerm) ?></span></p>
                <p class="text-sm">Ditemukan <?= count($suratMasuk) ?> surat masuk dan <?= count($suratKeluar) ?> surat keluar</p>
            </div>
            <?php endif; ?>

            <!-- Form Pencarian Surat -->
            <div class="mb-6">
                <form method="GET" action="dashboard.php" class="flex space-x-4">
                    <input type="text" name="search" placeholder="Cari surat..." 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">Surat Masuk</h2>
                            <p class="text-3xl font-bold text-blue-600"><?= $totalMasuk ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700">Surat Keluar</h2>
                            <p class="text-3xl font-bold text-green-600"><?= $totalKeluar ?></p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-paper-plane text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Daftar Surat Terbaru -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Surat Masuk Terbaru</h2>
                        <a href="input_masuk.php" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach(array_slice($suratMasuk, 0, 5) as $surat): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($surat['nomor_surat']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d/m/Y', strtotime($surat['tanggal'])) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($surat['pengirim']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($surat['perihal']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <form method="POST" action="dashboard.php" class="inline">
                                            <input type="hidden" name="delete_id" value="<?= $surat['id'] ?>">
                                            <button type="submit" name="delete_masuk" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Surat Keluar Terbaru</h2>
                        <a href="input_keluar.php" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach(array_slice($suratKeluar, 0, 5) as $surat): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($surat['nomor_surat']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d/m/Y', strtotime($surat['tanggal'])) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($surat['tujuan']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($surat['perihal']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <form method="POST" action="dashboard.php" class="inline">
                                            <input type="hidden" name="delete_id" value="<?= $surat['id'] ?>">
                                            <button type="submit" name="delete_keluar" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Chart.js implementation
        const ctx = document.getElementById('statistikChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Surat Masuk',
                    data: [12, 19, 3, 5, 2, 3, 7, 8, 9, 10, 11, 12],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Surat Keluar',
                    data: [8, 15, 5, 7, 4, 5, 6, 7, 8, 9, 10, 11],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>