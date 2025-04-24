<div class="flex w-full h-[calc(100vh-150px)]">
  <!-- LEFT: PLAYLIST INFO -->
  <div class="w-2/3 p-6 flex flex-col justify-center items-center">
    <img id="main-playlist-thumbnail" src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($playlist['thumbnail']) ?>"
         class="w-[500px] h-[500px] object-cover rounded shadow-lg mb-4"
         alt="<?= htmlspecialchars($playlist['name']) ?>">

    <div class="text-center">
      <h1 class="text-2xl font-bold"><?= htmlspecialchars($playlist['name']) ?></h1>
      <p class="text-sm text-gray-400 mt-1">Created by: <?= htmlspecialchars($playlist['owner'] ?? 'Unknown') ?></p>

      <?php if (!empty($playlist['description'])): ?>
        <p class="text-sm text-gray-300 mt-2 italic"><?= htmlspecialchars($playlist['description']) ?></p>
      <?php endif; ?>

      <!-- BUTTONS -->
      <div class="flex justify-center gap-3 mt-4">
        <button onclick="shufflePlaylist(<?= $playlist['id'] ?>)"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
          🔀 Shuffle
        </button>

        <button onclick="playPlaylist(<?= $playlist['id'] ?>)"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
          ▶️ Play
        </button>

        <button onclick="sharePlaylist(<?= $playlist['id'] ?>)"
                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg shadow">
          📤 Share
        </button>
      </div>
    </div>
  </div>

  <!-- RIGHT: SONG LIST -->
  <div class="w-1/3 p-6 border-l border-[#303030] overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4">Danh sách bài hát</h3>
    <?php $this->insert('songs/listsongs', ['songs' => $songs]); ?>
  </div>
</div>
<script>
  currentPlaylist = <?= json_encode($songs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  originalPlaylist = [...currentPlaylist];
</script>