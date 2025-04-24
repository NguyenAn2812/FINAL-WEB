<h2 class="text-3xl font-bold text-white mb-4">Playlist</h2>
<?php foreach ($playlists as $playlist): ?>
  <?= $this->insert('playlist/playlistcard', [
      'playlist' => $playlist,
      'asset' => fn($p) => BASE_URL . '/' . ltrim($p, '/')
  ]) ?>
<?php endforeach; ?>