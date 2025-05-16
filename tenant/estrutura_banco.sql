CREATE DATABASE IF NOT EXISTS multitenancy;
USE multitenancy;

CREATE TABLE tenants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100)
);

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT,
  nome VARCHAR(100),
  email VARCHAR(100),
  senha VARCHAR(255),
  FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT,
  descricao VARCHAR(255),
  preco DECIMAL(10,2),
  FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);