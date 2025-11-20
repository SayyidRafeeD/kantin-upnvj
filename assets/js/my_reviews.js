document.addEventListener('DOMContentLoaded', () => {
    loadMyReviews();
});

const reviewsContainer = document.getElementById('reviews-list');
const emptyState = document.getElementById('empty-state');

let currentEditId = null;

const loadMyReviews = async () => {
    try {
        const response = await fetch('api/get_user_reviews.php');
        const result = await response.json();

        if (result.success) {
            renderReviews(result.data);
        } else {
            alert('Gagal memuat data: ' + result.message);
        }
    } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan jaringan.');
    }
};

const renderReviews = (reviews) => {
    reviewsContainer.innerHTML = '';

    if (reviews.length === 0) {
        reviewsContainer.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }

    emptyState.style.display = 'none';
    reviewsContainer.style.display = 'block';

    reviews.forEach(review => {
        const card = document.createElement('div');
        card.className = 'review-card';
        card.id = `review-${review.comment_id}`;

        const dateStr = new Date(review.created_at).toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        const editedLabel = review.updated_at ? '<small style="font-style:italic; color:#aaa;">(diedit)</small>' : '';

        card.innerHTML = `
            <div class="review-img-wrapper">
                <img src="${escapeHTML(review.image_url)}" class="review-img" alt="Store">
            </div>
            <div class="review-content">
                <div class="review-header">
                    <a href="store.php?id=${review.store_id}" class="store-name-link">
                        ${escapeHTML(review.store_name)}
                    </a>
                    <span class="review-date">${dateStr}</span>
                </div>
                <div class="review-text" id="text-${review.comment_id}">${escapeHTML(review.comment_text)}</div>
                ${editedLabel}
                <div class="review-actions">
                    <button class="btn-action btn-edit" onclick="openEditModal(${review.comment_id})">Edit</button>
                    <button class="btn-action btn-delete" onclick="deleteReview(${review.comment_id})">Hapus</button>
                </div>
            </div>
        `;
        reviewsContainer.appendChild(card);
    });
};

window.deleteReview = async (id) => {
    if (!confirm('Yakin ingin menghapus ulasan ini?')) return;

    try {
        const response = await fetch('api/delete_comment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ comment_id: id })
        });
        const result = await response.json();

        if (result.success) {
            const el = document.getElementById(`review-${id}`);
            if (el) el.remove();

            if (reviewsContainer.children.length === 0) {
                reviewsContainer.style.display = 'none';
                emptyState.style.display = 'block';
            }
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Gagal menghapus.');
    }
};

const modal = document.getElementById('edit-modal');
const modalInput = document.getElementById('edit-input');
const charCount = document.getElementById('edit-char-count');

window.openEditModal = (id) => {
    currentEditId = id;
    const currentText = document.getElementById(`text-${id}`).innerText;
    modalInput.value = currentText;
    charCount.innerText = `${currentText.length}/200`;
    modal.classList.add('active');
};

window.closeEditModal = () => {
    modal.classList.remove('active');
    currentEditId = null;
};

modalInput.addEventListener('input', (e) => {
    charCount.innerText = `${e.target.value.length}/200`;
});

window.saveEdit = async () => {
    const newText = modalInput.value.trim();
    if (!newText) return alert('Komentar tidak boleh kosong');
    if (newText.length > 200) return alert('Maksimal 200 karakter');

    const saveBtn = document.getElementById('btn-save-edit');
    saveBtn.innerText = 'Menyimpan...';
    saveBtn.disabled = true;

    try {
        const response = await fetch('api/update_comment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ comment_id: currentEditId, comment_text: newText })
        });
        const result = await response.json();

        if (result.success) {
            document.getElementById(`text-${currentEditId}`).innerText = newText;
            closeEditModal();
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Gagal update.');
    } finally {
        saveBtn.innerText = 'Simpan Perubahan';
        saveBtn.disabled = false;
    }
};

const escapeHTML = (str) => {
    if (!str) return '';
    return str.replace(/[&<>"']/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m]);
};