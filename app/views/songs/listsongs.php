<?php if (!isset($songs)) return; ?>

<div class="flex flex-col gap-3">
  <?php foreach ($songs as $song): ?>
    <div 
      data-songcard="<?= $song['id'] ?>"
      onclick="playSong(
        '<?= BASE_URL ?>/uploads/songs/<?= $song['filename'] ?>',
        '<?= addslashes($song['title']) ?>',
        '<?= addslashes($song['artist'] ?? 'Unknown') ?>',
        '<?= BASE_URL ?>/uploads/songs/thumbnails<?= $song['thumbnail'] ?>',
        <?= $song['id'] ?>
      )"
      class="flex items-center gap-3 cursor-pointer hover:bg-[#2a2a2a] p-2 rounded transition"
    >
      <img
        src="<?= BASE_URL ?>/uploads/thumbnails/<?= $song['thumbnail'] ?>"
        alt="<?= htmlspecialchars($song['title']) ?>"
        class="w-14 h-14 rounded object-cover"
      >
      <div>
        <p class="font-semibold"><?= htmlspecialchars($song['title']) ?></p>
        <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
setCurrentPlaylist(<?= json_encode(array_map(function ($s) {
    return [
        'id' => $s['id'],
        'title' => $s['title'],
        'artist' => $s['artist'],
        'thumbnail' => BASE_URL . '/uploads/thumbnails/' . $s['thumbnail'],
        'file' => BASE_URL . '/uploads/songs/' . $s['filename']
    ];
}, $songs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>);
</script>
