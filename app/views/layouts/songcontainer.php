<p>🔍 DEBUG: $songs có tồn tại không? <?= isset($songs) ? 'CÓ' : 'KHÔNG' ?></p>
<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>
