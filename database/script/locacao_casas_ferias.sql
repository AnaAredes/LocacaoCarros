CREATE TABLE tipo_bens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE marca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_bem_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    observacao TEXT,
    FOREIGN KEY (tipo_bem_id) REFERENCES tipo_bens(id)
);

CREATE TABLE bens_locaveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca_id INT NOT NULL,
    modelo VARCHAR(100),
    registo_unico_publico VARCHAR(20),
    numero_quartos INT,
    numero_passageiros INT,
    numero_casas_banho INT,
    numero_camas INT,
    ano INT,
    manutencao BOOLEAN DEFAULT TRUE,
    preco_diario DECIMAL(10,2),
    observacao VARCHAR(200),
    FOREIGN KEY (marca_id) REFERENCES marca(id)
);

CREATE TABLE localizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bem_locavel_id INT,
    cidade VARCHAR(100) NOT NULL,
    filial VARCHAR(100),
    posicao VARCHAR(100) NOT NULL,
    FOREIGN KEY (bem_locavel_id) REFERENCES bens_locaveis(id) ON DELETE CASCADE,
    UNIQUE (filial, posicao)
);

CREATE TABLE caracteristicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE bem_caracteristicas (
    bem_locavel_id INT,
    caracteristica_id INT,
    PRIMARY KEY (bem_locavel_id, caracteristica_id),
    FOREIGN KEY (bem_locavel_id) REFERENCES bens_locaveis(id) ON DELETE CASCADE,
    FOREIGN KEY (caracteristica_id) REFERENCES caracteristicas(id) ON DELETE CASCADE
);

INSERT INTO tipo_bens (id, nome) VALUES (2, 'Bangalow');

INSERT INTO marca (id, tipo_bem_id, nome, observacao) VALUES
(1, 2, 'Standard', 'Conforto essencial para até 2 pessoas.'),
(2, 2, 'Luxo', 'Com piscina privativa e vista panorâmica.'),
(3, 2, 'Familiar', 'Espaço para até 6 pessoas, ideal para famílias.');

INSERT INTO bens_locaveis (
    marca_id, modelo, registo_unico_publico, numero_quartos, numero_passageiros, numero_casas_banho, numero_camas, ano, manutencao, preco_diario, observacao
) VALUES 
(1, 'Brisa Marítima', '10001/22', 3, 6, 2, 3, 2020, FALSE, 75.00, ''),
(1, 'Paraíso Solar', '10002/23', 4, 8, 2, 4, 2021, FALSE, 85.00, ''),
(2, 'Encanto Azul', '10003/21', 5, 10, 3, 5, 2019, FALSE, 160.00, ''),
(2, 'Mirante Celestial', '10004/24', 3, 6, 2, 3, 2024, FALSE, 155.00, ''),
(3, 'Recanto Natural', '10005/20', 4, 8, 2, 4, 2020, FALSE, 210.00, ''),
(3, 'Beira Litorânea', '10006/23', 5, 10, 3, 5, 2021, FALSE, 220.00, ''),
(1, 'Brisa Costeira', '10007/22', 2, 4, 1, 2, 2018, FALSE, 70.00, ''),
(2, 'Serenidade Verde', '10008/21', 3, 6, 2, 3, 2020, FALSE, 145.00, ''),
(3, 'Retiro Silvestre', '10009/22', 4, 8, 2, 4, 2019, FALSE, 205.00, ''),
(1, 'Refúgio Revigorante', '10010/23', 2, 4, 1, 2, 2022, FALSE, 90.00, ''),
(1, 'Recanto Silvestre', '10011/20', 3, 6, 2, 3, 2020, FALSE, 95.00, ''),
(2, 'Brisa da Montanha', '10012/24', 4, 8, 2, 4, 2023, FALSE, 165.00, ''),
(2, 'Encanto Natural', '10013/21', 3, 6, 2, 3, 2021, FALSE, 170.00, ''),
(3, 'Sol e Ondas', '10014/22', 5, 10, 3, 5, 2019, FALSE, 215.00, ''),
(3, 'Pôr do Sol Dourado', '10015/23', 4, 8, 2, 4, 2022, FALSE, 195.00, ''),
(1, 'Refúgio Sereno', '10016/20', 2, 4, 1, 2, 2020, FALSE, 78.00, '');

INSERT INTO localizacoes (bem_locavel_id, cidade, filial, posicao) VALUES
(1, 'Albufeira', 'Praia da Oura', 'Casa 1'),
(2, 'Albufeira', 'Praia da Oura', 'Casa 2'),
(3, 'Albufeira', 'Praia da Oura', 'Casa 3'),
(4, 'Gerês', 'Montanhas Verdes', 'Casa Lago 1'),
(5, 'Gerês', 'Montanhas Verdes', 'Casa Lago 2'),
(6, 'Peniche', 'Praia do Baleal', 'Casa Praia Norte 1'),
(7, 'Peniche', 'Praia do Baleal', 'Casa Praia Norte 2'),
(8, 'Setúbal', 'Parque Natural da Arrábida', 'Casa Miradouro 1'),
(9, 'Setúbal', 'Parque Natural da Arrábida', 'Casa Miradouro 2'),
(10, 'Porto', 'Foz do Douro', 'Casa Atlântico 1'),
(11, 'Porto', 'Foz do Douro', 'Casa Atlântico 2'),
(12, 'Porto', 'Foz do Douro', 'Casa Atlântico 3'),
(13, 'Gerês', 'Montanhas Verdes', 'Casa Lago 3'),
(14, 'Albufeira', 'Praia da Oura', 'Casa 4'),
(15, 'Albufeira', 'Praia da Oura', 'Casa 5'),
(16, 'Setúbal', 'Parque Natural da Arrábida', 'Casa Miradouro 3');

INSERT INTO caracteristicas (nome) VALUES 
('TV satélite'),
('Aquecimento'),
('Roupas de cama'),
('Cozinha equipada'),
('Fogão'),
('Frigorífico'),
('Loiças'),
('Microondas'),
('Produtos de higiene'),
('Toalhas'),
('WC com duche'),
('Jardim'),
('Churrasqueira'),
('Mobiliário exterior'),
('Estacionamento privado'),
('Aceita animais');

INSERT INTO bem_caracteristicas (bem_locavel_id, caracteristica_id) VALUES
(1, 1), (1, 6), (1, 8),
(2, 2), (2, 6), (2, 4),
(3, 4),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10),
(10, 11),
(11, 12),
(12, 13),
(13, 14),
(14, 15),
(15, 16),
(16, 12), (16, 3);