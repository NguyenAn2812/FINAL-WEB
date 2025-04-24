<div class="flex w-full h-[calc(100vh-150px)]">
  <!-- LEFT: PLAYLIST INFO -->
  <div class="w-2/3 p-6 flex flex-col justify-center items-center">
    <img src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($playlist['thumbnail']) ?>"
         class="w-[500px] h-[500px] object-cover rounded shadow-lg mb-4"
         alt="<?= htmlspecialchars($playlist['name']) ?>">

    <div class="text-center">
      <h1 class="text-2xl font-bold"><?= htmlspecialchars($playlist['name']) ?></h1>
      <p class="text-sm text-gray-400 mt-1">
        Created by: <?= htmlspecialchars($playlist['username'] ?? 'Unknown') ?>
      </p>
      <?php if (!empty($playlist['description'])): ?>
        <p class="text-sm text-gray-300 mt-2 italic">
          <?= htmlspecialchars($playlist['description']) ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- ✅ NÚT CHỨC NĂNG -->
    <div class="flex justify-center mt-6 gap-4">
      <!-- PLAY -->
      <button onclick="playPlaylist(<?= $playlist['id'] ?>)" 
              class="bg-green-600 hover:bg-green-700 px-4 py-1 rounded text-sm text-white">
        ▶ Play
      </button>

      <!-- SHUFFLE -->
      <button onclick="shufflePlaylist(<?= $playlist['id'] ?>)" 
              class="bg-blue-600 hover:bg-blue-700 px-4 py-1 rounded text-sm text-white">
        🔀 Shuffle
      </button>

      <!-- SHARE -->
      <button onclick="sharePlaylist(<?= $playlist['id'] ?>)" 
              class="bg-gray-700 hover:bg-gray-600 px-4 py-1 rounded text-sm text-white">
        🔗 Share
      </button>
    </div>
  </div>

  <!-- RIGHT: SONGS IN PLAYLIST -->
  <div class="w-1/3 p-6 border-l border-[#303030] overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4">Songs in playlist</h3>

    <?php if (empty($songs)): ?>
      <p class="text-sm text-gray-400">There are no songs in this playlist yet.</p>
    <?php else: ?>
      <?php foreach ($songs as $song): ?>
        <div 
          data-songcard="<?= $song['id'] ?>"
          onclick="playSong(
              '<?= BASE_URL ?>/uploads/songs/<?= $song['filename'] ?>',
              '<?= addslashes($song['title']) ?>',
              '<?= addslashes($song['artist'] ?? 'Unknown') ?>',
              '<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>',
              <?= $song['id'] ?>
          )"
          class="flex items-center gap-3 cursor-pointer hover:bg-[#2a2a2a] p-2 rounded transition"
        >
          <img
            src="<?= BASE_URL ?>/uploads/thumbnails/<?= htmlspecialchars($song['thumbnail']) ?>"
            alt="<?= htmlspecialchars($song['title']) ?>"
            class="w-14 h-14 rounded object-cover"
          >
          <div>
            <p class="font-semibold"><?= htmlspecialchars($song['title']) ?></p>
            <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
