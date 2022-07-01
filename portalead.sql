-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jul-2022 às 07:46
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `portalead`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `cpf`, `telefone`, `email`, `foto`, `ativo`, `data`) VALUES
(1, 'Administrador', '000.000.000-00', '(15) 99180-5895', 'danielantunespaiva@gmail.com', 'sem-perfil.jpg', 'Sim', '2022-05-06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `pais` varchar(40) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `cartao` int(11) NOT NULL,
  `ativo` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `cpf`, `email`, `telefone`, `endereco`, `bairro`, `cidade`, `estado`, `pais`, `foto`, `data`, `cartao`, `ativo`) VALUES
(5, 'Sassa Mutema', '212.121.212-21', 'sassamutema@gmail.com', '(11) 3355-5555', 'Sampaio Correio', 'Vila Madalena', 'Recife', 'AC', 'Costa Rica', '16-05-2022-19-33-37-galinha-pintadinha-ouvindo-musica.jpg', '2022-05-16', 10, 'Sim'),
(6, 'Pedrinho Matador', '666.666.666-66', 'pedrinhomatador@hotmail.com', '(66) 6666-6666', 'Portões do Inferno, 666', NULL, 'Diadema', 'SP', 'Brasil', '16-05-2022-23-41-52-pintinho-amarelinho.jpg', '2022-05-16', 3, 'Sim'),
(7, 'Juca Tobias', NULL, 'Jocelyn@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-17', 0, NULL),
(8, 'Roberto Lucas', NULL, 'robertinho.com@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-17', 0, NULL),
(9, 'Juca Tobias Novo', NULL, 'Jocelyn2@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-17', 0, NULL),
(10, 'Juca Tobias Armanda Nero', NULL, 'Jocelyn23@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-17', 0, NULL),
(11, 'Rubens Barrichello do Brasil', '123.456.789-00', 'barrichello_rubens@hotmail.com', '(12) 2121-2121', 'Rua X, Número Y', 'Vila Z', 'Porto Alegre', 'RS', 'Brasil', '27-06-2022-23-31-36-buzanga.jpg', '2022-06-17', 0, 'Sim'),
(12, 'Aluno Louco', NULL, 'louco@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-21', 0, 'Sim'),
(13, 'Paula', NULL, 'paulinha@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, 'img/sem-perfil.jpg', '2022-06-30', 0, 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aulas`
--

CREATE TABLE `aulas` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `link` varchar(150) DEFAULT NULL,
  `id_curso` int(11) NOT NULL,
  `sessao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aulas`
--

INSERT INTO `aulas` (`id`, `numero`, `nome`, `link`, `id_curso`, `sessao`) VALUES
(26, 1, 'Aula 01 Módulo 01', 'https://www.youtube.com/embed/lMMyvL0KR5s', 1, 6),
(27, 1, 'Aula 01 Módulo 02', '', 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `banner_index`
--

CREATE TABLE `banner_index` (
  `id` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `link` varchar(60) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` varchar(160) NOT NULL,
  `ativo` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `banner_index`
--

INSERT INTO `banner_index` (`id`, `foto`, `link`, `titulo`, `descricao`, `ativo`) VALUES
(1, '30-05-2022-22-53-49-IMG-20180713-WA0005.jpg', 'http://test32.com', 'Lorem ipsum dolor sit amet consectetur.', ' Quas saepe reiciendis temporibus voluptate inventore debitis placeat cumque esse ullam officiis deleniti culpa excepturi ratione distinctio, sed consectetur?', 'Sim'),
(2, '30-05-2022-22-57-49-20180922_175305.jpg', 'http://cuzero.com', 'Pela Saco', 'João Gordo', 'Sim'),
(4, '30-05-2022-23-25-23-20180922_175106.jpg', 'http://roma.com', 'Dê à César O que é de César', 'Roma Vive seu Lacraio!', 'Sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banner_login`
--

CREATE TABLE `banner_login` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `ativo` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `banner_login`
--

INSERT INTO `banner_login` (`id`, `nome`, `link`, `foto`, `ativo`) VALUES
(2, 'Sistema Imobiliário', 'http://hugocursos.com.br', '27-05-2022-16-39-20-banner-login.jpg', 'Sim'),
(3, 'Sistema Teste 256', 'http://google256.com', '30-05-2022-15-01-54-20180922_101803.jpg', 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nome_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`, `foto`, `nome_url`) VALUES
(3, 'Doces gostosos', 'doces um pouco gostosos feito pela tia mafalda', '18-05-2022-14-07-09-doces-coloridos.jpg', 'doces-gostosos'),
(4, 'Doces saborosos', 'Doces muito saborosos feito pelo tio joaquim', '18-05-2022-14-37-20-doces-gostosos.jpg', 'doces-saborosos'),
(5, 'dsds', 'dsdsds', 'sem-foto.png', 'dsds'),
(6, 'dadadada', 'dadadada', 'sem-foto.png', 'dadadada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nome_sistema` varchar(50) NOT NULL,
  `email_sistema` varchar(50) NOT NULL,
  `tel_sistema` varchar(20) NOT NULL,
  `cnpj_sistema` varchar(25) DEFAULT NULL,
  `tipo_chave_pix` varchar(25) DEFAULT NULL,
  `chave_pix` varchar(100) DEFAULT NULL,
  `logo` varchar(20) NOT NULL,
  `icone` varchar(20) NOT NULL,
  `logo_rel` varchar(20) NOT NULL,
  `qrcode_pix` varchar(20) DEFAULT NULL,
  `facebook` varchar(120) DEFAULT NULL,
  `instagram` varchar(120) DEFAULT NULL,
  `youtube` varchar(120) DEFAULT NULL,
  `itens_pag` int(11) NOT NULL,
  `video_sobre` varchar(100) NOT NULL,
  `itens_relacionados` int(11) NOT NULL,
  `aulas_liberadas` int(11) NOT NULL,
  `desconto_pix` int(11) NOT NULL,
  `email_adm_mat` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nome_sistema`, `email_sistema`, `tel_sistema`, `cnpj_sistema`, `tipo_chave_pix`, `chave_pix`, `logo`, `icone`, `logo_rel`, `qrcode_pix`, `facebook`, `instagram`, `youtube`, `itens_pag`, `video_sobre`, `itens_relacionados`, `aulas_liberadas`, `desconto_pix`, `email_adm_mat`) VALUES
(2, 'Portal EAD do Danielzinho', 'danielantunespaiva@gmail.com', '(15) 9918-0589', '', 'CNPJ', 'danielantunespaiva@gmail.com', 'logo.png', 'favicon.ico', 'logo_rel.jpg', 'qrcode.jpg', 'http://facebook.com/portalead2', 'http://instagram.com/portalead', 'http://youtube.com/portalead', 6, 'https://www.youtube.com/embed/GeH5_-4xkfE', 1, 2, 5, 'Não');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `desc_rapida` varchar(60) NOT NULL,
  `desc_longa` text NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `professor` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `carga` int(11) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  `arquivo` varchar(150) NOT NULL,
  `ano` int(11) NOT NULL,
  `palavras` varchar(255) NOT NULL,
  `grupo` int(11) NOT NULL,
  `nome_url` varchar(150) NOT NULL,
  `pacote` varchar(100) NOT NULL,
  `sistema` varchar(5) NOT NULL,
  `link` varchar(150) NOT NULL,
  `tecnologias` varchar(150) NOT NULL,
  `promocao` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `desc_rapida`, `desc_longa`, `valor`, `professor`, `categoria`, `imagem`, `status`, `carga`, `mensagem`, `arquivo`, `ano`, `palavras`, `grupo`, `nome_url`, `pacote`, `sistema`, `link`, `tecnologias`, `promocao`) VALUES
(1, 'Curso de HTML', 'Aprenda HTML', 'HTML e CSS para você', '100.00', 1, 3, '30-06-2022-21-06-03-mendigo-fudido.jpg', 'Aprovado', 120, '', 'https://www.youtube.com/embed/lMMyvL0KR5s', 2022, 'html, css', 4, 'curso-de-html', 'https://www.youtube.com/embed/lMMyvL0KR5s', 'Não', 'https://www.youtube.com/embed/lMMyvL0KR5s', 'html, css', '70.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos_pacotes`
--

CREATE TABLE `cursos_pacotes` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_pacote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cursos_pacotes`
--

INSERT INTO `cursos_pacotes` (`id`, `id_curso`, `id_pacote`) VALUES
(1, 1, 9),
(2, 5, 9),
(3, 6, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `nome`) VALUES
(1, 'Grupo dos doces muito gostosos'),
(3, 'Grupo dos doces gostosíssimos'),
(4, 'Grupo dos doces coloridos'),
(5, 'Grupo dos doces gosmentos'),
(6, 'Grupo dos doces achoolatados');

-- --------------------------------------------------------

--
-- Estrutura da tabela `linguagens`
--

CREATE TABLE `linguagens` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `nome_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `linguagens`
--

INSERT INTO `linguagens` (`id`, `nome`, `descricao`, `foto`, `nome_url`) VALUES
(1, 'PHP8.1', '', '01-06-2022-16-37-00-11.jpg', 'php8.1'),
(5, 'dadada', 'fafffs', '01-06-2022-16-34-04-01.jpeg', 'dadada'),
(6, '23', 'asfsfs', 'sem-foto.png', '23'),
(7, '12', '552', 'sem-foto.png', '12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `matriculas`
--

CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_professor` int(11) NOT NULL,
  `aulas_concluidas` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `pacote` varchar(5) DEFAULT NULL,
  `alertado` varchar(5) DEFAULT NULL,
  `valor_cupom` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `forma_pgto` varchar(25) DEFAULT NULL,
  `boleto` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `matriculas`
--

INSERT INTO `matriculas` (`id`, `id_curso`, `id_aluno`, `id_professor`, `aulas_concluidas`, `valor`, `data`, `status`, `pacote`, `alertado`, `valor_cupom`, `subtotal`, `forma_pgto`, `boleto`) VALUES
(74, 1, 5, 1, 0, '450.00', '2022-06-30', 'Aguardando', 'Sim', NULL, '0.00', '450.00', NULL, NULL),
(76, 1, 5, 1, 0, '70.00', '2022-06-30', 'Matriculado', 'Não', NULL, '0.00', '70.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacotes`
--

CREATE TABLE `pacotes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `desc_rapida` varchar(60) NOT NULL,
  `desc_longa` text NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `professor` int(11) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `grupo` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `palavras` varchar(255) NOT NULL,
  `nome_url` varchar(150) NOT NULL,
  `video` varchar(150) NOT NULL,
  `linguagem` int(11) NOT NULL,
  `promocao` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pacotes`
--

INSERT INTO `pacotes` (`id`, `nome`, `desc_rapida`, `desc_longa`, `valor`, `professor`, `imagem`, `grupo`, `ano`, `palavras`, `nome_url`, `video`, `linguagem`, `promocao`) VALUES
(1, 'Formação Delphi', 'Aprenda Mais', 'blablablablabla', '500.00', 1, '30-06-2022-20-54-53-tattoo-isa.jpg', 4, 2022, 'delphi, embarcadero', 'formacao-delphi', 'http://www.google.com', 1, '450.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(600) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `cpf`, `telefone`, `email`, `foto`, `ativo`, `data`) VALUES
(3, 'Professor Girafalez', '535.335.353-53', '(31) 3131-3131', 'professorgirafalez@hotmail.com', '18-05-2022-13-00-00-professor-girafalez.jpg', 'Sim', '2022-05-18'),
(4, 'Professor Buzanga', '942.920.313-04', '(42) 4242-9922', 'buzangateacher@hotmail.com', '20-05-2022-13-56-39-buzanga.jpg', 'Sim', '2022-05-20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessao`
--

CREATE TABLE `sessao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sessao`
--

INSERT INTO `sessao` (`id`, `nome`, `id_curso`) VALUES
(6, 'Módulo 01', 1),
(7, 'Módulo 02', 1),
(8, 'Módulo 03', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `senha_crip` varchar(150) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `id_pessoa` int(11) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `usuario`, `senha`, `senha_crip`, `nivel`, `foto`, `id_pessoa`, `ativo`, `data`) VALUES
(1, 'Administrador', '000.000.000-00', 'danielantunespaiva@gmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Administrador', 'sem-perfil.jpg', 1, 'Sim', '2022-05-06'),
(13, 'Sassa Mutema', '212.121.212-21', 'sassamutema@gmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', '16-05-2022-19-33-37-galinha-pintadinha-ouvindo-musica.jpg', 5, 'Sim', '2022-05-16'),
(14, 'Pedrinho Matador', '666.666.666-66', 'pedrinhomatador@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', '16-05-2022-23-41-52-pintinho-amarelinho.jpg', 6, 'Sim', '2022-05-16'),
(18, 'Professor Girafalez', '535.335.353-53', 'professorgirafalez@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Professor', '18-05-2022-13-00-00-professor-girafalez.jpg', 3, 'Sim', '2022-05-18'),
(19, 'Professor Buzanga', '942.920.313-04', 'buzangateacher@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Professor', '20-05-2022-13-56-39-buzanga.jpg', 4, 'Sim', '2022-05-20'),
(20, 'Juca Tobias', NULL, 'Jocelyn@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 7, 'Sim', '2022-06-17'),
(21, 'Roberto Lucas', NULL, 'robertinho.com@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 8, 'Sim', '2022-06-17'),
(22, 'Juca Tobias Novo', NULL, 'Jocelyn2@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 9, 'Sim', '2022-06-17'),
(23, 'Juca Tobias Armanda Nero', NULL, 'Jocelyn23@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 10, 'Sim', '2022-06-17'),
(24, 'Rubens Barrichello do Brasil', '123.456.789-00', 'barrichello_rubens@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', '27-06-2022-23-31-36-buzanga.jpg', 11, 'Sim', '2022-06-17'),
(25, 'Aluno Louco', NULL, 'louco@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 12, 'Sim', '2022-06-21'),
(26, 'Paula', NULL, 'paulinha@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Aluno', 'sem-perfil.jpg', 13, 'Sim', '2022-06-30');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `banner_index`
--
ALTER TABLE `banner_index`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `banner_login`
--
ALTER TABLE `banner_login`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cursos_pacotes`
--
ALTER TABLE `cursos_pacotes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `linguagens`
--
ALTER TABLE `linguagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pacotes`
--
ALTER TABLE `pacotes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sessao`
--
ALTER TABLE `sessao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `banner_index`
--
ALTER TABLE `banner_index`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `banner_login`
--
ALTER TABLE `banner_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cursos_pacotes`
--
ALTER TABLE `cursos_pacotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `linguagens`
--
ALTER TABLE `linguagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `pacotes`
--
ALTER TABLE `pacotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `sessao`
--
ALTER TABLE `sessao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
