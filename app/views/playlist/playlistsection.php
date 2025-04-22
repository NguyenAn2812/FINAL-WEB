<div class="flex items-center justify-between mb-2">
    <h2 class="text-xl font-bold"><?= htmlspecialchars($playlistName) ?></h2>
    <div class="space-x-2">
        <button onclick="scrollPlaylist(<?= $playlistId ?>, -1)" class="scroll-btn">&#8249;</button>
        <button onclick="scrollPlaylist(<?= $playlistId ?>, 1)" class="scroll-btn">&#8250;</button>
    </div>
</div>

<div id="playlistScroll<?= $playlistId ?>" class="flex overflow-x-auto gap-4 pb-2">
    <?php foreach ($songs as $song): ?>
        <div 
            class="min-w-[240px] bg-[#1e1e1e] rounded shadow p-3 cursor-pointer hover:bg-[#2a2a2a] transition playlist-card"
            onclick='playSong(
                "<?= BASE_URL ?>/uploads/songs/<?= $song['filename'] ?>",
                "<?= addslashes($song['title']) ?>",
                "<?= addslashes($song['artist']) ?>",
                "<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>",
                <?= $song['id'] ?>
            )'
        >
            <img src="<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>"
                 alt="<?= htmlspecialchars($song['title']) ?>"
                 class="w-full h-32 object-cover rounded mb-2">
            <p class="font-semibold"><?= htmlspecialchars($song['title']) ?></p>
            <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<script>
function scrollPlaylist(playlistId, direction) {
    const container = document.getElementById("playlistScroll" + playlistId);
    const card = container.querySelector(".playlist-card");
    if (!card) return;
    const cardWidth = card.offsetWidth + 20;
    container.scrollLeft += direction * cardWidth;
}
</script>
