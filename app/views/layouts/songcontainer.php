<h2 class="text-3xl font-bold text-white mb-4">Songs</h2>
<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>
<?php
// Lấy dữ liệu từ controller hoặc PlaylistController
//use App\Controllers\PlaylistController;

//$playlistController = new PlaylistController();

// Ví dụ các danh sách giả định
//$topSongs = $playlistController->getSongsByQuery("ORDER BY views DESC LIMIT 6");
//$loveSongs = $playlistController->getSongsByArtist("Sơn Tùng M-TP");
//$forYou = $playlistController->getSongsByUserId($_SESSION['user']['id'] ?? null);
?>

<!-- <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">🎵 Playlist đề xuất</h1> -->

    <?php
    // $this->insert('playlist/playlistsection', [
      //  'playlistId' => 1,
     //   'playlistName' => '🔥 Nhạc thịnh hành',
     //   'songs' => $topSongs
    //]); ?>

    <?php// $this->insert('playlist/playlistsection', [
        //'playlistId' => 2,
       // 'playlistName' => '🎤 Sơn Tùng M-TP',
       // 'songs' => $loveSongs
  //  ]); ?>

    <?php// $this->insert('playlist/playlistsection', [
       // 'playlistId' => 3,
        //'playlistName' => '🎧 Dành cho bạn',
       // 'songs' => $forYou
    //]); ?>
</div>
