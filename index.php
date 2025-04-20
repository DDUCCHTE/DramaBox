<?php
ini_set('display_errors', 0);
$apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250417/in.json';
$data = file_get_contents($apiUrl);

$bigList = [];
$smallData = [];
if ($data !== false) {
    $dataArray = json_decode($data, true);
    $bigList = $dataArray['pageProps']['bigList'] ?? [];
    $smallData = $dataArray['pageProps']['smallData'] ?? [];
}

$translations = [
    '精彩剧集' => 'Drama Menarik',
    '当前热播' => 'Drama Terpopuler Saat Ini',
    '必看好剧' => 'Drama Wajib Tonton',
];

include 'components/header.php';
?>
<main class="flex flex-col items-center p-4 space-y-4">
    <?php if (count($bigList) > 0): ?>
        <section class="w-full md:w-2/3 bg-white p-4 rounded-lg mb-4">
            <h3 class="text-2xl font-semibold mb-4">Drama Pilihan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($bigList as $book): ?>
                    <div class="bg-gray-100 p-3 rounded-md shadow-md relative group">
                        <div class="relative">
                            <a href="detailDrama.php?bookId=<?= urlencode($book['bookId']); ?>&bookNameLower=<?= urlencode($book['bookNameLower']); ?>">
                                <img src="<?= htmlspecialchars($book['cover']); ?>"
                                    alt="<?= htmlspecialchars($book['bookName']); ?>"
                                    class="w-full h-auto rounded-md mb-2 transition-transform duration-300 ease-in-out transform group-hover:scale-105"
                                    loading="lazy">
                            </a>
                        </div>
                        <div class="mt-2">
                            <h4 class="text-lg font-semibold"><?= htmlspecialchars($book['bookName']); ?></h4>
                        </div>
                        <div class="mt-2 text-xs text-gray-500 max-h-0 overflow-hidden group-hover:max-h-20 group-hover:opacity-100 transition-all duration-300 ease-in-out opacity-0">
                            <p>Views: <?= htmlspecialchars($book['viewCountDisplay']); ?> | Eps: <?= htmlspecialchars($book['chapterCount']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (count($smallData) > 0): ?>
        <?php foreach ($smallData as $category): ?>
            <section class="w-full md:w-2/3 bg-white p-4 rounded-lg mb-8">
                <h3 class="text-2xl font-semibold mb-4">
                    <?= htmlspecialchars($translations[$category['name']] ?? $category['name']); ?>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($category['items'] as $book): ?>
                        <div class="bg-gray-100 p-3 rounded-md shadow-md relative group">
                            <div class="relative">
                                <a href="detailDrama.php?bookId=<?= urlencode($book['bookId']); ?>&bookNameLower=<?= urlencode($book['bookNameLower']); ?>">
                                    <img src="<?= htmlspecialchars($book['cover']); ?>"
                                        alt="<?= htmlspecialchars($book['bookName']); ?>"
                                        class="w-full h-auto rounded-md mb-2 transition-transform duration-300 ease-in-out transform group-hover:scale-105"
                                        loading="lazy">
                                </a>
                            </div>
                            <div class="mt-2">
                                <h4 class="text-lg font-semibold"><?= htmlspecialchars($book['bookName']); ?></h4>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 max-h-0 overflow-hidden group-hover:max-h-20 group-hover:opacity-100 transition-all duration-300 ease-in-out opacity-0">
                                <p>Views: <?= htmlspecialchars($book['viewCountDisplay']); ?> | Eps: <?= htmlspecialchars($book['chapterCount']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

</main>

<?php include 'components/footer.php'; ?>
