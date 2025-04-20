<?php
ini_set('display_errors', 0);
$searchQuery = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchQuery = htmlspecialchars($_GET['search']);
    $apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250417/in/search.json?searchValue=' . urlencode($searchQuery);
    $data = file_get_contents($apiUrl);

    if ($data !== false) {
        $dataArray = json_decode($data, true);
        $results = $dataArray['pageProps']['bookList'];
    }
}
?>

<?php include 'components/header.php'; ?>
<main class="flex flex-col items-center p-4 space-y-4">
  <section class="w-full md:w-2/3 bg-white p-4 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Pencarian</h2>
    <form action="searchDrama.php" method="GET" class="flex items-center space-x-2">
      <input type="text" name="search" value="<?= htmlspecialchars($searchQuery); ?>" class="w-full p-2 border rounded-lg" placeholder="Cari buku atau judul..." required>
      <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg">Cari</button>
    </form>
  </section>

  <?php if ($searchQuery): ?>
    <section class="w-full md:w-2/3 bg-white p-4 rounded-lg">
      <h3 class="text-xl font-semibold mb-4">Hasil Pencarian untuk: "<?= htmlspecialchars($searchQuery); ?>"</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (count($results) > 0): ?>
          <?php foreach ($results as $book): ?>
            <div class="bg-gray-100 p-4 rounded-md shadow-md relative">
              <div class="relative">
                <img src="<?= htmlspecialchars($book['coverWap']); ?>" alt="<?= htmlspecialchars($book['bookName']); ?>" class="w-full h-auto rounded-md mb-2" loading="lazy">
                <a href="watchDrama.php?bookId=<?= urlencode($book['bookId']); ?>&bookNameLower=<?= urlencode($book['bookNameLower']); ?>" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-6 py-2 rounded-lg text-center hover:bg-blue-600 transition">
                  Tonton
                </a>
              </div>
              <div class="mt-4">
                <h4 class="text-lg font-semibold"><?= htmlspecialchars($book['bookName']); ?></h4>
                <p><?= nl2br(htmlspecialchars($book['introduction'])); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Tidak ada hasil yang ditemukan.</p>
        <?php endif; ?>
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
