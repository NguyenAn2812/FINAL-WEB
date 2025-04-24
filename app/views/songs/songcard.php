<div class="relative">

<div class="songcard" data-songcard="<?= $song['id'] ?>"
     data-title="<?= htmlspecialchars($song['title']) ?>"
     data-artist="<?= htmlspecialchars($song['artist']) ?>"
     data-thumb="<?= htmlspecialchars($song['thumbnail']) ?>"
     data-file="<?= htmlspecialchars($song['file']) ?>">
    <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
         class="w-full h-32 object-cover rounded mb-2"
         alt="<?= htmlspecialchars($song['title']) ?>">

    <h3 class="text-lg font-semibold"><?= htmlspecialchars($song['title']) ?></h3>
    <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
    
</div>
<button
    onclick="openAddToPlaylistModal(event, <?= $song['id'] ?>)"
    class="absolute top-2 right-2 z-10 px-2 rounded"
  >
    &#8942;
  </button>
</div>
