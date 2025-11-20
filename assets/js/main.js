const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    if (burger) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-active');
            burger.classList.toggle('toggle');
        });
    }
};

const handleSearchAndSort = () => {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const sortSelect = document.getElementById('sort-select');
    const gridContainer = document.getElementById('store-grid-container');
    const noResultsMessage = document.getElementById('no-results-message');

    if (!searchForm) return;

    const fetchData = async () => {
        const query = searchInput.value;
        const sort = sortSelect.value;

        try {
            const response = await fetch(`api/search_stores.php?query=${encodeURIComponent(query)}&sort=${sort}`);
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                renderResults(result.data);
                gridContainer.style.display = 'grid';
                if (noResultsMessage) noResultsMessage.style.display = 'none';
            } else {
                gridContainer.style.display = 'none';
                if (noResultsMessage) noResultsMessage.style.display = 'block';
            }
        } catch (error) {
            console.error(error);
        }
    };

    const renderResults = (stores) => {
        gridContainer.innerHTML = '';
        stores.forEach(store => {
            const storeCard = `
            <article class="store-card">
                <div class="card-image-wrapper">
                    <img src="${escapeHTML(store.image_url)}" 
                         alt="${escapeHTML(store.store_name)}" 
                         class="card-image"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/400x250/ddd/777?text=Error+Load';">
                </div>
                <div class="card-content">
                    <h3 class="card-title">${escapeHTML(store.store_name)}</h3>
                    <p class="card-location">${escapeHTML(store.canteen_name)}</p>
                    <div class="card-footer">
                        <span class="card-votes">${store.total_votes} suara</span>
                        <a href="${escapeHTML(store.detail_url)}" class="card-button">Lihat Menu</a>
                    </div>
                </div>
            </article>
            `;
            gridContainer.innerHTML += storeCard;
        });
    };

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchData();
    });

    searchInput.addEventListener('keyup', (e) => {
        fetchData();
    });

    sortSelect.addEventListener('change', () => {
        fetchData();
    });
};

const handleLogin = () => {
    const loginForm = document.getElementById('login-form');
    const popup = document.getElementById('login-popup');
    const popupMsg = document.getElementById('popup-message');
    const popupContent = document.querySelector('.popup-content');

    if (!loginForm) return;

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = document.getElementById('btn-login');
        const originalText = btn.textContent;
        btn.textContent = 'Loading...';
        btn.disabled = true;

        const formData = new FormData(loginForm);

        try {
            const response = await fetch('api/login_process.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                window.location.href = 'index.php';
            } else {
                if (popup && popupMsg) {
                    popupMsg.textContent = result.message;
                    popup.style.display = 'flex';

                    popupContent.classList.add('shake');
                    setTimeout(() => popupContent.classList.remove('shake'), 500);
                } else {
                    alert(result.message);
                }
            }
        } catch (error) {
            alert('Terjadi kesalahan jaringan.');
        } finally {
            btn.textContent = originalText;
            btn.disabled = false;
        }
    });
};

const handleRegisterValidation = () => {
    const passInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    const btnRegister = document.getElementById('btn-register');

    const reqLen = document.getElementById('req-length');
    const reqNum = document.getElementById('req-number');
    const reqLet = document.getElementById('req-letter');
    const matchMsg = document.getElementById('match-message');

    if (!passInput) return;

    const validatePassword = () => {
        const val = passInput.value;

        const hasLen = val.length >= 8;
        const hasNum = /[0-9]/.test(val);
        const hasLet = /[A-Za-z]/.test(val);

        updateClass(reqLen, hasLen);
        updateClass(reqNum, hasNum);
        updateClass(reqLet, hasLet);

        const isMatch = val === confirmInput.value && val !== '';
        if (confirmInput.value.length > 0) {
            if (!isMatch) {
                matchMsg.style.display = 'block';
                matchMsg.style.color = 'red';
                matchMsg.textContent = 'Password tidak cocok';
            } else {
                matchMsg.style.display = 'block';
                matchMsg.style.color = 'green';
                matchMsg.textContent = 'Password cocok!';
            }
        } else {
            matchMsg.style.display = 'none';
        }

        // Enable/Disable Button
        if (hasLen && hasNum && hasLet && isMatch) {
            btnRegister.disabled = false;
            btnRegister.style.opacity = 1;
        } else {
            btnRegister.disabled = true;
            btnRegister.style.opacity = 0.6;
        }
    };

    const updateClass = (el, isValid) => {
        if (isValid) {
            el.classList.remove('invalid');
            el.classList.add('valid');
            el.innerHTML = '&#10003; ' + el.innerText.replace('✓ ', '').replace('✗ ', '');
        } else {
            el.classList.remove('valid');
            el.classList.add('invalid');
            el.innerHTML = '✗ ' + el.innerText.replace('✓ ', '').replace('✗ ', '');
        }
    };

    passInput.addEventListener('input', validatePassword);
    confirmInput.addEventListener('input', validatePassword);
};


window.togglePassword = (id) => {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
};

const escapeHTML = (str) => {
    if (!str) return '';
    return str.replace(/[&<>"']/g, function(match) {
        return {
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[match];
    });
};

document.addEventListener('DOMContentLoaded', () => {
    navSlide();
    handleSearchAndSort();
    handleLogin();
    handleRegisterValidation();
});