<div id="addToPlaylistModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-gray-800 p-6 rounded-lg w-[400px]">
    <h2 class="text-xl font-bold mb-4">Thêm vào Playlist</h2>

    <?php if (empty($playlists)): ?>
      <p class="text-gray-300 mb-4">Bạn chưa có playlist nào.</p>
      <a href="<?= BASE_URL ?>/component/addplaylist"
         class="inline-block bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-700 text-sm">
         ➕ Tạo playlist mới
      </a>
    <?php else: ?>
      <form id="addToPlaylistForm">
        <?php foreach ($playlists as $playlist): ?>
          <label class="flex items-center space-x-2 mb-2">
            <input type="checkbox" name="playlist_ids[]" value="<?= $playlist['id'] ?>" />
            <span><?= htmlspecialchars($playlist['name']) ?></span>
          </label>
        <?php endforeach; ?>

        <input type="hidden" name="song_id" value="<?= $songId ?>">

        <div class="mt-4 text-right">
          <button type="submit" class="bg-blue-600 px-4 py-2 rounded">Thêm</button>
          <button type="button" onclick="closeAddToPlaylistModal()" class="ml-2">Hủy</button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>
