
function loadComponent(name) {
    fetch(`${BASE}/component/${name}`)
        .then(response => {
            if (!response.ok) throw new Error("Component not found");
            return response.text();
        })
        .then(html => {
            const container = document.getElementById('app');
            if (!container) {
                console.error("Element #app not found in DOM.");
                return;
            }
            container.innerHTML = html;
        })
        .catch(err => {
            const container = document.getElementById('app');
            if (container) {
                container.innerHTML = `<p class="text-red-500">Error: ${err.message}</p>`;
            } else {
                console.error(`Component load failed: ${err.message}`);
            }
        });
}
function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
    const menu = document.getElementById('dropdownMenu');
    const btn = document.getElementById('avatar-toggle');
    if (!menu || !btn) return;
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
function openLoginModal() {
    const modal = document.getElementById('loginModal');
    const content = document.getElementById('loginFormContent');
    modal.classList.remove('hidden');

    fetch(`${BASE}/component/login`)

        .then(res => {
            if (!res.ok) throw new Error("Cannot load login view");
            return res.text();
        })
        .then(html => {
            content.innerHTML = html;
        })
        .catch(err => {
            content.innerHTML = `<p class="text-red-500">Error: ${err.message}</p>`;
        });
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
}
function openRegisterModal() {
    const modal = document.getElementById('registerModal');
    const content = document.getElementById('registerFormContent');

    if (!modal || !content) {
        console.error('Register modal not found');
        return;
    }

    modal.classList.remove('hidden');

    fetch(`${BASE}/component/register`)
        .then(res => res.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(err => {
            content.innerHTML = `<p class="text-red-500">Unable to load registration form.</p>`;
        });
}

function closeRegisterModal() {
    const modal = document.getElementById('registerModal');
    if (modal) modal.classList.add('hidden');
}
const audio = document.getElementById('global-audio');
const playIcon = document.getElementById('play-icon');
const controllerBar = document.getElementById('controller-bar');
let currentSongId = null;
function playSong(file, title, artist, thumb, songId = null, showDisplay = true) {
    const audio = document.getElementById('global-audio');
    const playIcon = document.getElementById('play-icon');
    const controllerBar = document.getElementById('controller-bar');

    audio.pause();
    audio.currentTime = 0;
    audio.src = file;
    document.getElementById('now-playing-title').innerText = title;
    document.getElementById('now-playing-artist').innerText = artist;
    document.getElementById('now-playing-thumb').src = thumb;
    controllerBar.classList.remove('hidden');
    currentSongId = songId;
    setTimeout(() => {
        audio.play().catch(err => {
            console.warn("Unable to play audio:", err.message);
        });
        playIcon.classList.replace('mdi-play', 'mdi-pause');
    }, 200); 
    if (showDisplay && songId !== null) {
        loadSongDisplay(songId);
    }
    loadSongDisplay(songId);


}
function togglePlay() {
    if (audio.paused) {
        audio.play();
        playIcon.classList.replace('mdi-play', 'mdi-pause');
    } else {
        audio.pause();
        playIcon.classList.replace('mdi-pause', 'mdi-play');
    }
}

audio.addEventListener('timeupdate', () => {
    const progress = document.getElementById('progress-bar');
    progress.value = (audio.currentTime / audio.duration) * 100 || 0;

    document.getElementById('current-time').innerText = formatTime(audio.currentTime);
    document.getElementById('duration').innerText = formatTime(audio.duration);
});

document.getElementById('progress-bar').addEventListener('input', (e) => {
    const value = e.target.value;
    audio.currentTime = (value / 100) * audio.duration;
});

document.getElementById('volume-control').addEventListener('input', (e) => {
    audio.volume = e.target.value;
});

function formatTime(t) {
    const m = Math.floor(t / 60);
    const s = Math.floor(t % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
}
function openUploadModal() {
    const modal = document.getElementById('uploadModal');
    const content = document.getElementById('uploadFormContent');

    if (!modal || !content) {
        console.error("No modal element or upload content found.");
        return;
    }

    modal.classList.remove('hidden');

    fetch(`${BASE}/component/upload`)
        .then(res => {
            if (!res.ok) throw new Error("Unable to load view upload.");
            return res.text();
        })
        .then(html => {
            content.innerHTML = html;
        })
        .catch(err => {
            content.innerHTML = `<p class="text-red-500">Lỗi: ${err.message}</p>`;
        });
}


function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    if (modal) modal.classList.add('hidden');
}
function regeneratePlaylistFromDOM() {
    const domSongs = document.querySelectorAll('[data-songcard]');
    const newList = [];

    domSongs.forEach(el => {
        newList.push({
            id: parseInt(el.getAttribute('data-songcard')),
            title: el.querySelector('p.font-semibold')?.innerText ?? '',
            artist: el.querySelector('p.text-gray-400')?.innerText ?? '',
            thumbnail: el.querySelector('img')?.src ?? '',
            file: el.getAttribute('onclick')?.match(/'(.*?)'/)?.[1] ?? ''
        });
    });

    currentPlaylist = newList;
}
function loadSongDisplay(songId) {
    fetch(`${BASE}/component/songdisplay?id=${songId}`)
      .then(res => res.text())
      .then(html => {
        const app = document.getElementById('app');
        if (app) {
          app.innerHTML = html;
          highlightNowPlaying();
        }
      })
      .catch(err => {
        console.error("Unable to load song display interface", err);
      });
  }
  
function openSongDisplayFromController() {
    if (!currentSongId) return;
    loadSongDisplay(currentSongId);
}
let currentPlaylist = [];

function setCurrentPlaylist(songArray) {
    currentPlaylist = songArray;
    console.log("Playlist set:", currentPlaylist);
}

function loadGlobalPlaylist() {
    fetch(`${BASE}/playlist/json`)
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data)) {
                setCurrentPlaylist(data);
            } else {
                console.warn("Invalid playlist data");
            }
        })
        .catch(err => {
            console.error("Failed to fetch global playlist:", err);
        });
}
function playNext() {
    console.log("Next clicked");
    if (!currentPlaylist || currentPlaylist.length === 0) {
        console.warn("currentPlaylist is empty");
        return;
    }

    const index = currentPlaylist.findIndex(song => song.id === currentSongId);
    console.log("Current song index in playlist:", index);

    if (index !== -1 && index < currentPlaylist.length - 1) {
        playSongFromObject(currentPlaylist[index + 1]);
    } else {
        playRandomFromListsongs();
    }
}

function playPrevious() {
    if ((!currentPlaylist || currentPlaylist.length === 0) && document.querySelectorAll('[data-songcard]').length > 0) {
        regeneratePlaylistFromDOM();
    }

    if (currentPlaylist && currentPlaylist.length > 0 && currentSongId !== null) {
        const index = currentPlaylist.findIndex(song => song.id === currentSongId);
        if (index > 0) {
            playSongFromObject(currentPlaylist[index - 1]);
            return;
        }
    }

    playRandomFromListsongs();
}

function playSongFromObject(song) {
    playSong(
        song.file,
        song.title,
        song.artist,
        song.thumbnail,
        song.id
    );
}
function openPlaylistDisplay(playlistId) {
    if (!playlistId) return;
    fetch(`${BASE}/component/playlistdisplay?id=${playlistId}`)
        .then(res => res.text())
        .then(html => {
            const app = document.getElementById('app');
            if (app) app.innerHTML = html;
        })
        .catch(err => console.error("Can't load UI playlist.", err));
}

function playRandomFromListsongs() {
    const songs = document.querySelectorAll('[data-songcard]');
    if (songs.length === 0) return;

    const randomIndex = Math.floor(Math.random() * songs.length);
    songs[randomIndex].click(); 
}
function highlightNowPlaying() {
    const cards = document.querySelectorAll('[data-songcard]');
    cards.forEach(card => {
        const id = parseInt(card.getAttribute('data-songcard'));
        if (id === currentSongId) {
            card.classList.add('bg-blue-800/30', 'ring-2', 'ring-blue-400');
        } else {
            card.classList.remove('bg-blue-800/30', 'ring-2', 'ring-blue-400');
        }
    });
}
function fetchPlaylist() {
    fetch(`${BASE}/playlist/json`)
      .then(res => res.json())
      .then(data => {
        setCurrentPlaylist(data);
        console.log('Playlist loaded from backend');
      })
      .catch(err => {
        console.error('Failed to load playlist:', err);
      });
      
}
function scrollPlaylist(playListDisplayId, direction) {
    containerId = "playlistScroll" + playListDisplayId;
    const container = document.getElementById(containerId);
    const cardWidth = container.querySelector(".playlist-card").offsetWidth + 20; // thêm gap
    container.scrollLeft += direction * cardWidth;
  }
document.addEventListener('DOMContentLoaded', () => {
    loadComponent('home');
    loadGlobalPlaylist();
});
function openAddToPlaylistModal(e, songId) {
    e.stopPropagation(); 
  
    fetch(`${BASE}/playlist/addform?song_id=${songId}`)
      .then(res => res.text())
      .then(html => {
        document.body.insertAdjacentHTML('beforeend', html);
        document.getElementById('addToPlaylistModal')?.classList.remove('hidden');
      });
}
  
  function closeAddToPlaylistModal() {
    document.getElementById('addToPlaylistModal')?.remove();
  }
  
  document.addEventListener('submit', function(e) {
    if (e.target.id === 'addToPlaylistForm') {
      e.preventDefault();
      const formData = new FormData(e.target);
      fetch(`${BASE}/playlist/add`, {
        method: 'POST',
        body: formData
      }).then(() => {
        closeAddToPlaylistModal();
        alert("Added playlist!");
      });
    }
  });
  