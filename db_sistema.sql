CREATE DATABASE chamados;
USE chamados;

CREATE TABLE usuario (
    cd_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nm_usuario VARCHAR(100) NOT NULL,
    senha_usuario VARCHAR(255) NOT NULL,
    email_usuario VARCHAR(150) UNIQUE NOT NULL
);

CREATE TABLE novo_chamado (
    id_chamado INT AUTO_INCREMENT PRIMARY KEY,
    tp_chamado INT NOT NULL,
    tp_urgencia INT NOT NULL,
    ds_chamados VARCHAR(255) NOT NULL,
    dt_chamado DATE NOT NULL,
    fk_cd_usuario INT NOT NULL,
    FOREIGN KEY (fk_cd_usuario) REFERENCES usuario(cd_usuario)

);

CREATE TABLE chamados (
    id_chamados INT AUTO_INCREMENT PRIMARY KEY,
    st_chamados VARCHAR(100) NOT NULL,
    qt_chamados INT NULL,
    fk_id_chamados INT,
    FOREIGN KEY (fk_id_chamados) REFERENCES novo_chamado(id_chamado)
);

INSERT INTO usuario (nm_usuario, senha_usuario, email_usuario)
VALUES
('Ana Souza', 'senha123', 'ana.souza@email.com'),
('Bruno Lima', 'abc456', 'bruno.lima@email.com'),
('Carla Mendes', 'pass789', 'carla.mendes@email.com');

INSERT INTO novo_chamado (tp_chamado, tp_urgencia, ds_chamados, dt_chamado, fk_cd_usuario)
VALUES
(1, 3, 'Erro ao acessar o sistema de login', '2025-11-10', 1),
(2, 1, 'Solicitação de criação de conta', '2025-11-11', 2),
(3, 2, 'Demora no carregamento da página principal', '2025-11-12', 3);

INSERT INTO chamados (st_chamados, qt_chamados, fk_id_chamados)
VALUES
('Aberto', 1, 1),
('Em andamento', 2, 2),
('Concluído', 1, 3);
----------------------------------------------------------

SELECT id_chamado, ds_chamados, tp_urgencia
FROM novo_chamado;

SELECT cd_usuario, nm_usuario, email_usuario
FROM usuario;

SELECT id_chamado, nm_usuario, ds_chamados, st_chamados, dt_chamado
FROM novo_chamado
JOIN usuario ON fk_cd_usuario = cd_usuario
JOIN chamados ON fk_id_chamados = id_chamado;

SELECT id_chamado, ds_chamados, tp_chamado, tp_urgencia, st_chamados
FROM novo_chamado
JOIN chamados ON fk_id_chamados = id_chamado
WHERE tp_urgencia = 1;

SELECT st_chamados AS status, COUNT(*) AS total_chamados
FROM chamados
GROUP BY st_chamados;

SELECT id_chamado, ds_chamados, dt_chamado, nm_usuario
FROM novo_chamado
JOIN usuario ON fk_cd_usuario = cd_usuario
JOIN chamados ON fk_id_chamados = id_chamado
WHERE st_chamados = 'Concluído'
ORDER BY dt_chamado DESC
LIMIT 10;

----------------------------------------------------------


