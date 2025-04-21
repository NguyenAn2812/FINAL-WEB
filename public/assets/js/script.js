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

function playSong(file, title, artist, thumb) {
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
function loadSongDisplay(songId) {
    fetch(`${BASE}/component/songdisplay?id=${songId}`)
      .then(res => res.text())
      .then(html => {
        const app = document.getElementById('app');
        if (app) {
          app.innerHTML = html;
        }
      })
      .catch(err => {
        console.error("Unable to load song display interface", err);
      });
  }
  
