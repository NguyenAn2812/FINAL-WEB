<h2 class="text-3xl font-bold text-white mb-2">Playlist</h2>

<div class="relative px-4 overflow-hidden w-full">
<div class="grid grid-cols-5 gap-4">
<?php foreach ($playlists as $playlist): ?>
  <?= $this->insert('playlist/playlistcard', [
      'playlist' => $playlist,
      'asset' => fn($p) => BASE_URL . '/' . ltrim($p, '/')
  ]) ?>
<?php endforeach; ?>
  </div>
</div>
