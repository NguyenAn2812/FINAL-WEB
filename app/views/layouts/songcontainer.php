<div class="flex flex-wrap gap-4">
  <?php if (!empty($songs) && is_array($songs)): ?>
    <?php foreach ($songs as $song): ?>
      <?php include __DIR__ . '/../songs/songcard.php'; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-gray-400">There are no songs to display.</p>
  <?php endif; ?>
</div>
