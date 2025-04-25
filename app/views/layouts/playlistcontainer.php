<h2 class="text-3xl font-bold text-white mb-2">Playlist</h2>

<div class="relative px-4 w-full">

<?php foreach ($playlists as $playlist): ?>
  <?= $this->insert('playlist/playlistcard', [
      'playlist' => $playlist,
      'asset' => fn($p) => BASE_URL . '/' . ltrim($p, '/')
  ]) ?>
<?php endforeach; ?>
</div>
