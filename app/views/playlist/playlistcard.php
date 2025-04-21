<!-- sizepic 300x300 -->
<?php
    function renderPlaylistCard($imgsrc, $name, $author) {?>
            <div class="playlist-card">
            <img src="<?=$imgsrc?>" alt="Playlist">
                <div class="playlist-card-body">
                    <div class="playlist-title"><?=$name?></div>
                    <div class="playlist-info"><?=$author?></div>
                </div>
            </div>
    <?php
    }
?>

    