<h2 class="text-3xl font-bold text-white mb-4">Playlist</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 justify-items-center">

<?php foreach ($playlists as $playlist): ?>
  <?= $this->insert('playlist/playlistcard', [
      'playlist' => $playlist,
      'asset' => fn($p) => BASE_URL . '/' . ltrim($p, '/')
  ]) ?>
<?php endforeach; ?>
</div>