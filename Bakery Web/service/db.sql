CREATE DATABASE bakery {
    CREATE TABLE menu_items {
        menu_id INT AUTO_INCEREMNT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image_url VARCHAR(255) NOT NULL
    }

    CREATE TABLE orders {
        id INT AUTO_INCEREMNT PRIMARY KEY,
        menu_id INT NOT NULL,
        quantity INT NOT NULL,
        order_date TIMESTAMP CURRENT_TIMESTAMP,
        customers_id INT NOT NULL
        FOREIGN KEY (menu_id) REFERENCES menu_items(menu_id)
        FOREIGN KEY (customers_id) REFERENCES regist(id)
    }

    CREATE TABLE pesanan {
        id_pesanan INT AUTO_INCEREMNT PRIMARY KEY,
        customers_id INT NOT NULL,
        metode_pembayaran VARCHAR(50) NOT NULL,
        tanggal_pesan TIMESTAMP CURRENT_TIMESTAMP,
    }

    CREATE TABLE regist {
        id INT AUTO_INCEREMNT PRIMARY KEY,
        mobile_or_email VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        alamat VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP CURRENT_TIMESTAMP,
    }
}