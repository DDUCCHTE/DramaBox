<?php
ini_set('display_errors', 0);
if (isset($_GET['bookId']) && isset($_GET['bookNameLower'])) {
  $bookId = htmlspecialchars($_GET['bookId']);
  $bookNameLower = htmlspecialchars($_GET['bookNameLower']);
  $apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250417/in/movie/' . $bookId . '/' . $bookNameLower . '.json';
  $data = file_get_contents($apiUrl);

  if ($data === false) {
    die('Error fetching data');
  }

  $dataArray = json_decode($data, true);

  if (!isset($dataArray['pageProps']['chapterList']) || empty($dataArray['pageProps']['chapterList'])) {
    die('Error: chapterList not found or is empty');
  }

  $chapterList = $dataArray['pageProps']['chapterList'];

  $firstEpisode = $chapterList[0];
  $firstEpisodeCover = $firstEpisode['cover'];
  $firstEpisodeVideoUrl = str_replace('.mp4.jpg@w=100&h=135', '.720p.narrowv3.mp4', $firstEpisodeCover);

  $bookInfo = $dataArray['pageProps']['bookInfo'];
  $bookName = $bookInfo['bookName'];
  $chapterCount = $bookInfo['chapterCount'];
} else {
  die('Error: Missing bookId or bookNameLower');
}
?>

<?php include 'components/header.php'; ?>

<head>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/episode.css">
</head>

<main class="flex flex-col md:flex-row justify-center items-start p-4 space-y-4 md:space-y-0 md:space-x-4">
  <section class="w-full md:w-2/3 bg-black rounded-lg overflow-hidden">
    <video id="videoPlayer" class="w-full h-auto object-cover" controls>
      <source id="videoSource" src="<?= htmlspecialchars($firstEpisodeVideoUrl); ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </section>

  <section class="w-full md:w-2/3 lg:w-64 bg-white p-4 rounded-lg space-y-4">
    <h2 id="episodeTitle" class="text-xl font-semibold" data-total="<?= htmlspecialchars($chapterCount); ?>">Episode [1/<?= htmlspecialchars($chapterCount); ?>]</h2>
    <div class="max-h-96 overflow-y-auto">
      <div class="grid grid-cols-3 gap-4" id="episodeList">
        <?php
        foreach ($chapterList as $index => $episode) {
          $formattedIndex = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
          $episodeCover = $episode['cover'];
          if ($episodeCover) {
            $videoUrl = str_replace('.mp4.jpg@w=100&h=135', '.720p.narrowv3.mp4', $episodeCover);
        ?>
            <a href="#" class="episode-button block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-center" data-episode="<?= $formattedIndex; ?>" data-video="<?= htmlspecialchars($videoUrl); ?>">
              <?= $formattedIndex; ?>
            </a>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </section>
  <a href="index.php" class="fixed bottom-4 right-4 bg-blue-500 text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
    </svg>
  </a>
</main>

<?php include 'components/footer.php'; ?>
<script src="assets/js/episode.js"></script>

</body>
