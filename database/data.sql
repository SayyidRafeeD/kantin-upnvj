USE db_kantin_upnvj;

INSERT INTO `canteens` (`canteen_name`, `location`)
VALUES
    ('Kantin Ponlab', 'Kampus Pondok Labu'),
    ('Kantin Limo', 'Kampus Limo');

INSERT INTO `stores` (`canteen_id`, `store_name`, `description`, `image_url`)
VALUES
    (1, 'Warung Nasi Ibu A', 'Masakan rumahan, soto, dan aneka lauk.', 'https://placehold.co/400x300/2bae00/f9f9f9?text=Warung+Ibu+A'),
    (1, 'Kopi Senja', 'Kopi susu gula aren dan camilan.', 'https://placehold.co/400x300/76c800/f9f9f9?text=Kopi+Senja'),
    (2, 'Ayam Geprek Mas Bro', 'Spesialis ayam geprek berbagai level pedas.', 'https://placehold.co/400x300/4fa3f7/f9f9f9?text=Geprek+Mas+Bro');

INSERT INTO `menu_items` (`store_id`, `item_name`, `price`)
VALUES
    (1, 'Paket Nasi Ayam Goreng', 15000.00),
    (1, 'Paket Nasi Telur Dadar', 10000.00),
    (1, 'Soto Ayam', 12000.00),
    
    (2, 'Kopi Susu Gula Aren (Es)', 18000.00),
    (2, 'Americano (Panas)', 15000.00),
    (2, 'Donat Coklat', 8000.00),
    
    (3, 'Paket Geprek Level 3', 17000.00),
    (3, 'Paket Geprek Leleh Keju', 20000.00);