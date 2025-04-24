<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-5 justify-items-center" id="songGrid">
  
  <?php foreach ($songs as $song): ?>
    <div class="songcard-wrapper">
      <?= $this->insert('songs/songcard', ['song' => $song]) ?>
    </div>
  <?php endforeach; ?>
</div>
<div class="flex justify-center gap-4 mt-6" id="paginationControls">
<button id="prevBtn" onclick="prevPage()" aria-label="Previous"
  class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
  <i class="mdi mdi-chevron-left text-xl"></i>
</button>

<button id="nextBtn" onclick="nextPage()" aria-label="Next"
  class="w-9 h-9 flex items-center justify-center rounded-full bg-[#272727] hover:bg-[#3a3a3a] text-white transition disabled:opacity-40 disabled:cursor-not-allowed">
  <i class="mdi mdi-chevron-right text-xl"></i>
</button>

</div>
