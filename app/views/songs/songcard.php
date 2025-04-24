<div class="w-44 cursor-pointer transition hover:scale-105 hover:shadow-lg relative">

  <div class="songcard w-full h-full cursor-pointer flex flex-col justify-between"
    data-songcard="<?= $song['id'] ?>"
    data-title="<?= htmlspecialchars($song['title'] ?? '') ?>"
    data-artist="<?= htmlspecialchars($song['artist'] ?? '') ?>"
    data-thumb="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
    data-file="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['filename'] ?? '') ?>">

    <!-- Ảnh thumbnail -->
    <div class="w-full aspect-square overflow-hidden rounded">
      <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
        class="w-full h-full object-cover"
        alt="<?= htmlspecialchars($song['title'] ?? '') ?>">
    </div>

    <div class="mt-2">
      <h3 class="text-sm font-semibold truncate"><?= htmlspecialchars($song['title'] ?? '') ?></h3>
      <p class="text-xs text-gray-400 truncate"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
    </div>
  </div>

  <button
    onclick="openAddToPlaylistModal(event, <?= $song['id'] ?>)"
    class="absolute top-2 right-2 z-10 px-2 rounded hover:bg-black/80">
    <img src="<?= BASE_URL ?>/images/more.png" alt="more button" class="w-5 shadow">
  </button>
</div>
