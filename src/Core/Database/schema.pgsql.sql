CREATE TABLE IF NOT EXISTS categories (
    id serial PRIMARY KEY,
    name varchar(50) NOT NULL UNIQUE,
    sku varchar(10) NOT NULL UNIQUE,
    tax_percentage DECIMAL(11,8) NOT NULL CONSTRAINT not_negative_tax_percentage CHECK (tax_percentage >= 0),
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id serial PRIMARY KEY,
    category_id integer NOT NULL REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
    name varchar(100) NOT NULL UNIQUE,
    sku varchar(10) NOT NULL UNIQUE,
    price DECIMAL(11,2) NOT NULL,
    description text NOT NULL,
    quantity integer NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS cart_items (
    id serial PRIMARY KEY,
    product_id integer NOT NULL REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
    quantity integer NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id serial PRIMARY KEY,
    total_paid DECIMAL(21,2) NOT NULL,
    total_taxes DECIMAL(21,2) NOT NULL,
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id serial PRIMARY KEY,
    order_id integer NOT NULL REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
    product_id integer NOT NULL REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE,
    quantity integer NOT NULL,
    paid_amount DECIMAL(11,2) NOT NULL,
    tax_amount DECIMAL(11,2) NOT NULL,
    tax_percentage DECIMAL(11,8) NOT NULL CONSTRAINT not_negative_tax_percentage CHECK (tax_percentage >= 0),
    created_at timestamp NOT NULL,
    updated_at timestamp NOT NULL
);
