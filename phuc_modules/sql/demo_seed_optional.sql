USE comic_store;

INSERT INTO users (full_name, email, password, phone, role) VALUES
('Admin Demo', 'admin@comic.vn', '$2y$10$abcdefghijklmnopqrstuv', '0900000001', 'admin'),
('User Demo', 'user@comic.vn', '$2y$10$abcdefghijklmnopqrstuv', '0900000002', 'user')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name);

INSERT INTO comics (id, name, author, price, stock) VALUES
(1, 'One Piece Tập 1', 'Eiichiro Oda', 25000, 100),
(2, 'Doraemon Tập 5', 'Fujiko F. Fujio', 18000, 80),
(3, 'Conan Tập 10', 'Aoyama Gosho', 22000, 50)
ON DUPLICATE KEY UPDATE name = VALUES(name), price = VALUES(price), stock = VALUES(stock);
