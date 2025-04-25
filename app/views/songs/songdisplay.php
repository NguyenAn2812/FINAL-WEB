<div class="flex w-full h-[calc(100vh-150px)]">
  <!-- LEFT: SONG THUMBNAIL + INFO -->
  <div class="w-2/3 p-6 flex flex-col justify-center items-center">
    <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
         class="w-[500px] h-[500px] object-cover rounded shadow-lg mb-4 drop-shadow-[0_0_10px_white]" 
         alt="<?= htmlspecialchars($song['title']) ?>">
    <div class="text-center">
      <h1 class="text-2xl font-bold"><?= htmlspecialchars($song['title']) ?></h1>
      <p class="text-sm text-gray-400 mt-1">Upload by: <?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>
    </div>
  </div>

  <!-- RIGHT: DANH SÁCH PHÁT -->
  <div class="w-1/3 p-6 border-l border-[#303030] overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4">Playlist</h3>
    <?php $this->insert('songs/listsongs', ['songs' => $songs]); ?>
  </div>
</div>
<script>
window.currentPlaylist = <?= json_encode($songs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script>
  window.isSongDisplayOpen = true;
</script>
