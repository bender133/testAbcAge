create table if not exists products
(
    id          int auto_increment primary key,
    name        varchar(255) not null,
    description text         null,
    is_active   tinyint(1) default 1,
    KEY name_fk (name) USING BTREE,
    constraint name unique (name)
);

INSERT INTO products (name)
VALUES ("Колбаса"),
       ("Пармезан"),
       ("Левый носок");

create table if not exists clients
(
    id        INT         NOT NULL AUTO_INCREMENT primary key,
    name      VARCHAR(32) NOT NULL,
    is_active tinyint(1) default 1,
    KEY name_fk (name) USING BTREE,
    constraint name unique (name)
);

INSERT INTO clients (name)
VALUES ("ЛевНосокСтор"),
       ("Колбасная"),
       ("Беляшная");

create table if not exists deliveries
(
    id              INT          NOT NULL AUTO_INCREMENT,
    delivery_number VARCHAR(255) NOT NULL COMMENT 'номер поставки товара',
    product_name    VARCHAR(255) NOT NULL,
    quantity        INT                   DEFAULT 0,
    cost            INT          NOT NULL DEFAULT 0,
    date            DATETIME     NOT NULL,
    product_id      INT                   DEFAULT NULL,
    is_aprove       tinyint(1)            DEFAULT 0,
    KEY date (date) USING BTREE,
    KEY is_aprove (is_aprove) USING BTREE,
    PRIMARY KEY (id),
    CONSTRAINT deliveries_products_fk
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE SET NULL,
    constraint delivery_number unique (delivery_number)
);

INSERT INTO deliveries
(delivery_number,
 product_name,
 quantity,
 cost,
 date,
 product_id)
VALUES ("1", "Колбаса", "300", "5000", "2021-01-01", (select id from products where name = 'Колбаса')),
       ("t-500", "Пармезан", "10", "6000", "2021-01-02", (select id from products where name = 'Пармезан')),
       ("12-TP-777", "Левый носок", "100", "500", "2021-01-13", (select id from products where name = 'Левый носок')),
       ("12-TP-778", "Левый носок", "50", "300", "2021-01-14", (select id from products where name = 'Левый носок')),
       ("12-TP-779", "Левый носок", "77", "539", "2021-01-20", (select id from products where name = 'Левый носок')),
       ("12-TP-877", "Левый носок", "32", "176", "2021-01-30", (select id from products where name = 'Левый носок')),
       ("12-TP-977", "Левый носок", "94", "554", "2021-02-01", (select id from products where name = 'Левый носок')),
       ("12-TP-979", "Левый носок", "200", "1000", "2021-02-05", (select id from products where name = 'Левый носок'));

create table if not exists preorders
(
    id           INT NOT NULL AUTO_INCREMENT,
    quantity     INT NOT NULL,
    cost         INT NOT NULL DEFAULT 0,
    is_confirmed tinyint(1)   DEFAULT NULL COMMENT 'null -не обработан, 0 - отменен, 1 - исполнен',
    client_id    INT NOT NULL,
    created_at   DATETIME     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY is_confirmed (is_confirmed) USING BTREE,
    CONSTRAINT preorders_clints_fk
        FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE RESTRICT
);

create table if not exists preorder_items
(
    id          INT NOT NULL AUTO_INCREMENT,
    preorder_id INT NOT NULL,
    product_id  INT NOT NULL,
    price       INT NOT NULL,
    quantity    INT NOT NULL,
    cost        INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT preorder_items_products_fk
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE RESTRICT,
    CONSTRAINT preorder_fk
        FOREIGN KEY (preorder_id) REFERENCES preorders (id) ON DELETE CASCADE
);

create table if not exists offers
(
    id            INT      NOT NULL AUTO_INCREMENT,
    product_id    INT      NOT NULL,
    delivery_id   INT,
    is_active     tinyint(1) default 1,
    price         INT      NOT NULL,
    quantity      INT      NOT NULL,
    delivery_date DATETIME NOT NULL,
    created_at    DATETIME   DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME   DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY is_active_product_id (is_active, product_id) USING BTREE,
    KEY is_active (is_active) USING BTREE,
    CONSTRAINT offers_products_fk
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE RESTRICT,
    CONSTRAINT offers_delivery_fk
        FOREIGN KEY (delivery_id) REFERENCES deliveries (id) ON DELETE SET NULL
);