<div 
onclick='playSong(
    "<?= $this->asset("/uploads/songs/{$song['filename']}") ?>",
    "<?= htmlspecialchars($song['title'], ENT_QUOTES) ?>",
    "<?= htmlspecialchars($song['artist'] ?? 'Unknown', ENT_QUOTES) ?>",
    "<?= $this->asset("/uploads/songs/{$song['thumbnail']}") ?>"
); loadSongDisplay(<?= $song['id'] ?>);'
class="cursor-pointer bg-[#1e1e1e] rounded p-4 w-60 shadow mx-2 my-2 hover:bg-[#2a2a2a] transition">

    <img src="<?= $this->asset("/uploads/songs/{$song['thumbnail']}") ?>"
         class="w-full h-32 object-cover rounded mb-2"
         alt="<?= htmlspecialchars($song['title']) ?>">

    <h3 class="text-lg font-semibold"><?= htmlspecialchars($song['title']) ?></h3>
    <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>
</div>
