<div class="p-6">
  <h1 class="text-2xl font-bold mb-6">🎧 Gợi ý dành cho bạn</h1>

  <?php
    $this->insert('newfeed/section', ['title' => '🔥 Nhạc thịnh hành', 'songs' => $trendingSongs]);
    $this->insert('newfeed/section', ['title' => '🎤 Sơn Tùng M-TP', 'songs' => $mtpSongs]);
    $this->insert('newfeed/section', ['title' => '🎶 Dành cho bạn', 'songs' => $personalizedSongs]);
  ?>
</div>
<?php
$this->insert('playlist/playlistsection', [
    'playlistId' => 1,
    'playlistName' => '🎵 Nhạc yêu thích',
    'songs' => $favoriteSongs
]);

$this->insert('playlist/playlistsection', [
    'playlistId' => 2,
    'playlistName' => '🔥 Thịnh hành',
    'songs' => $trendingSongs
]);
?>