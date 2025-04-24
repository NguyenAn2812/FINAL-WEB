<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4 p-4">
    <?php foreach ($playlists as $playlist): ?>
        <?php include 'app/views/playlist/playlistcard.php'; ?>
    <?php endforeach; ?>
</div>
