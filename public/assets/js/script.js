let isShuffling = false;
let originalPlaylist = [];
async function loadRandomSongs(limit = 6) {
    const res = await fetch(`${BASE}/playlist/random?limit=${limit}`);
    return await res.json();
}
    
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
    if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }

    const el = e.target.closest('.songcard');
    if (!el) return;

    const songId = Number(el.dataset.songcard);
    let song;

    // Ưu tiên tìm trong currentPlaylist
    if (Array.isArray(currentPlaylist)) {
        song = currentPlaylist.find(s => Number(s.id) === songId);
    }

    if (!song) {
        song = {
            id: songId,
            title: el.dataset.title,
            artist: el.dataset.artist,
            file: el.dataset.file,
            thumbnail: el.dataset.thumb
        };
    }

    currentSongId = song.id;
    playSongFromObject(song);
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
audio.addEventListener('ended', () => {
    playNext();
});
let currentSongId = null;
function playSong(file, title, artist, thumb, songId = null, showDisplay = true, playlistQueue = null) {
    const audio = document.getElementById('global-audio');
    audio.pause();
    audio.currentTime = 0;
    audio.src = file;
    audio.load();

    document.getElementById('now-playing-title').innerText = title;
    document.getElementById('now-playing-artist').innerText = artist;
    let thumbUrl = thumb;

    if (!thumb.startsWith('http') && !thumb.startsWith(BASE + '/uploads/')) {
        thumbUrl = BASE + '/uploads/thumbnails/' + thumb;
    }

    document.getElementById('now-playing-thumb').src = thumbUrl;
    document.getElementById('controller-bar').classList.remove('hidden');
    currentSongId = Number(songId);
    
    if (playlistQueue && Array.isArray(playlistQueue)) {
        currentPlaylist = [...playlistQueue];
        renderPlaylistSongsFromCurrentPlaylist();
    }

    if (showDisplay && currentSongId) {
        loadSongDisplay(currentSongId);
    }

    setTimeout(() => {
        audio.play().catch(err => console.warn("Unable to play:", err.message));
        document.getElementById('play-icon').classList.replace('mdi-play', 'mdi-pause');
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
        content.innerHTML = `<p class="text-red-500">Error: ${err.message}</p>`;
    });
}
let currentPlaylistId = null;

function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        if (modal) modal.classList.add('hidden');
}
function regeneratePlaylistFromDOM_Column() {
    const domSongs = document.querySelectorAll('#playlist-songs-container [data-songcard]');
    const newList = [];

    domSongs.forEach(el => {
        newList.push({
            id: parseInt(el.dataset.songcard),
            title: el.dataset.title,
            artist: el.dataset.artist,
            file: el.dataset.file,
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
    
async function openSongDisplayFromController() {
    if (!currentSongId) {
        alert("Please select a song first.");
        return;
    }

    const app = document.getElementById('app');

    // ⚠️ Kiểm tra nếu songdisplay đang hiển thị (thông qua playlist-songs-container)
    const playlistContainer = document.getElementById('playlist-songs-container');

    if (!playlistContainer) {
        // ✅ CHỈ khi chưa có thì mới load lại component
        await loadComponent(`songdisplay?id=${currentSongId}`);
        renderPlaylistSongsFromList(currentPlaylist);
    }

    // Luôn luôn highlight bài đang phát
    highlightNowPlaying(currentSongId);
}
let currentPlaylist = [];

function setCurrentPlaylist(songArray) {
    currentPlaylist = songArray;
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
function initPlaylistAndOpenSongDisplay(playlistId, isShuffle = false) {
    fetch(`${BASE}/playlist/json?id=${playlistId}`)
    .then(res => res.json())
    .then(songs => {
        if (!Array.isArray(songs) || songs.length === 0) {
            console.warn("No songs in playlist", playlistId);
            return;
        }

        currentPlaylistId = playlistId;
        isShuffling = isShuffle;

        let list = [...songs];
        if (isShuffle) {
            for (let i = list.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [list[i], list[j]] = [list[j], list[i]];
            }
        }

        currentPlaylist = list;

        loadSongDisplay(list[0].id); 
        playSongFromObject(list[0]); 
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
    fetch(`${BASE}/playlist/json?id=${playlistId}`)
        .then(res => res.json())
        .then(songs => {
            if (!Array.isArray(songs) || songs.length === 0) {
                const container = document.getElementById('playlist-songs-container');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-gray-400 italic py-4">
                            Playlist này chưa có bài hát nào.
                        </div>`;
                }
                return;
            }

            currentPlaylistId = playlistId;
            isShuffling = false;
            originalPlaylist = [...songs];
            currentPlaylist = [...songs];

            renderPlaylistSongsFromCurrentPlaylist();

            const first = songs[0];
            playSong(first.file, first.title, first.artist, first.thumbnail, first.id, true, songs);
        });
}


    
function shufflePlaylist(playlistId) {
    fetch(`${BASE}/playlist/json?id=${playlistId}`)
        .then(res => res.json())
        .then(songs => {
            if (!Array.isArray(songs) || songs.length === 0) {
                const container = document.getElementById('playlist-songs-container');
                if (container) {
                    container.innerHTML = `
                        <div class="text-center text-gray-400 italic py-4">
                            Playlist này chưa có bài hát nào để phát.
                        </div>`;
                }
                return;
            }

            currentPlaylistId = playlistId;
            isShuffling = true;

            const shuffled = [...songs];
            for (let i = shuffled.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
            }

            originalPlaylist = [...songs];
            currentPlaylist = shuffled;

            renderPlaylistSongsFromCurrentPlaylist();

            const first = shuffled[0];
            playSong(first.file, first.title, first.artist, first.thumbnail, first.id, true, shuffled);
        });
}

function sharePlaylist(playlistId) {
    const url = `${window.location.origin}${BASE}/component/playlistdisplay?id=${playlistId}`;
    navigator.clipboard.writeText(url)
        .then(() => alert(" Playlist link copied!"))
        .catch(err => alert("Unable to copy link."));
}

async function playNext() {
    if (!currentPlaylist || currentPlaylist.length === 0) {
        const randomSongs = await loadRandomSongs();
        if (!randomSongs || randomSongs.length === 0) return;

        currentPlaylist = [...randomSongs];
        originalPlaylist = [...randomSongs];
        isShuffling = true;

        // await loadComponent(`songdisplay?id=${randomSongs[0].id}`);
        currentSongId = randomSongs[0].id;
        renderPlaylistSongsFromList(currentPlaylist);
        playSongFromObject(randomSongs[0]);
        return;
    }

    const index = currentPlaylist.findIndex(song => Number(song.id) === Number(currentSongId));

    if (index === -1 || index >= currentPlaylist.length - 1) {
        const moreSongs = isShuffling ? await loadRandomSongs() : await loadNextSongsFromPlaylist();
        if (!moreSongs || moreSongs.length === 0) return;

        currentPlaylist.push(...moreSongs);
        const next = moreSongs[0];
        currentSongId = next.id;
        renderPlaylistSongsFromList(currentPlaylist);
        playSongFromObject(next);
    } else {
        const next = currentPlaylist[index + 1];
        currentSongId = next.id;

        playSongFromObject(next); // chỉ cập nhật controller + highlight
    }
}

function shuffleArray(arr) {
    const shuffled = [...arr];
    for (let i = shuffled.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
    }
    return shuffled;
}


function openSongDisplay(song) {
    loadComponent(`songdisplay?id=${song.id}`);
}
async function loadNextSongsFromPlaylist() {
    if (!originalPlaylist || originalPlaylist.length === 0) return [];

    const playedIds = currentPlaylist.map(s => Number(s.id));
    const remaining = originalPlaylist.filter(s => !playedIds.includes(Number(s.id)));

    return remaining.slice(0, 6);
}

function renderPlaylistSongsFromList(songs) {
    const container = document.getElementById('playlist-songs-container');
    if (!container) return;
    console.log("📃 currentPlaylist:", currentPlaylist.map(s => s.title));
    container.innerHTML = songs.map(song => `
        <div class="songcard ${song.id === currentSongId ? 'border border-blue-500' : ''}"
             data-songcard="${song.id}"
             data-title="${song.title}"
             data-artist="${song.artist}"
             data-thumb="${song.thumbnail}"
             data-file="${song.file}">
            <img src="${song.thumbnail}" class="w-full h-20 object-cover rounded" />
            <p class="text-white text-sm font-semibold">${song.title}</p>
            <p class="text-gray-400 text-xs">${song.artist}</p>
        </div>
    `).join('');
}


    
// function playPrevious() {
//     if (!currentPlaylist || currentPlaylist.length === 0) return;

//     const index = currentPlaylist.findIndex(song => song.id === currentSongId);
//     if (index > 0) {
//         playSongFromObject(currentPlaylist[index - 1]);
//     }
// }



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

    container.innerHTML = ''; 

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
        container.appendChild(songCard);
    });
    highlightNowPlaying(); 
}

function playSongFromObject(song) {
    if (!song || (!song.file && !song.filename)) {
        console.warn("⛔ Không đủ dữ liệu để phát bài:", song);
        return;
    }

    currentSongId = Number(song.id);

    const fileUrl = song.file || `${BASE}/uploads/songs/${song.filename}`;
    const thumbnailUrl =
        song.thumbnail?.startsWith('http') || song.thumbnail?.startsWith('/')
            ? song.thumbnail
            : `${BASE}/uploads/thumbnails/${song.thumbnail}`;

    const audio = document.getElementById('global-audio');
    if (audio) {
        audio.src = fileUrl;
        audio.play();
    }

    const bar = document.getElementById('controller-bar');
    if (bar) bar.classList.remove('hidden');

    const titleEl = document.getElementById('now-playing-title');
    const artistEl = document.getElementById('now-playing-artist');
    const thumbEl = document.getElementById('now-playing-thumb');

    if (titleEl) titleEl.textContent = song.title || "Unknown";
    if (artistEl) artistEl.textContent = song.artist || "Unknown";
    if (thumbEl) thumbEl.src = thumbnailUrl;

    highlightNowPlaying(song.id);
}



    
function openPlaylistDisplay(playlistId) {
    if (!playlistId) return;
    fetch(`${BASE}/component/playlistdisplay?id=${playlistId}`)
    .then(res => res.text())
    .then(html => {
        const app = document.getElementById('app');
        if (app) app.innerHTML = html;
    })
    .catch(err => console.error(" Unable to load playlist interface:", err));
}

function playRandomFromListsongs() {
    const songs = document.querySelectorAll('[data-songcard]');
    if (songs.length === 0) return;

    const randomIndex = Math.floor(Math.random() * songs.length);
    songs[randomIndex].click(); 
}
function highlightNowPlaying(songId) {
    const allCards = document.querySelectorAll('.songcard');
    allCards.forEach(card => {
        const id = Number(card.dataset.songcard);
        if (id === Number(songId)) {
            card.classList.add('border', 'border-blue-500');
        } else {
            card.classList.remove('border', 'border-blue-500');
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
    const cardWidth = container.querySelector(".playlist-card").offsetWidth + 20; 
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
            console.warn(" User not logged in  mở login modal");
            openLoginModal();
            return;
        }

        document.getElementById('addToPlaylistModal')?.remove();
        document.body.insertAdjacentHTML('beforeend', html);
        document.getElementById('addToPlaylistModal')?.classList.remove('hidden');
    })
    .catch(err => console.error(" Error loading playlist popup:", err));
}
function closeAddToPlaylistModal() {
    document.getElementById('addToPlaylistModal')?.remove();
}

function toggleCreatePlaylist(show) {
    document.getElementById('choosePlaylistSection')?.classList.toggle('hidden', show);
    document.getElementById('createPlaylistSection')?.classList.toggle('hidden', !show);
    const title = document.getElementById('playlistModalTitle');
    if (title) title.innerText = show ? 'Create new playlist' : 'Add to playlist';
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
function reloadNavbar() {
    fetch(`${BASE}/component/navbar`)
        .then(res => res.text())
        .then(html => {
            const nav = document.getElementById('navbar');
            if (nav) nav.innerHTML = html;
        })
        .catch(err => console.error("Failed to reload navbar", err));
}

document.addEventListener('submit', function (e) {
    if (e.target.id === 'loginForm') {
        e.preventDefault();

        const formData = new FormData(e.target);

        fetch(`${BASE}/login`, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            const errorP = document.getElementById('loginError');
            if (data.success) {
                closeLoginModal();
                reloadNavbar();
                loadComponent('home');
            } else {
                errorP.textContent = data.message || "Login failed!";
                errorP.classList.remove('hidden');
            }
        });
    }

    if (e.target.id === 'registerForm') {
        e.preventDefault();

        const formData = new FormData(e.target);

        fetch(`${BASE}/register`, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            const errorP = document.getElementById('registerError');
            if (data.success) {
                closeRegisterModal();
                loadComponent('home');
            } else {
                errorP.textContent = data.message || "Registration failed!";
                errorP.classList.remove('hidden');
            }
        });
    }
    if (e.target.id === 'createPlaylistForm') {
        e.preventDefault();
    
        const formData = new FormData(e.target);
    
        fetch(`${BASE}/playlist/create`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toggleCreatePlaylist(false); 
    
                const songId = formData.get('song_id');
                fetch(`${BASE}/playlist/addform?song_id=${songId}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('addToPlaylistModal')?.remove();
                        document.body.insertAdjacentHTML('beforeend', html);
                    });
            } else {
                alert(data.message || "Không thể tạo playlist");
            }
        });
    }
    
    if (e.target.id === 'addToPlaylistForm') {
        e.preventDefault();

        const formData = new FormData(e.target);
        fetch(`${BASE}/playlist/add`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(result => {
            console.log(" Add song to playlist:", result);
            closeAddToPlaylistModal();
            alert(" Added to playlist!");
        });
    }
    if (e.target.id === 'logoutForm') {
        e.preventDefault();

        fetch(`${BASE}/logout`)
            .then(() => {
                reloadNavbar(); 
                loadComponent('home'); 
            })
            .catch(err => console.error("Logout failed:", err));
    }
    if (e.target.id === 'editProfileForm') {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(`${BASE}/user/update-profile`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            const errorP = document.getElementById('editProfileError');
            if (data.success) {
                closeEditProfileModal();
                reloadNavbar();     
                loadComponent('profile'); 
            } else {
                errorP.textContent = data.message;
                errorP.classList.remove('hidden');
            }
        });
    }
    if (e.target.id === 'uploadForm') {
        e.preventDefault();
    
        const formData = new FormData(e.target);
    
        fetch(`${BASE}/song/upload`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("🎵 Upload thành công!");
                loadComponent('home');
            } else {
                alert(data.message || "Lỗi khi upload bài hát.");
            }
        });
    }
    
});
function openEditProfileModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}
function closeEditProfileModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
}
function handleSongCardClick(el) {
    const song = {
        id: Number(el.dataset.songcard),
        title: el.dataset.title,
        artist: el.dataset.artist,
        thumbnail: el.dataset.thumb,
        file: el.dataset.file
    };

    console.log("🎧 Playing song:", song);
    currentSongId = song.id;
    playSongFromObject(song);
}

// Trong script.js
let currentSlide = 0;
const slideSize = 3; // số lượng bài hát mỗi trang

function updateSlide() {
    const slider = document.getElementById('songSlider');
    if (!slider) return; 
  
    const cards = slider.querySelectorAll('.songcard-wrapper');
    const totalSlides = Math.ceil(cards.length / slideSize);
  
    const cardWidth = 220 + 24;
    const offset = currentSlide * cardWidth * slideSize;
  
    slider.style.transform = `translateX(-${offset}px)`;
  
    document.getElementById('prevBtn').disabled = currentSlide === 0;
    document.getElementById('nextBtn').disabled = currentSlide >= totalSlides - 1;
  }

function nextSlide() {
    currentSlide++;
    updateSlide();
}

function prevSlide() {
    currentSlide--;
    updateSlide();
}

document.addEventListener('DOMContentLoaded', updateSlide);

