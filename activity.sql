CREATE TABLE activity (
    id_akun int(11) NOT NULL,
    tipe_activity VARCHAR(255) NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    durasi INT NOT NULL,
    status_activity VARCHAR(255) NOT NULL,
    detail_activity TEXT NOT NULL
);
a