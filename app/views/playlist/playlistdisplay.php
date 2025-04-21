<!-- Trước khi include file này phải khai báo các biến $playListDisplayId, $playListDisplayName, $playListDisplayInfo[][imgsrc, name, author] -->

<?php include_once 'playlistcard.php';?>

<div class="row">
    <div class="col text-start">
        <h4 class="mb-4"><?=$playListDisplayName?></h4>
    </div>
    <div class="col text-end">
        <button class="scroll-btn" onclick="scrollPlaylist(<?=$playListDisplayId?>, -1)">&#8249;</button>
        <button class="scroll-btn" onclick="scrollPlaylist(<?=$playListDisplayId?> ,1)">&#8250;</button>
    </div>
</div>

<!-- Scrollable playlist -->
<div class="playlist-wrapper" id="playlistScroll<?=$playListDisplayId?>">
    <div class="playlist-row">
    <!-- Playlist Card -->
    <?php
        foreach ($playListDisplayInfo as $cardInfo) {
            renderPlaylistCard($cardInfo[0], $cardInfo[1], $cardInfo[2]);
        }
    ?>
    </div>
</div>

<script>
  function scrollPlaylist(playListDisplayId, direction) {
    containerId = "playlistScroll" + playListDisplayId;
    const container = document.getElementById(containerId);
    const cardWidth = container.querySelector(".playlist-card").offsetWidth + 20; // thêm gap
    container.scrollLeft += direction * cardWidth;
  }
</script>