<div class="relative w-full aspect-square bg-[#1f1f1f] rounded overflow-hidden shadow group">

  <div class="songcard w-full h-full p-2 cursor-pointer flex flex-col justify-between"
    data-songcard="<?= $song['id'] ?>"
    data-title="<?= htmlspecialchars($song['title'] ?? '') ?>"
    data-artist="<?= htmlspecialchars($song['artist'] ?? '') ?>"
    data-thumb="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
    data-file="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['filename'] ?? '') ?>">
    <div class="w-full aspect-square overflow-hidden rounded mb-2">
      <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
        class="w-full h-full object-cover"
        alt="<?= htmlspecialchars($song['title'] ?? '') ?>">
    </div>

    <h3 class="text-base font-semibold truncate"><?= htmlspecialchars($song['title'] ?? '') ?></h3>
    <p class="text-sm text-gray-400 truncate"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
  </div>

  <button
    onclick="openAddToPlaylistModal(event, <?= $song['id'] ?>)"
    class="absolute top-2 right-2 z-10 px-2 rounded bg-black/60 hover:bg-black/80">
    <img src="<?= BASE_URL ?>/images/more.png" alt="more button" class="w-6 shadow-lg">
  </button>
</div>
