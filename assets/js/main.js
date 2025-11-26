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
    const paginationContainer = document.getElementById('pagination-container');
    const noResultsMessage = document.getElementById('no-results-message');

    if (!searchForm) return;

    let currentPage = 1;

    const fetchData = async (page = 1) => {
        const query = searchInput.value;
        const sort = sortSelect.value;
        currentPage = page; // Update state

        gridContainer.style.opacity = '0.5';

        try {
            const response = await fetch(`api/search_stores.php?query=${encodeURIComponent(query)}&sort=${sort}&page=${page}`);
            const result = await response.json();

            gridContainer.style.opacity = '1';

            if (result.success && result.data.length > 0) {
                renderResults(result.data);
                renderPagination(result.pagination);

                gridContainer.style.display = 'grid';
                paginationContainer.style.display = 'flex';
                if (noResultsMessage) noResultsMessage.style.display = 'none';
            } else {
                gridContainer.style.display = 'none';
                paginationContainer.style.display = 'none';
                if (noResultsMessage) noResultsMessage.style.display = 'block';
            }
        } catch (error) {
            console.error(error);
            gridContainer.style.opacity = '1';
        }
    };

    const renderResults = (stores) => {
        gridContainer.innerHTML = '';
        stores.forEach(store => {
            const safeImage = escapeHTML(store.image_url);
            const safeName = escapeHTML(store.store_name);
            const safeCanteen = escapeHTML(store.canteen_name);
            const safeUrl = escapeHTML(store.detail_url);

            const storeCard = `
            <article class="store-card">
                <div class="card-image-wrapper">
                    <img src="${safeImage}" 
                         alt="${safeName}" 
                         class="card-image"
                         loading="lazy"
                         onerror="this.src='https://placehold.co/400x250/ddd/777?text=Error+Load';">
                </div>
                <div class="card-content">
                    <h3 class="card-title">${safeName}</h3>
                    <p class="card-location">${safeCanteen}</p>
                    <div class="card-footer">
                        <div class="card-stats">
                            <span class="stat-item" title="Jumlah Vote">
                                👍 ${store.total_votes}
                            </span>
                            <span class="stat-item" title="Jumlah Komentar">
                                💬 ${store.total_comments}
                            </span>
                        </div>
                        <a href="${safeUrl}" class="card-button">Lihat Menu</a>
                    </div>
                </div>
            </article>
            `;
            gridContainer.innerHTML += storeCard;
        });
    };

    const renderPagination = (meta) => {
        paginationContainer.innerHTML = '';

        if (meta.total_pages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.innerText = '« Prev';
        prevBtn.className = 'page-btn';
        prevBtn.disabled = meta.current_page === 1;
        prevBtn.onclick = () => {
            fetchData(meta.current_page - 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        paginationContainer.appendChild(prevBtn);

        const info = document.createElement('span');
        info.className = 'page-info';
        info.innerText = `${meta.current_page} / ${meta.total_pages}`;
        paginationContainer.appendChild(info);

        const nextBtn = document.createElement('button');
        nextBtn.innerText = 'Next »';
        nextBtn.className = 'page-btn';
        nextBtn.disabled = meta.current_page === meta.total_pages;
        nextBtn.onclick = () => {
            fetchData(meta.current_page + 1);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        paginationContainer.appendChild(nextBtn);
    };

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchData(1);
    });

    searchInput.addEventListener('keyup', (e) => {
        fetchData(1);
    });

    sortSelect.addEventListener('change', () => {
        fetchData(1);
    });

    fetchData(1);
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

        if (hasLen && hasNum && hasLet && isMatch) {
            btnRegister.disabled = false;
            btnRegister.style.opacity = 1;
        } else {
            btnRegister.disabled = true;
            btnRegister.style.opacity = 0.6;
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