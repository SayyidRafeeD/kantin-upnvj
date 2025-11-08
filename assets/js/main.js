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

const handleVote = () => {
    const voteButton = document.getElementById('vote-button');
    const voteCountEl = document.getElementById('vote-count-number');
    const messageEl = document.getElementById('vote-message');

    if (!voteButton) {
        return;
    }

    voteButton.addEventListener('click', async () => {
        const storeId = voteButton.dataset.storeId;
        voteButton.disabled = true;
        voteButton.textContent = 'Memproses...';

        try {
            const response = await fetch('api/handle_vote.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ store_id: storeId })
            });

            const result = await response.json();

            if (result.success) {
                voteButton.textContent = 'Vote Berhasil!';
                voteCountEl.textContent = result.new_vote_count;
                if (messageEl) messageEl.style.display = 'none';
            } else {
                voteButton.textContent = 'Anda Sudah Vote';
                if (messageEl) {
                    messageEl.textContent = result.message || 'Error: Anda sudah vote';
                    messageEl.style.display = 'block';
                }
            }
        } catch (error) {
            voteButton.textContent = 'Error!';
            voteButton.disabled = false;
            if (messageEl) {
                messageEl.textContent = 'Terjadi kesalahan jaringan.';
                messageEl.style.display = 'block';
            }
        }
    });
};

const handleSearch = () => {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search-input');
    const gridContainer = document.getElementById('store-grid-container');
    const noResultsMessage = document.getElementById('no-results-message');

    if (!searchForm) {
        return;
    }

    const fetchSearch = async (searchTerm) => {
        try {
            const response = await fetch(`api/search_stores.php?query=${encodeURIComponent(searchTerm)}`);
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                renderResults(result.data);
                gridContainer.style.display = 'grid';
                noResultsMessage.style.display = 'none';
            } else {
                gridContainer.style.display = 'none';
                noResultsMessage.style.display = 'block';
            }
        } catch (error) {
            gridContainer.style.display = 'none';
            noResultsMessage.style.display = 'block';
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

    const escapeHTML = (str) => {
        if (!str) return '';
        return str.replace(/[&<>"']/g, function(match) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[match];
        });
    };

    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const searchTerm = searchInput.value;
        fetchSearch(searchTerm);
    });
    
    searchInput.addEventListener('keyup', (e) => {
        const searchTerm = e.target.value;
        if (searchTerm.length > 2 || searchTerm.length === 0) {
            fetchSearch(searchTerm);
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    navSlide();
    handleVote();
    handleSearch();
});