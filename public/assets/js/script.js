function loadComponent(name) {
    fetch(`/component/${name}`)
        .then(response => {
            if (!response.ok) throw new Error("Component not found");
            return response.text();
        })
        .then(html => {
            document.getElementById('app').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('app').innerHTML = `<p class="text-red-500">Error: ${err.message}</p>`;
        });
}
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
            content.innerHTML = `<p class="text-red-500">Không thể tải form đăng ký.</p>`;
        });
}

function closeRegisterModal() {
    const modal = document.getElementById('registerModal');
    if (modal) modal.classList.add('hidden');
}
