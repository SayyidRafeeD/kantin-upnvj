document.addEventListener('DOMContentLoaded', () => {
    const storeId = document.getElementById('store-id-hidden').value;

    initVoteSystem(storeId);
    initCommentSystem(storeId);
});

const initVoteSystem = (storeId) => {
    const voteButton = document.getElementById('vote-button');
    const voteCountEl = document.getElementById('vote-count-display');
    const messageEl = document.getElementById('vote-message');

    if (!voteButton) return;

    voteButton.addEventListener('click', async () => {
        if (voteButton.disabled) return;

        const originalText = voteButton.textContent;
        voteButton.disabled = true;
        voteButton.textContent = 'Memproses...';

        try {
            const formData = new FormData();
            formData.append('store_id', storeId);

            const response = await fetch('api/handle_vote.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                voteButton.textContent = 'Vote Masuk!';
                voteButton.classList.add('voted-today'); // Bisa distyling css
                voteCountEl.textContent = result.new_vote_count;

                setTimeout(() => {
                    voteButton.textContent = 'Vote Lagi Besok';
                }, 1500);

            } else {
                voteButton.textContent = 'Gagal';
                voteButton.disabled = false;
                setTimeout(() => { voteButton.textContent = originalText; }, 2000);
            }

            if (messageEl) {
                messageEl.textContent = result.message;
                messageEl.style.display = 'block';
                messageEl.className = result.success ? 'vote-msg-success' : 'vote-msg-error';
            }

        } catch (error) {
            console.error(error);
            voteButton.textContent = 'Error';
            voteButton.disabled = false;
        }
    });
};

const initCommentSystem = (storeId) => {
    const commentForm = document.getElementById('comment-form');
    const commentInput = document.getElementById('comment-input');
    const charCount = document.getElementById('char-count');
    const commentsList = document.getElementById('comments-list');

    loadComments(storeId, commentsList);

    if (commentInput) {
        commentInput.addEventListener('input', (e) => {
            const currentLength = e.target.value.length;
            charCount.textContent = `${currentLength}/200`;
            if (currentLength >= 200) {
                charCount.style.color = 'red';
            } else {
                charCount.style.color = '#777';
            }
        });
    }

    if (commentForm) {
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const commentText = commentInput.value.trim();
            if (!commentText) return;

            const submitBtn = commentForm.querySelector('button');
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            try {
                const response = await fetch('api/post_comment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ store_id: storeId, comment: commentText })
                });

                const result = await response.json();

                if (result.success) {
                    commentInput.value = '';
                    charCount.textContent = '0/200';
                    loadComments(storeId, commentsList);
                } else {
                    alert(result.message);
                }

            } catch (error) {
                console.error('Error posting comment:', error);
                alert('Gagal mengirim komentar. Cek koneksi internet.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalBtnText;
            }
        });
    }
};

const loadComments = async (storeId, listContainer) => {
    try {
        const response = await fetch(`api/get_comments.php?store_id=${storeId}`);
        const result = await response.json();

        if (result.success) {
            renderComments(result.data, listContainer);
        }
    } catch (error) {
        console.error('Gagal memuat komentar:', error);
        listContainer.innerHTML = '<p class="no-comments">Gagal memuat komentar.</p>';
    }
};

const renderComments = (comments, container) => {
    container.innerHTML = '';

    if (comments.length === 0) {
        container.innerHTML = '<p class="no-comments">Belum ada ulasan. Jadilah yang pertama!</p>';
        return;
    }

    comments.forEach(comment => {
        const dateStr = timeAgo(comment.created_at);
        const safeName = escapeHTML(comment.full_name);
        const safeText = escapeHTML(comment.comment_text);

        const item = document.createElement('div');
        item.className = 'comment-item';
        item.innerHTML = `
            <div class="comment-header">
                <span class="comment-user">${safeName}</span>
                <span class="comment-date">${dateStr}</span>
            </div>
            <div class="comment-body">
                ${safeText}
            </div>
        `;
        container.appendChild(item);
    });
};

const escapeHTML = (str) => {
    if (!str) return '';
    return str.replace(/[&<>"']/g, (match) => {
        const escape = {
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        };
        return escape[match];
    });
};

const timeAgo = (dateString) => {
    const date = new Date(dateString.replace(' ', 'T'));
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) return 'Baru saja';

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes} menit yang lalu`;

    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours} jam yang lalu`;

    const days = Math.floor(hours / 24);
    if (days < 7) return `${days} hari yang lalu`;

    return date.toLocaleDateString('id-ID');
};