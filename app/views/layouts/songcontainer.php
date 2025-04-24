<h2 class="text-3xl font-bold text-white mb-4">Songs</h2>
<div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-7 gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>