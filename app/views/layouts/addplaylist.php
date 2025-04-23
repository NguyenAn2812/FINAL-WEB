<div id="addToPlaylistModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden">
  <div class="bg-gray-800 p-6 rounded-lg w-[400px]">
    <h2 class="text-xl font-bold mb-4">Playlist</h2>
    <form id="addToPlaylistForm">
      <?php foreach ($playlists as $playlist): ?>
        <label class="flex items-center space-x-2 mb-2">
          <input type="checkbox" name="playlist_ids[]" value="<?= $playlist['id'] ?>" />
          <span><?= htmlspecialchars($playlist['name']) ?></span>
        </label>
      <?php endforeach; ?>
      <input type="hidden" name="song_id" value="<?= $songId ?>">
      <div class="mt-4 text-right">
        <button type="submit" class="bg-blue-600 px-4 py-2 rounded">Add</button>
        <button type="button" onclick="closeAddToPlaylistModal()" class="ml-2">Cancel</button>
      </div>
    </form>
  </div>
</div>
