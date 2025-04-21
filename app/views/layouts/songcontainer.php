<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>