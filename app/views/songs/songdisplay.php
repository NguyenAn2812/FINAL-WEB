<?php
use Core\Database;

$db = Database::getInstance();

$stmt = $db->query("
    SELECT songs.*, users.username AS artist
    FROM songs
    LEFT JOIN users ON songs.user_id = users.id
    ORDER BY songs.created_at DESC
");

$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex w-full h-[calc(100vh-150px)]">
  <!-- LEFT: SONG THUMBNAIL + INFO -->
  <div class="w-2/3 p-6 flex flex-col justify-center items-center">
    <img src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['thumbnail']) ?>"
         class="w-[500px] h-[500px] object-cover rounded shadow-lg mb-4" alt="<?= htmlspecialchars($song['title']) ?>">
    <div class="text-center">
      <h1 class="text-2xl font-bold"><?= htmlspecialchars($song['title']) ?></h1>
      <p class="text-sm text-gray-400 mt-1">Người đăng: <?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>
    </div>
  </div>

  <!-- RIGHT: DANH SÁCH PHÁT -->
  <div class="w-1/3 p-6 border-l border-[#303030] overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4">🎵 Danh sách phát</h3>
    <?php $this->insert('songs/listsongs', ['songs' => $songs]); ?>
  </div>
</div>
