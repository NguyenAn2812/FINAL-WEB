<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-5 justify-items-center" id="songGrid">
  
  <?php foreach ($songs as $song): ?>
    <div class="songcard-wrapper">
      <?= $this->insert('songs/songcard', ['song' => $song]) ?>
    </div>
  <?php endforeach; ?>
</div>
<div class="flex justify-center gap-4 mt-6" id="paginationControls">
  <button onclick="prevPage()" class="bg-gray-600 text-white px-4 py-2 rounded disabled:opacity-50" id="prevBtn" disabled>⬅ Prev</button>
  <button onclick="nextPage()" class="bg-gray-600 text-white px-4 py-2 rounded disabled:opacity-50" id="nextBtn">Next ➡</button>
</div>