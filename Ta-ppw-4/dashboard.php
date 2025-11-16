<?php
session_start();

// Guard: Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$kontak_list = $_SESSION['kontak'] ?? [];
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';

unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-slate-900">Dashboard Kontak</h1>
                <p class="text-slate-700 mt-2">
                    Selamat datang, 
                    <span class="font-semibold text-blue-700">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>
                </p>
            </div>

            <a 
                href="logout.php" 
                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition"
            >
                Logout
            </a>
        </div>

        <!-- Pesan -->
        <?php if (!empty($success_message)): ?>
            <div class="mb-4 p-4 bg-blue-100 border border-blue-300 text-blue-700 rounded-lg">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-600 rounded-lg">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Grid 3 Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Form Tambah Kontak -->
            <div>
                <div class="bg-white border border-blue-100 p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Tambah Kontak Baru</h3>

                    <form method="POST" action="proses_tambah.php" class="space-y-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-slate-800 mb-2">Nama</label>
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                                       focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800"
                                placeholder="Nama lengkap"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-800 mb-2">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                                       focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800"
                                placeholder="email@example.com"
                            >
                        </div>

                        <div>
                            <label for="telepon" class="block text-sm font-medium text-slate-800 mb-2">Telepon</label>
                            <input 
                                type="tel" 
                                id="telepon" 
                                name="telepon" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                                       focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800"
                                placeholder="08123456789"
                            >
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition"
                        >
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Daftar Kontak -->
            <div class="md:col-span-2">
                <div class="bg-white border border-blue-100 p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Daftar Kontak</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-blue-200 bg-blue-50">
                                    <th class="text-left px-4 py-3 font-semibold text-slate-800">No</th>
                                    <th class="text-left px-4 py-3 font-semibold text-slate-800">Nama</th>
                                    <th class="text-left px-4 py-3 font-semibold text-slate-800">Email</th>
                                    <th class="text-left px-4 py-3 font-semibold text-slate-800">Telepon</th>
                                    <th class="text-center px-4 py-3 font-semibold text-slate-800">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (empty($kontak_list)): ?>
                                    <tr class="border-b border-gray-300">
                                        <td colspan="5" class="text-center px-4 py-6 text-slate-600">
                                            Belum ada data kontak
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($kontak_list as $index => $kontak): ?>
                                        <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                            <td class="px-4 py-3 text-slate-800"><?php echo $index + 1; ?></td>
                                            <td class="px-4 py-3 text-slate-800"><?php echo htmlspecialchars($kontak['nama']); ?></td>
                                            <td class="px-4 py-3 text-slate-800"><?php echo htmlspecialchars($kontak['email']); ?></td>
                                            <td class="px-4 py-3 text-slate-800"><?php echo htmlspecialchars($kontak['telepon']); ?></td>

                                            <td class="px-4 py-3 text-center">
                                                <a 
                                                    href="edit.php?id=<?php echo urlencode($kontak['id']); ?>" 
                                                    class="inline-block bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-1 px-3 rounded mr-2 transition"
                                                >
                                                    Edit
                                                </a>

                                                <a 
                                                    href="hapus.php?id=<?php echo urlencode($kontak['id']); ?>" 
                                                    class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded transition"
                                                    onclick="return confirm('Yakin ingin menghapus kontak ini?');"
                                                >
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
