<div class="w-[200px] md:w-[220px] lg:w-[240px] cursor-pointer transition hover:scale-105 hover:drop-shadow-[0_0_10px_white] relative rounded overflow-hidden">
<div 
  class="playlistcard w-full h-full p-2 cursor-pointer flex flex-col justify-between"
  onclick="openPlaylistDisplay(<?= $playlist['id'] ?>)"
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

</div>

