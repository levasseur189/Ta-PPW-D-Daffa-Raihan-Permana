<?php
session_start();

// Guard: Cek login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';

// Validasi ID
if (empty($id)) {
    header("Location: dashboard.php");
    exit;
}

$kontak_ditemukan = null;

// Cari kontak (ID)
if (isset($_SESSION['kontak'])) {
    foreach ($_SESSION['kontak'] as $kontak) {
        if ($kontak['id'] == $id) {
            $kontak_ditemukan = $kontak;
            break;
        }
    }
}

// Jika kontak tidak ditemukan
if ($kontak_ditemukan === null) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak - Sistem Kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen py-8">
        <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-8 border border-blue-100">
            
            <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">
                Edit Kontak: 
                <span class="text-blue-700">
                    <?php echo htmlspecialchars($kontak_ditemukan['nama']); ?>
                </span>
            </h2>
            
            <form method="POST" action="proses_edit.php" class="space-y-4">

                <input type="hidden" name="id" 
                       value="<?php echo htmlspecialchars($kontak_ditemukan['id']); ?>">

                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-800 mb-2">Nama</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        required 
                        value="<?php echo htmlspecialchars($kontak_ditemukan['nama']); ?>"
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
                        value="<?php echo htmlspecialchars($kontak_ditemukan['email']); ?>"
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
                        value="<?php echo htmlspecialchars($kontak_ditemukan['telepon']); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-blue-600 text-slate-800"
                        placeholder="08123456789"
                    >
                </div>

                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition"
                    >
                        Update
                    </button>

                    <a 
                        href="dashboard.php" 
                        class="flex-1 text-center border border-slate-300 text-slate-800 font-semibold py-2 px-4 rounded-lg hover:bg-slate-100 transition"
                    >
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
