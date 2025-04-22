<div class="mb-8">
  <h2 class="text-lg font-semibold mb-3"><?= htmlspecialchars($title) ?></h2>

  <div class="flex flex-wrap gap-4">
    <?php foreach ($songs as $song): ?>
      <div 
        onclick='playSong(
          "<?= BASE_URL ?>/uploads/songs/<?= $song['filename'] ?>",
          "<?= addslashes($song['title']) ?>",
          "<?= addslashes($song['artist'] ?? 'Unknown') ?>",
          "<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>",
          <?= $song['id'] ?>
        )'
        class="cursor-pointer bg-[#1e1e1e] rounded p-4 w-60 shadow hover:bg-[#2a2a2a] transition"
      >
        <img
          src="<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>"
          alt="<?= htmlspecialchars($song['title']) ?>"
          class="w-full h-32 object-cover rounded mb-2"
        >
        <h3 class="text-base font-semibold"><?= htmlspecialchars($song['title']) ?></h3>
        <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>
