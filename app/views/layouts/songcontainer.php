<p>🔍 DEBUG: $songs có tồn tại không? <?= isset($songs) ? 'CÓ' : 'KHÔNG' ?></p>
<div class="flex flex-wrap gap-4">
  <?php foreach ($songs as $song): ?>
    <?= $this->insert('songs/songcard', ['song' => $song]) ?>
  <?php endforeach; ?>
</div>

<div class="container-fluid">
        <?php
            $playListDisplayId = 1;
            $playListDisplayName = 'Dành cho bạn';
            $playListDisplayInfo = [
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'có gì đâu mà buồn', 'lalaland'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
                ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM']
            ];
            include '../app/views/playlist/playlistdisplay.php';
        ?>

        <?php 
            $playListDisplayId = 2;
            $playListDisplayName = 'Nhạc trẻ sôi động';
            $playListDisplayInfo = [
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM'],
            ['https://picsum.photos/300/300?random=4', 'Lofi cực chill', 'EMINEM']
            ];
            include '../app/views/playlist/playlistdisplay.php';
        ?>
    </div>