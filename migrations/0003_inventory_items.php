<?php

return [
    'CREATE TABLE IF NOT EXISTS inventory_item (id INT AUTO_INCREMENT NOT NULL, item_id_id INT NOT NULL, warehouse_id_id INT NOT NULL, inventory_count INT NOT NULL, INDEX IDX_55BDEA3055E38587 (item_id_id), INDEX IDX_55BDEA30FE25E29A (warehouse_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
    'ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA3055E38587 FOREIGN KEY (item_id_id) REFERENCES product_items (id)',
    'ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30FE25E29A FOREIGN KEY (warehouse_id_id) REFERENCES warehouses (id)'
];