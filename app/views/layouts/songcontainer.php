<h2 class="text-3xl font-bold text-white mb-4">Songs</h2>
<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>

