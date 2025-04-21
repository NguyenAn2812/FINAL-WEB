<?php
use Core\Database;

$db = Database::getInstance();

$stmt = $db->query("SELECT songs.*, users.username AS artist FROM songs LEFT JOIN users ON songs.user_id = users.id ORDER BY songs.created_at DESC");
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex flex-col justify-center items-center">
  <img src="<?= BASE_URL ?>/uploads/songs/<?= htmlspecialchars($song['thumbnail']) ?>"
       class="w-[500px] h-[500px] object-cover rounded shadow-lg mb-4" alt="<?= htmlspecialchars($song['title']) ?>">
  <div class="text-center">
    <h1 class="text-2xl font-bold"><?= htmlspecialchars($song['title']) ?></h1>
    <p class="text-sm text-gray-400 mt-1">Người đăng: <?= htmlspecialchars($song['artist'] ?? 'Không rõ') ?></p>
  </div>
</div>
