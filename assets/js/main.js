const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    
    if (burger) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-active');
            
            burger.classList.toggle('toggle');
        });
    }
}

const handleVote = () => {
    const voteButton = document.getElementById('vote-button');
    
    if (voteButton) {
        
        voteButton.addEventListener('click', (e) => {
            e.preventDefault();
            
            const storeId = voteButton.dataset.storeId;
            
            const messageEl = document.getElementById('vote-message');
            const countEl = document.getElementById('vote-count-display');
            
            voteButton.disabled = true;
            voteButton.textContent = 'Memproses...';
            messageEl.textContent = '';
            
            const formData = new FormData();
            formData.append('store_id', storeId);
            
            fetch('api/handle_vote.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                countEl.textContent = data.new_vote_count;
                messageEl.textContent = data.message; 
                
                if (data.success) {
                    voteButton.textContent = 'Vote Berhasil!';
                } else {
                    voteButton.textContent = 'Gagal Vote';
                }
            })
            .catch(error => {
                console.error('Error AJAX:', error);
                messageEl.textContent = 'Terjadi error koneksi. Coba lagi.';
                voteButton.disabled = false;
                voteButton.textContent = 'Beri Suara!';
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    navSlide();    
    handleVote();  
});