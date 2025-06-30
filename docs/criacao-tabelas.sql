-- Criação das tabelas principais do sistema de estoque de farmácia (PostgreSQL)

-- Tabela de usuários
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    auth_key VARCHAR(32),
    created_at INTEGER,
    updated_at INTEGER,
    role VARCHAR(32) NOT NULL DEFAULT 'operador'
);

-- Tabela de produtos
CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INTEGER NOT NULL,
    price NUMERIC(10,2) NOT NULL,
    created_at INTEGER,
    updated_at INTEGER,
    expiry_date DATE,
    minimum_stock INTEGER,
    category VARCHAR(50),
    manufacturer VARCHAR(100),
    batch VARCHAR(50),
    barcode VARCHAR(50)
);

-- Tabela de movimentações de estoque
CREATE TABLE stock_movement (
    id SERIAL PRIMARY KEY,
    product_id INTEGER NOT NULL REFERENCES product(id),
    user_id INTEGER NOT NULL REFERENCES "user"(id),
    type VARCHAR(10) NOT NULL,
    quantity INTEGER NOT NULL,
    created_at INTEGER,
    reason VARCHAR(50)
);

-- Tabela de logs de auditoria
CREATE TABLE audit_log (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES "user"(id),
    action VARCHAR(50),
    model VARCHAR(50),
    model_id INTEGER,
    data TEXT,
    created_at INTEGER
); 