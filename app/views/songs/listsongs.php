<?php if (!isset($songs) || count($songs) === 0) return; ?>

<div class="flex flex-col gap-3">
  <?php foreach ($songs as $song): ?>
    <div 
      class="songcard flex items-center gap-3 cursor-pointer hover:bg-[#2a2a2a] p-2 rounded transition"
      data-songcard="<?= $song['id'] ?>"
      data-title="<?= htmlspecialchars($song['title']) ?>"
      data-artist="<?= htmlspecialchars($song['artist'] ?? 'Unknown') ?>"
      data-thumb="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
      data-file="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['filename']) ?>"
    >
      <img
        src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
        alt="<?= htmlspecialchars($song['title']) ?>"
        class="w-14 h-14 rounded object-cover"
      >
      <div>
        <p class="font-semibold"><?= htmlspecialchars($song['title']) ?></p>
        <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
(function () {
  const phpPlaylist = <?= json_encode(array_map(function ($s) {
      return [
          'id' => $s['id'],
          'title' => $s['title'],
          'artist' => $s['artist'],
          'thumbnail' => BASE_URL . '/uploads/thumbnails/' . $s['thumbnail'],
          'file' => BASE_URL . '/uploads/songs/' . $s['filename']
      ];
  }, $songs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

  const isJSValid = window.currentPlaylist && Array.isArray(window.currentPlaylist) && window.currentPlaylist.length > 0;
  const isPHPValid = Array.isArray(phpPlaylist) && phpPlaylist.length > 0;

  if (!isJSValid && isPHPValid) {
    console.log("📥 Gán currentPlaylist từ PHP (listsongs.php)");
    setCurrentPlaylist(phpPlaylist);
  } else {
    console.log("✅ KHÔNG gán currentPlaylist từ PHP (listsongs.php) vì đã có danh sách hoặc PHP rỗng");
  }
})();
</script>
