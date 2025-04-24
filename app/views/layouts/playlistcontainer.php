<?php foreach ($playlists as $playlist): ?>
  <?= $this->render('playlist/playlistcard', [
        'playlist' => $playlist,
        'asset' => fn($p) => BASE_URL . '/' . ltrim($p, '/')
    ]) ?>
<?php endforeach; ?>