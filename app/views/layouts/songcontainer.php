<div class="relative px-4">
  <div id="songSlider" class="flex transition-transform duration-500 ease-in-out gap-6">
    <?php foreach ($songs as $song): ?>
      <div class="shrink-0 w-[250px] songcard-wrapper rounded-lg shadow-md">
        <?= $this->insert('songs/songcard', ['song' => $song]) ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<div class="flex justify-center gap-4 mt-6" id="paginationControls">
  <button id="prevBtn" onclick="prevSlide()" aria-label="Previous"
    class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
    <i class="mdi mdi-chevron-left text-xl"></i>
  </button>

  <button id="nextBtn" onclick="nextSlide()" aria-label="Next"
    class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
    <i class="mdi mdi-chevron-right text-xl"></i>
  </button>
</div>
