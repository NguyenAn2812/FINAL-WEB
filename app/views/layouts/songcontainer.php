<h2 class="text-3xl font-bold text-white mb-4">Songs</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>