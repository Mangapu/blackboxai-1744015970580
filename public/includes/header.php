<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
$auth = new AuthController();
?>
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-auto" src="assets/banggai.png" alt="Logo Kabupaten Banggai">
            </div>
            <div class="ml-4">
                <h1 class="text-xl font-bold text-gray-900">Agenda Surat</h1>
                <p class="text-sm text-gray-500">Kecamatan Masama, Kab. Banggai</p>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <div class="flex space-x-4">
                <a href="dashboard.php" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Dashboard</a>
                <a href="input_masuk.php" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Surat Masuk</a>
                <a href="input_keluar.php" class="text-gray-700 hover:text-blue-600 text-sm font-medium">Surat Keluar</a>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">
                    <i class="fas fa-user-circle mr-1"></i>
                    <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
                </span>
                <a href="?logout" class="text-sm text-red-600 hover:text-red-800">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>

<?php
if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: index.php');
    exit();
}
?>