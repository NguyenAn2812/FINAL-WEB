<div id="addToPlaylistModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-gray-800 p-6 rounded-lg w-[400px] text-white">
    <h2 class="text-xl font-bold mb-4" id="playlistModalTitle">Thêm vào Playlist</h2>

    <!-- FORM CHỌN PLAYLIST -->
    <div id="choosePlaylistSection">
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
          <button type="button" onclick="toggleCreatePlaylist(true)"
                  class="text-sm text-blue-400 hover:underline">➕ Tạo playlist mới</button>

          <div>
            <button type="submit" class="bg-blue-600 px-4 py-1 rounded text-sm">Thêm</button>
            <button type="button" onclick="closeAddToPlaylistModal()" class="ml-2 text-sm">Hủy</button>
          </div>
        </div>
      </form>
    </div>

    <!-- FORM TẠO PLAYLIST -->
    <div id="createPlaylistSection" class="hidden">
      <form id="createPlaylistForm" enctype="multipart/form-data">
        <label class="block mb-2 text-sm">Tên Playlist</label>
        <input type="text" name="name" required class="w-full mb-3 p-2 rounded bg-gray-700 text-white text-sm">

        <label class="block mb-2 text-sm">Ảnh Thumbnail</label>
        <input type="file" name="thumbnail" accept="image/*" class="w-full mb-4 text-sm">

        <input type="hidden" name="song_id" value="<?= $songId ?>">

        <div class="flex justify-between mt-2">
          <button type="button" onclick="toggleCreatePlaylist(false)"
                  class="text-sm text-gray-400 hover:underline">⬅ Quay lại</button>

          <button type="submit" class="bg-green-600 px-4 py-1 rounded text-sm">Tạo</button>
        </div>
      </form>
    </div>
  </div>
</div>
