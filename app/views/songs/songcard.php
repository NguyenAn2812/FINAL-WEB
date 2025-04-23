<div class="relative">

<div 
    onclick='playSong(
            "<?= $this->asset("/uploads/songs/{$song['filename']}") ?>",
            "<?= addslashes($song['title']) ?>",
            "<?= addslashes($song['artist'] ?? 'Unknown') ?>",
            "<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>",
            <?= $song['id'] ?>
        )'
    class="cursor-pointer bg-[#1e1e1e] rounded p-4 w-60 shadow mx-2 my-2 hover:bg-[#2a2a2a] transition">

    <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
         class="w-full h-32 object-cover rounded mb-2"
         alt="<?= htmlspecialchars($song['title']) ?>">

    <h3 class="text-lg font-semibold"><?= htmlspecialchars($song['title']) ?></h3>
    <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
    
</div>
<button
    onclick="openAddToPlaylistModal(event, <?= $song['id'] ?>)"
    class="absolute top-2 right-2 z-10 bg-black/50 px-2 rounded"
  >
    &#8942;
  </button>
</div>
