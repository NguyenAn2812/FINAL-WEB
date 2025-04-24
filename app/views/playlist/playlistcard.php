<div 
  class="w-44 cursor-pointer transition hover:scale-105 hover:shadow-lg relative" 
  onclick="playPlaylist(<?= $playlist['id'] ?>)"
  data-playlistcard="<?= $playlist['id'] ?>"
>
  <div class="relative">
    <img 
      src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($playlist['thumbnail']) ?>" 
      alt="Playlist Thumbnail" 
      class="w-full h-44 object-cover rounded-xl"
    >
    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 rounded-xl opacity-0 hover:opacity-100 transition">
      <i class="mdi mdi-play text-white text-4xl"></i>
    </div>
  </div>
  <div class="mt-2">
    <p class="text-white font-semibold truncate"><?= $playlist['name'] ?></p>
    <p class="text-gray-400 text-sm truncate">Playlist • <?= $playlist['creator'] ?? 'Unknown' ?></p>
  </div>
</div>
