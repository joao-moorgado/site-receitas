CREATE DATABASE IF NOT EXISTS db_estouro_de_pilha;

USE db_estouro_de_pilha;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS db_usr (
  usr_id INT NOT NULL AUTO_INCREMENT,
  usr_name VARCHAR(20) NOT NULL,
  usr_password VARCHAR(255) NOT NULL,
  PRIMARY KEY (usr_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS db_post (
  post_id INT NOT NULL AUTO_INCREMENT,
  post_tittle VARCHAR(30) NOT NULL,
  post_body TEXT NOT NULL,
  -- post_tags,
  post_note INT,
  usr_id INT NOT NULL,
  PRIMARY KEY (post_id),
  FOREIGN KEY (usr_id) REFERENCES db_usr(usr_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS db_comm (
  comm_id INT NOT NULL AUTO_INCREMENT,
  comm_body TEXT NOT NULL,
  comm_note INT,
  usr_id INT NOT NULL,
  post_id INT NOT NULL,
  PRIMARY KEY (comm_id),
  FOREIGN KEY (usr_id) REFERENCES db_usr(usr_id),
  FOREIGN KEY (post_id) REFERENCES db_post(post_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS db_likes (
  like_id INT NOT NULL AUTO_INCREMENT,
  post_id INT NOT NULL,
  usr_id INT NOT NULL,
  PRIMARY KEY (like_id),
  FOREIGN KEY (post_id) REFERENCES db_post(post_id) ON DELETE CASCADE,
  FOREIGN KEY (usr_id) REFERENCES db_usr(usr_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO db_usr (usr_name, usr_password) VALUES 
('Joao', '123'),
('Gabi', '456'),
('Alex', '789'),
('Pabro', '000');

INSERT INTO db_post (post_tittle, post_body, usr_id) VALUES 
('Erro de "Fatal error: Uncaught Error: Call to undefined function" em PHP', 'Ao tentar executar um código PHP, recebo o erro "Fatal error: Uncaught Error: Call to undefined function". O que pode estar causando o problema e como corrigi-lo?', 1),
('Implementando autenticação com JWT em Node.js', 'Estou construindo uma API Node.js e gostaria de implementar autenticação usando JSON Web Tokens (JWT). Poderiam me ajudar com os passos necessários para fazer isso?', 2),
('Criando um gráfico de dispersão interativo com D3.js', 'Preciso criar um gráfico de dispersão interativo para visualizar dados em meu site. Gostaria de usar a biblioteca D3.js para isso, mas não tenho experiência com ela. Há algum tutorial ou exemplo que possa me ajudar a começar?', 3);

INSERT INTO db_comm (comm_body, usr_id, post_id) VALUES
('O erro "Fatal error: Uncaught Error: Call to undefined function" geralmente indica que você está tentando chamar uma função que não foi definida no seu código. Certifique-se de que a função esteja corretamente definida e nomeada antes de chamá-la. Verifique também se a função está acessível no escopo em que você está tentando chamá-la.', 4, 1),
('Se você ainda estiver com problemas, pode ser útil compartilhar o código completo onde o erro está ocorrendo. Isso permitirá que outros desenvolvedores vejam o contexto do seu problema e lhe forneçam ajuda mais específica.', 3, 1),
('A autenticação com JWT é uma ótima maneira de proteger APIs Node.js. Existem várias bibliotecas disponíveis para facilitar a implementação do JWT, como o jsonwebtoken e o passport-jwt.', 1, 2),
('A biblioteca D3.js oferece grande flexibilidade na criação de gráficos personalizados. Você pode usar várias técnicas para estilizar seus pontos de dados, como alterar a cor, o tamanho e a opacidade. Também pode adicionar eixos personalizados, legendas e outros elementos gráficos para aprimorar a visualização de seus dados.', 1, 3),
('Se você estiver com dificuldades para criar seu gráfico de dispersão, existem muitos exemplos online que você pode consultar. O repositório D3.js GitHub contém uma coleção de exemplos que podem ser úteis: https://github.com/d3', 4, 3);

COMMIT;