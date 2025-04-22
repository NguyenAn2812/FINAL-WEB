<div 
    onclick="openPlaylistDisplay(<?= $playlist['id'] ?>)"
    class="cursor-pointer bg-[#1e1e1e] rounded p-4 w-60 shadow mx-2 my-2 hover:bg-[#2a2a2a] transition"
>
    <img src="<?= BASE_URL ?>/uploads/playlist/<?= htmlspecialchars($playlist['thumbnail']) ?>"
         alt="<?= htmlspecialchars($playlist['name']) ?>"
         class="w-full h-32 object-cover rounded mb-2">

    <h3 class="text-lg font-semibold"><?= htmlspecialchars($playlist['name']) ?></h3>
</div>
