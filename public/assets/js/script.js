let isShuffling = false;
let originalPlaylist = [];

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
    const mainThumb = document.getElementById('main-playlist-thumbnail');
    if (mainThumb) {
    mainThumb.src = thumb;
    }
    audio.pause();
    audio.currentTime = 0;
    audio.src = '';
    audio.src = file;
    console.log("🎵 Audio source:", file);
    audio.load();
    document.getElementById('now-playing-title').innerText = title;
    document.getElementById('now-playing-artist').innerText = artist;
    let thumbUrl = thumb;
    if (!thumb.startsWith('http') && !thumb.startsWith('/uploads/')) {
        thumbUrl = BASE + '/uploads/thumbnails/' + thumb;
    }
    document.getElementById('now-playing-thumb').src = thumbUrl;
    controllerBar.classList.remove('hidden');
    if (document.getElementById('playlist-songs-container')) {
        regeneratePlaylistFromDOM_Column();
      }
    currentSongId = songId;
    highlightNowPlaying();
    setTimeout(() => {
        audio.play().catch(err => {
            console.warn("Unable to play audio:", err.message);
        });
        playIcon.classList.replace('mdi-play', 'mdi-pause');
    }, 200); 
    


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
function regeneratePlaylistFromDOM_Column() {
    const domSongs = document.querySelectorAll('#playlist-songs-container [data-songcard]');
    const newList = [];
  
    domSongs.forEach(el => {
      newList.push({
        id: parseInt(el.getAttribute('data-songcard')),
        title: el.querySelector('p.font-semibold')?.innerText ?? '',
        artist: el.querySelector('p.text-gray-400')?.innerText ?? '',
        thumbnail: (() => {
          const src = el.querySelector('img')?.src ?? '';
          return src.includes('/uploads/songs/')
            ? src.replace('/uploads/songs/', '/uploads/thumbnails/')
            : src;
        })(),
        file: el.dataset.file,
        title: el.dataset.title,
        artist: el.dataset.artist,
        thumbnail: el.dataset.thumb
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
function loadPlaylistDisplay(playlistId) {
    fetch(`${BASE}/component/playlistdisplay?id=${playlistId}`)
        .then(res => res.text())
        .then(html => {
            const app = document.getElementById('app');
            if (app) app.innerHTML = html;
        })
        .catch(err => console.error("Unable to load playlist display:", err));
}
function playPlaylist(playlistId) {
    fetch(`${BASE}/component/playlistdisplay?id=${playlistId}`)
      .then(res => res.text())
      .then(html => {
        const app = document.getElementById('app');
        if (app) app.innerHTML = html;
  
        // 🔁 Tạo playlist chuẩn
        const domSongs = document.querySelectorAll('#playlist-songs-container [data-songcard]');
        const list = [];
        domSongs.forEach(el => {
          list.push({
            id: parseInt(el.getAttribute('data-songcard')),
            title: el.querySelector('p.font-semibold')?.innerText ?? '',
            artist: el.querySelector('p.text-gray-400')?.innerText ?? '',
            thumbnail: (() => {
              const src = el.querySelector('img')?.src ?? '';
              return src.includes('/uploads/songs/')
                ? src.replace('/uploads/songs/', '/uploads/thumbnails/')
                : src;
            })(),
            file: el.getAttribute('onclick')?.match(/'(.*?)'/)?.[1] ?? ''
          });
        });
  
        currentPlaylist = [...list];
        originalPlaylist = [...list]; // 💡 lưu lại để dùng sau
        isShuffling = false;
  
        playSongFromObject(currentPlaylist[0]);
      });
  }
  
  
  function shufflePlaylist(playlistId) {
    fetch(`${BASE}/component/playlistdisplay?id=${playlistId}`)
      .then(res => res.text())
      .then(html => {
        const app = document.getElementById('app');
        if (app) app.innerHTML = html;
  
        // 🔁 Tạo danh sách gốc từ DOM
        const domSongs = document.querySelectorAll('#playlist-songs-container [data-songcard]');
        originalPlaylist = [];
        domSongs.forEach(el => {
          originalPlaylist.push({
            id: parseInt(el.getAttribute('data-songcard')),
            title: el.querySelector('p.font-semibold')?.innerText ?? '',
            artist: el.querySelector('p.text-gray-400')?.innerText ?? '',
            thumbnail: (() => {
              const src = el.querySelector('img')?.src ?? '';
              return src.includes('/uploads/songs/')
                ? src.replace('/uploads/songs/', '/uploads/thumbnails/')
                : src;
            })(),
            file: el.getAttribute('onclick')?.match(/'(.*?)'/)?.[1] ?? ''
          });
        });
  
        // 🔀 Tạo bản shuffle từ danh sách gốc
        currentPlaylist = [...originalPlaylist];
        for (let i = currentPlaylist.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [currentPlaylist[i], currentPlaylist[j]] = [currentPlaylist[j], currentPlaylist[i]];
        }
  
        isShuffling = true;
  
        // ✅ Sau khi shuffle xong mới render lại
        renderPlaylistSongsFromCurrentPlaylist();
  
        // ✅ Phát bài đầu tiên trong danh sách shuffle
        playSongFromObject(currentPlaylist[0]);
      });
  }
    
  
  
  function sharePlaylist(playlistId) {
    const url = `${window.location.origin}${BASE}/component/playlistdisplay?id=${playlistId}`;
    navigator.clipboard.writeText(url)
      .then(() => alert("📋 Link playlist đã được copy!"))
      .catch(err => alert("Không thể copy liên kết."));
  }

  function playNext() {
    if (!currentPlaylist || currentPlaylist.length === 0) return;
  
    const index = currentPlaylist.findIndex(song => song.id === currentSongId);
    if (index !== -1 && index < currentPlaylist.length - 1) {
      playSongFromObject(currentPlaylist[index + 1]);
    }
  }
  
  function playPrevious() {
    if (!currentPlaylist || currentPlaylist.length === 0) return;
  
    const index = currentPlaylist.findIndex(song => song.id === currentSongId);
    if (index > 0) {
      playSongFromObject(currentPlaylist[index - 1]);
    }
  }
  


  function playPrevious() {
    if (!currentPlaylist || currentPlaylist.length === 0) return;
  
    if (isShuffling) {
      const availableSongs = currentPlaylist.filter(song => song.id !== currentSongId);
      if (availableSongs.length > 0) {
        const randomIndex = Math.floor(Math.random() * availableSongs.length);
        playSongFromObject(availableSongs[randomIndex]);
      }
    } else {
      const index = currentPlaylist.findIndex(song => song.id === currentSongId);
      if (index > 0) {
        playSongFromObject(currentPlaylist[index - 1]);
      }
    }
  }
  
  function renderPlaylistSongsFromCurrentPlaylist() {
    const container = document.getElementById('playlist-songs-container');
    if (!container) return;
  
    container.innerHTML = ''; // Xoá toàn bộ danh sách cũ
  
    currentPlaylist.forEach(song => {
      const songCard = document.createElement('div');
      songCard.setAttribute('data-songcard', song.id);
      songCard.className = 'flex items-center gap-3 cursor-pointer hover:bg-[#2a2a2a] p-2 rounded transition';
  
      songCard.innerHTML = `
        <img src="${song.thumbnail}" class="w-14 h-14 rounded object-cover" alt="${song.title}">
        <div>
          <p class="font-semibold">${song.title}</p>
          <p class="text-sm text-gray-400">${song.artist}</p>
        </div>
      `;
  
      songCard.onclick = () => {
        playSong(song.file, song.title, song.artist, song.thumbnail, song.id);
      };
  
      container.appendChild(songCard);
    });
  
    highlightNowPlaying(); // Đảm bảo bài đang phát được highlight lại
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
      .catch(err => console.error("❌ Không thể tải giao diện playlist:", err));
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
        if (html.includes("NOT_LOGGED_IN")) {
          console.warn("🟡 User not logged in → mở login modal");
          openLoginModal();
          return;
        }
  
        document.getElementById('addToPlaylistModal')?.remove();
        document.body.insertAdjacentHTML('beforeend', html);
        document.getElementById('addToPlaylistModal')?.classList.remove('hidden');
      })
      .catch(err => console.error("❌ Lỗi khi tải popup playlist:", err));
  }
  
  
  
  function closeAddToPlaylistModal() {
    document.getElementById('addToPlaylistModal')?.remove();
  }
  
  function toggleCreatePlaylist(show) {
    document.getElementById('choosePlaylistSection')?.classList.toggle('hidden', show);
    document.getElementById('createPlaylistSection')?.classList.toggle('hidden', !show);
    const title = document.getElementById('playlistModalTitle');
    if (title) title.innerText = show ? 'Tạo playlist mới' : 'Thêm vào Playlist';
  }
function openCreatePlaylistModal() {
  fetch(`${BASE}/component/createplaylist`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('createPlaylistModal')?.remove();
      document.body.insertAdjacentHTML('beforeend', html);
      document.getElementById('createPlaylistModal')?.classList.remove('hidden');
    });
}

function closeCreatePlaylistModal() {
  document.getElementById('createPlaylistModal')?.remove();
}

document.addEventListener('submit', function (e) {
    if (e.target.id === 'addToPlaylistForm') {
      e.preventDefault();
  
      const formData = new FormData(e.target);
      fetch(`${BASE}/playlist/add`, {
        method: 'POST',
        body: formData
      })
      .then(res => res.text())
      .then(result => {
        console.log("🧪 Add song to playlist:", result);
        closeAddToPlaylistModal();
        alert("✅ Đã thêm vào playlist!");
      });
    }
  });
  
  
