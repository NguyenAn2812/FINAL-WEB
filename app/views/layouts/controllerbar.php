<div id="controller-bar" class="fixed bottom-0 left-0 right-0 bg-[#181818] border-t border-[#303030] p-3 flex items-center justify-between z-50 hidden">
    <div class="flex items-center space-x-4" onclick="openSongDisplayFromController()">
        
        <img id="now-playing-thumb" src="" class="w-12 h-12 rounded object-cover" alt="">
        <div>
            <p id="now-playing-title" class="font-semibold">Haven't chosen a song yet</p>
            <p id="now-playing-artist" class="text-sm text-gray-400"></p>
        </div>
    </div>

    <div class="flex flex-col items-center w-full max-w-lg">
        <input id="progress-bar" type="range" min="0" max="100" value="0" class="w-full accent-red-500">
        <div class="flex items-center space-x-4 mt-1">
            <button onclick="togglePlay()"><i id="play-icon" class="mdi mdi-play text-2xl"></i></button>
            <span id="current-time" class="text-xs">0:00</span>
            <span>/</span>
            <span id="duration" class="text-xs">0:00</span>
        </div>
    </div>

    <div class="flex items-center space-x-2">
        <i class="mdi mdi-volume-high text-xl"></i>
        <input id="volume-control" type="range" min="0" max="1" step="0.01" value="1" class="accent-red-500">
    </div>

    <audio id="global-audio" src=""></audio>
</div>
