<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Mendapatkan parameter dari URL
$bookId = $_GET['bookId'] ?? '';
$bookNameLower = $_GET['bookNameLower'] ?? '';

// Validasi parameter
if (empty($bookId) || empty($bookNameLower)) {
    die("Parameter bookId atau bookNameLower tidak ditemukan!");
}

// URL API untuk mendapatkan detail drama
$apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250417/in/movie/' . urlencode($bookId) . '/' . urlencode($bookNameLower) . '.json';
$data = file_get_contents($apiUrl);

$dramaDetails = [];
if ($data !== false) {
    $dataArray = json_decode($data, true);
    $dramaDetails = $dataArray['pageProps']['bookInfo'] ?? [];
}

// Jika data tidak ditemukan, tampilkan pesan error
if (empty($dramaDetails)) {
    $error = "Detail drama tidak ditemukan.";
}
?>


<?php include 'components/header.php'; ?>

<main class="flex flex-col items-center p-4 space-y-4">
    <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-600 p-4 rounded-lg w-full md:w-2/3">
            <p><?= htmlspecialchars($error); ?></p>
        </div>
    <?php else: ?>
        <section class="w-full md:w-2/3 bg-white p-4 rounded-lg">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="<?= htmlspecialchars($dramaDetails['cover'] ?? ''); ?>" alt="<?= htmlspecialchars($dramaDetails['bookName'] ?? ''); ?>" class="w-full md:w-1/3 rounded-lg shadow-md">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($dramaDetails['bookName'] ?? ''); ?></h1>
                    <p class="text-gray-600 mb-4">Views: <?= htmlspecialchars(number_format($dramaDetails['viewCount'] ?? 0)); ?></p>
                    <p class="text-gray-600 mb-4">Follows: <?= htmlspecialchars(number_format($dramaDetails['followCount'] ?? 0)); ?></p>
                    <p class="text-gray-800 mb-4"><?= htmlspecialchars($dramaDetails['introduction'] ?? ''); ?></p>
                    <a href="watchDrama.php?bookId=<?= urlencode($bookId); ?>&bookNameLower=<?= urlencode($bookNameLower); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition inline-block mt-4">
                        Tonton Drama
                    </a>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-2xl font-semibold mb-4">Kategori</h2>
                <ul class="list-disc pl-6">
                    <?php foreach ($dramaDetails['typeTwoNames'] ?? [] as $category): ?>
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset">
                            <?= htmlspecialchars($category); ?>
                        </span>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <!-- Tambahan tombol kembali ke Home -->
    <a href="index.php" class="fixed bottom-4 right-4 bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
    </a>
</main>

<?php include 'components/footer.php'; ?>
