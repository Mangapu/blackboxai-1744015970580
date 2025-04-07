<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
$auth = new AuthController();
?>
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-auto" src="assets/logo.png" alt="Logo Kecamatan Masama">
            </div>
            <div class="ml-4">
                <h1 class="text-xl font-bold text-gray-900">Sistem Surat</h1>
                <p class="text-sm text-gray-500">Kecamatan Masama, Kab. Banggai</p>
            </div>
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
</header>

<?php
if (isset($_GET['logout'])) {
    $auth->logout();
    header('Location: index.php');
    exit();
}
?>