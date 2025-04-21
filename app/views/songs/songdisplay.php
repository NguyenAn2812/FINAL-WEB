<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Cột trái: thumbnail lớn -->
  <div class="md:col-span-2">
    <div class="w-full h-[320px] overflow-hidden rounded mb-4">
      <img src="<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>"
           alt="<?= htmlspecialchars($song['title']) ?>"
           class="w-full h-full object-cover object-center" />
    </div>

    <h2 class="text-3xl font-bold"><?= htmlspecialchars($song['title']) ?></h2>
    <p class="text-sm text-gray-400 mb-4">Người đăng: <?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>
  </div>

  <div>
    <h3 class="text-xl font-semibold mb-2">🎶 Danh sách phát</h3>
    <?php $this->insert('songs/listsongs'); ?>
  </div>
</div>
