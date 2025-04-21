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

<div class="flex flex-col gap-3">
  <?php foreach ($songs as $song): ?>
    <div
      onclick="playSong(
        '<?= BASE_URL ?>/uploads/songs/<?= $song['filename'] ?>',
        '<?= htmlspecialchars($song['title']) ?>',
        '<?= htmlspecialchars($song['artist'] ?? 'Unknown') ?>',
        '<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>'
      ); loadSongDisplay(<?= $song['id'] ?>);"
      class="flex items-center gap-3 cursor-pointer hover:bg-[#2a2a2a] p-2 rounded transition"
    >
      <img
        src="<?= BASE_URL ?>/uploads/songs/<?= $song['thumbnail'] ?>"
        alt="<?= htmlspecialchars($song['title']) ?>"
        class="w-14 h-14 rounded object-cover"
      >
      <div>
        <p class="font-semibold"><?= htmlspecialchars($song['title']) ?></p>
        <p class="text-sm text-gray-400"><?= htmlspecialchars($song['artist'] ?? 'Unknown') ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>
