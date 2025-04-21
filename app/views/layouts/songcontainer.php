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

<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?php include __DIR__ . '/../songs/songcard.php'; ?>
  <?php endforeach; ?>
</div>
