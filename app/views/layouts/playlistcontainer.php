<div class="flex flex-wrap gap-4">
  <?php foreach ($playlists as $playlist): ?>
    <?= $this->insert('playlist/playlistcard', ['playlist' => $playlist]) ?>
  <?php endforeach; ?>
</div>
