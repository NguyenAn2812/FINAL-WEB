// 🎵 Playback controls
const audio = document.getElementById('global-audio');
const playIcon = document.getElementById('play-icon');
const controllerBar = document.getElementById('controller-bar');
let currentSongId = null;
let currentPlaylist = [];

// Phát bài hát
function playSong(file, title, artist, thumb, songId = null, showDisplay = true) {
  audio.pause();
  audio.currentTime = 0;
  audio.src = file;

  document.getElementById('now-playing-title').innerText = title;
  document.getElementById('now-playing-artist').innerText = artist;
  document.getElementById('now-playing-thumb').src = thumb;
  controllerBar.classList.remove('hidden');

  currentSongId = songId;

  setTimeout(() => {
    audio.play().catch(err => console.warn("🎧 Cannot play:", err.message));
    playIcon.classList.replace('mdi-play', 'mdi-pause');
  }, 200);

  if (showDisplay && songId !== null) loadSongDisplay(songId);
}

// Toggle play/pause
function togglePlay() {
  if (audio.paused) {
    audio.play();
    playIcon.classList.replace('mdi-play', 'mdi-pause');
  } else {
    audio.pause();
    playIcon.classList.replace('mdi-pause', 'mdi-play');
  }
}

// Thời gian và progress bar
audio.addEventListener('timeupdate', () => {
  const progress = document.getElementById('progress-bar');
  progress.value = (audio.currentTime / audio.duration) * 100 || 0;
  document.getElementById('current-time').innerText = formatTime(audio.currentTime);
  document.getElementById('duration').innerText = formatTime(audio.duration);
});

// Seek khi kéo progress
document.getElementById('progress-bar').addEventListener('input', e => {
  audio.currentTime = (e.target.value / 100) * audio.duration;
});

// Volume
document.getElementById('volume-control').addEventListener('input', e => {
  audio.volume = e.target.value;
});

function formatTime(t) {
  const m = Math.floor(t / 60);
  const s = Math.floor(t % 60).toString().padStart(2, '0');
  return `${m}:${s}`;
}

// 🎧 Playlist logic
function regeneratePlaylistFromDOM() {
  currentPlaylist = Array.from(document.querySelectorAll('[data-songcard]')).map(el => ({
    id: parseInt(el.getAttribute('data-songcard')),
    title: el.querySelector('p.font-semibold')?.innerText ?? '',
    artist: el.querySelector('p.text-gray-400')?.innerText ?? '',
    thumbnail: el.querySelector('img')?.src ?? '',
    file: el.getAttribute('onclick')?.match(/'(.*?)'/)?.[1] ?? ''
  }));
}

function setCurrentPlaylist(songs) {
  currentPlaylist = songs;
  console.log("📃 Playlist set:", currentPlaylist);
}

function playNext() {
  if (!currentPlaylist.length) return;
  const index = currentPlaylist.findIndex(song => song.id === currentSongId);
  if (index !== -1 && index < currentPlaylist.length - 1) {
    playSongFromObject(currentPlaylist[index + 1]);
  } else {
    playRandomFromListsongs();
  }
}

function playPrevious() {
  if (!currentPlaylist.length) regeneratePlaylistFromDOM();
  const index = currentPlaylist.findIndex(song => song.id === currentSongId);
  if (index > 0) {
    playSongFromObject(currentPlaylist[index - 1]);
  } else {
    playRandomFromListsongs();
  }
}

function playSongFromObject(song) {
  playSong(song.file, song.title, song.artist, song.thumbnail, song.id);
}

function playRandomFromListsongs() {
  const cards = document.querySelectorAll('[data-songcard]');
  if (!cards.length) return;
  const randomIndex = Math.floor(Math.random() * cards.length);
  cards[randomIndex].click();
}

function highlightNowPlaying() {
  document.querySelectorAll('[data-songcard]').forEach(card => {
    const id = parseInt(card.getAttribute('data-songcard'));
    card.classList.toggle('bg-blue-800/30', id === currentSongId);
    card.classList.toggle('ring-2', id === currentSongId);
    card.classList.toggle('ring-blue-400', id === currentSongId);
  });
}

// 🔁 Playlist API
function loadGlobalPlaylist() {
  fetch(`${BASE}/playlist/json`)
    .then(res => res.json())
    .then(data => Array.isArray(data) && setCurrentPlaylist(data))
    .catch(err => console.error("📡 Playlist fetch failed:", err));
}

function fetchPlaylist() {
  loadGlobalPlaylist();
}

// 🖼 Component + Modal logic
function loadComponent(name) {
  fetch(`${BASE}/component/${name}`)
    .then(res => res.ok ? res.text() : Promise.reject("Component not found"))
    .then(html => {
      const app = document.getElementById('app');
      if (app) app.innerHTML = html;
    })
    .catch(err => {
      document.getElementById('app')?.innerHTML = `<p class="text-red-500">Error: ${err}</p>`;
    });
}

function loadSongDisplay(id) {
  fetch(`${BASE}/component/songdisplay?id=${id}`)
    .then(res => res.text())
    .then(html => {
      const app = document.getElementById('app');
      if (app) {
        app.innerHTML = html;
        highlightNowPlaying();
      }
    })
    .catch(err => console.error("🔴 Song display load error:", err));
}

function openSongDisplayFromController() {
  if (currentSongId) loadSongDisplay(currentSongId);
}

// 🟦 Modal: Add to Playlist
function openAddToPlaylistModal(e, songId) {
  e.stopPropagation();
  fetch(`${BASE}/playlist/addform?song_id=${songId}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('addToPlaylistModal')?.remove();
      document.body.insertAdjacentHTML('beforeend', html);
      document.getElementById('addToPlaylistModal')?.classList.remove('hidden');
    });
}

function closeAddToPlaylistModal() {
  document.getElementById('addToPlaylistModal')?.remove();
}

// 🟢 Modal: Create Playlist Toggle
function toggleCreatePlaylist(show) {
  document.getElementById('choosePlaylistSection')?.classList.toggle('hidden', show);
  document.getElementById('createPlaylistSection')?.classList.toggle('hidden', !show);
  const title = document.getElementById('playlistModalTitle');
  if (title) title.innerText = show ? 'Tạo playlist mới' : 'Thêm vào Playlist';
}

// 📤 Form Submit Events
document.addEventListener('submit', function (e) {
  if (e.target.id === 'addToPlaylistForm') {
    e.preventDefault();
    const formData = new FormData(e.target);
    fetch(`${BASE}/playlist/add`, { method: 'POST', body: formData })
      .then(() => {
        closeAddToPlaylistModal();
        alert("🎉 Đã thêm vào playlist!");
      });
  }

  if (e.target.id === 'createPlaylistForm') {
    e.preventDefault();
    const formData = new FormData(e.target);
    fetch(`${BASE}/playlist/create`, { method: 'POST', body: formData })
      .then(() => {
        alert("🎉 Playlist đã tạo!");
        location.reload(); // hoặc load lại danh sách playlist bằng JS nếu muốn
      });
  }
});

// 📥 Upload Modal
function openUploadModal() {
  fetch(`${BASE}/component/upload`)
    .then(res => res.text())
    .then(html => {
      const content = document.getElementById('uploadFormContent');
      if (content) content.innerHTML = html;
      document.getElementById('uploadModal')?.classList.remove('hidden');
    });
}

function closeUploadModal() {
  document.getElementById('uploadModal')?.classList.add('hidden');
}

// 📥 Login / Register Modal
function openLoginModal() {
  fetch(`${BASE}/component/login`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('loginFormContent').innerHTML = html;
      document.getElementById('loginModal')?.classList.remove('hidden');
    });
}

function closeLoginModal() {
  document.getElementById('loginModal')?.classList.add('hidden');
}

function openRegisterModal() {
  fetch(`${BASE}/component/register`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('registerFormContent').innerHTML = html;
      document.getElementById('registerModal')?.classList.remove('hidden');
    });
}

function closeRegisterModal() {
  document.getElementById('registerModal')?.classList.add('hidden');
}

// 🔽 Avatar Dropdown
function toggleDropdown() {
  document.getElementById('dropdownMenu')?.classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
  const menu = document.getElementById('dropdownMenu');
  const btn = document.getElementById('avatar-toggle');
  if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
    menu.classList.add('hidden');
  }
});

// 🔄 On Load
document.addEventListener('DOMContentLoaded', () => {
  loadGlobalPlaylist();
});
