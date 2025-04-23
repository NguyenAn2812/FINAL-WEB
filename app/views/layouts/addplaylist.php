<div id="addToPlaylistModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-gray-800 p-6 rounded-lg w-[400px]">
    <h2 class="text-xl font-bold mb-4">Thêm vào Playlist</h2>

    <form id="addToPlaylistForm">
      <?php if (!empty($playlists)): ?>
        <?php foreach ($playlists as $playlist): ?>
          <label class="flex items-center space-x-2 mb-2">
            <input type="checkbox" name="playlist_ids[]" value="<?= $playlist['id'] ?>" />
            <span><?= htmlspecialchars($playlist['name']) ?></span>
          </label>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-gray-300 text-sm mb-4 italic">Bạn chưa có playlist nào.</p>
      <?php endif; ?>

      <input type="hidden" name="song_id" value="<?= $songId ?>">

      <div class="mt-4 flex justify-between items-center">
        <a href="<?= BASE_URL ?>/component/addplaylist"
           class="text-sm text-blue-400 hover:underline">
           ➕ Tạo playlist mới
        </a>

        <div>
          <button type="submit" class="bg-blue-600 px-4 py-1 rounded text-sm">Thêm</button>
          <button type="button" onclick="closeAddToPlaylistModal()" class="ml-2 text-sm">Hủy</button>
        </div>
      </div>
    </form>
  </div>
</div>
