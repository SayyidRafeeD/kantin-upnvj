</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">

            <div class="footer-section brand">
                <div class="footer-logo">
                    <img src="assets/images/logo.png" alt="Logo UPNVJ">
                    <span>DIRKA UPNVJ</span>
                </div>
                <p class="footer-desc">
                    Direktori informasi kantin dan kuliner terintegrasi untuk seluruh civitas akademika UPN "Veteran" Jakarta.
                </p>
            </div>

            <div class="footer-section links">
                <h3>Jelajahi</h3>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="index.php">Cari Makan</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="my_reviews.php">Ulasan Saya</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-section links">
                <h3>Ekosistem UPNVJ</h3>
                <ul>
                    <li><a href="https://www.upnvj.ac.id/" target="_blank">Website Utama</a></li>
                    <li><a href="https://akademik.upnvj.ac.id/" target="_blank">SIAKAD</a></li>
                    <li><a href="https://leads.upnvj.ac.id/" target="_blank">Leads</a></li>
                    <li><a href="https://library.upnvj.ac.id/" target="_blank">UPNVJ Library</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
                <h3>Lokasi Kampus</h3>
                <p>
                    Jl. RS. Fatmawati Raya, Pd. Labu, Kec. Cilandak, Kota Depok, Jawa Barat 12450.
                </p>
                <span class="campus-badge">Pondok Labu & Limo</span>
            </div>

        </div>

        <div class="footer-bottom">
            &copy; <?php echo date("Y"); ?> DIRKA UPNVJ. All rights reserved.
        </div>
    </div>
</footer>

<script src="assets/js/main.js"></script>

</body>
</html>