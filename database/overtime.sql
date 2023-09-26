CREATE TABLE overtime (
    id_lembur INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    datang TIME NOT NULL,
    pulang TIME NOT NULL,
    agenda VARCHAR(255),
    nota TEXT
);