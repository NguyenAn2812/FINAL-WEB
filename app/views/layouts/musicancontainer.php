<h2 class="text-3xl font-bold text-white mb-4">Top Musicians</h2>

<div class="flex gap-2 mb-4 px-4" id="musicianPaginationControls">
  <button id="prevMusicianBtn" onclick="prevMusicianSlide()" aria-label="Previous"
    class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
    <i class="mdi mdi-chevron-left text-xl"></i>
  </button>

  <button id="nextMusicianBtn" onclick="nextMusicianSlide()" aria-label="Next"
    class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
    <i class="mdi mdi-chevron-right text-xl"></i>
  </button>
</div>

<div class="relative px-4 overflow-hidden w-full">
  <div id="musicianSlider" class="flex transition-transform duration-500 ease-in-out gap-6">
    <?php foreach ($musicians as $musician): ?>
      <div class="shrink-0 w-[250px] musicancard-wrapper rounded-lg shadow-md">
        <?= $this->insert('musician/musicancard', ['musician' => $musician]) ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
let currentMusicianSlide = 0;

function updateMusicianSlider() {
  const slider = document.getElementById('musicianSlider');
  const slideWidth = document.querySelector('.musicancard-wrapper').offsetWidth + 24; // card width + gap
  slider.style.transform = `translateX(-${currentMusicianSlide * slideWidth}px)`;

  document.getElementById('prevMusicianBtn').disabled = currentMusicianSlide === 0;
  document.getElementById('nextMusicianBtn').disabled = currentMusicianSlide >= <?= count($musicians) ?> - 4;
}

function prevMusicianSlide() {
  if (currentMusicianSlide > 0) {
    currentMusicianSlide--;
    updateMusicianSlider();
  }
}

function nextMusicianSlide() {
  if (currentMusicianSlide < <?= count($musicians) ?> - 4) {
    currentMusicianSlide++;
    updateMusicianSlider();
  }
}

document.addEventListener('DOMContentLoaded', updateMusicianSlider);
</script>
