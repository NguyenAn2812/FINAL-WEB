<div class="flex w-full gap-6">
    <!-- LEFT: SONG THUMBNAIL -->
    <div class="w-2/3 p-6 flex justify-center items-center">
        <img src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['thumbnail']) ?>"
             class="w-[500px] h-[500px] object-cover rounded shadow-lg" alt="<?= htmlspecialchars($song['title']) ?>">
    </div>

    <!-- RIGHT: INFO + LIST -->
    <div class="w-1/3 p-6 flex flex-col">
        <!-- INFO -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold"><?= htmlspecialchars($song['title']) ?></h1>
            <p class="text-sm text-gray-400 mt-1">Người đăng: <?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>

        </div>

        <!-- LIST -->
        <div class="flex-1 overflow-y-auto">
            <h3 class="text-lg font-semibold mb-4">🎵 Danh sách phát</h3>
            <?php $this->insert('songs/listsongs', ['songs' => $songs]); ?>
        </div>
    </div>
</div>
