<div class="relative">

  <div class="songcard"
    data-songcard="<?= $song['id'] ?>"
    data-title="<?= htmlspecialchars($song['title'] ?? '') ?>"
    data-artist="<?= htmlspecialchars($song['artist'] ?? '') ?>"
    data-thumb="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
    data-file="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['filename'] ?? '') ?>">

    <img src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail'] ?? '') ?>"
      class="w-full max-h-32 w-full object-cover rounded mb-2"
      alt="<?= htmlspecialchars($song['title'] ?? '') ?>">

    <h3 class="text-lg font-semibold"><?= htmlspecialchars($song['title'] ?? '') ?></h3>
    <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
  </div>

  <button
    onclick="openAddToPlaylistModal(event, <?= $song['id'] ?>)"
    class="absolute top-2 right-2 z-10 px-2 rounded">
    <img src="<?= BASE_URL ?>/image/more.png/" alt="more button" class="w-10 h-10 shadow-lg">
  </button>
</div>