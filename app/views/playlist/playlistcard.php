<div class="bg-[#202020] rounded-xl overflow-hidden hover:bg-[#2a2a2a] transition cursor-pointer"
     onclick="loadPlaylistDisplay(<?= $playlist['id'] ?>)">
     <img src="<?= asset('uploads/songs/' . $playlist['thumbnail']) ?>" class="w-full h-40 object-cover">
    <div class="p-3">
        <p class="font-semibold truncate"><?= htmlspecialchars($playlist['name']) ?></p>
        <p class="text-sm text-gray-400 truncate">
            <?= isset($playlist['creator']) ? htmlspecialchars($playlist['creator']) : 'Unknown' ?>
        </p>
    </div>
</div>
