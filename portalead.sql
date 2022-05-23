-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Maio-2022 às 05:23
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

INSERT INTO `alunos` (`id`, `nome`, `cpf`, `email`, `telefone`, `endereco`, `cidade`, `estado`, `pais`, `foto`, `data`, `cartao`, `ativo`) VALUES
(5, 'Sassa Mutema', '212.121.212-21', 'sassamutema@gmail.com', '(21) 2112-2121', 'Sampaio Correio', 'Recife', 'PE', 'Costa Rica', '16-05-2022-19-33-37-galinha-pintadinha-ouvindo-musica.jpg', '2022-05-16', 10, 'Sim'),
(6, 'Pedrinho Matador', '666.666.666-66', 'pedrinhomatador@hotmail.com', '(66) 6666-6666', 'Portões do Inferno, 666', 'Diadema', 'SP', 'Brasil', '16-05-2022-23-41-52-pintinho-amarelinho.jpg', '2022-05-16', 3, 'Sim');

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`, `foto`) VALUES
(3, 'Doces gostosos', 'doces um pouco gostosos feito pela tia mafalda', '18-05-2022-14-07-09-doces-coloridos.jpg'),
(4, 'Doces saborosos', 'Doces muito saborosos feito pelo tio joaquim', '18-05-2022-14-37-20-doces-gostosos.jpg');

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
  `qrcode_pix` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nome_sistema`, `email_sistema`, `tel_sistema`, `cnpj_sistema`, `tipo_chave_pix`, `chave_pix`, `logo`, `icone`, `logo_rel`, `qrcode_pix`) VALUES
(2, 'Portal EAD', 'danielantunespaiva@gmail.com', '(15) 99180-5895', NULL, NULL, NULL, 'logo.png', 'favicon.ico', 'logo.jpg', NULL);

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
  `tecnologias` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `desc_rapida`, `desc_longa`, `valor`, `professor`, `categoria`, `imagem`, `status`, `carga`, `mensagem`, `arquivo`, `ano`, `palavras`, `grupo`, `nome_url`, `pacote`, `sistema`, `link`, `tecnologias`) VALUES
(1, 'Curso de HTML', 'Aprendendo WEB', '<p style=\"font-family: \">O curso de Painel de Gestão para <b>portais de cursos EAD</b> possui 60 aulas, este é o segundo módulo do desenvolvimento do site / <b>sistema para gestão de cursos</b>, vamos aprender neste módulo como criar o crud para cadastros dos Professores, Alunos e Administradores do sistema, bem como toda gestão de exclusão de dados, listagem, buscas, inserção e edição, relacionamento entre tabelas e muito mais, tudo que você vai precisar para desenvolver todo e qualquer tipo de sistema, <font size=\"4\" color=\"#996633\">adquira já</font> nosso treinamento e comece a criar seus projetos de forma profissional.</p>', '59.99', 1, 4, '20-05-2022-15-33-52-mendigo-fudido.jpg', 'Aprovado', 20, 'Ornitorrinco fuma', 'google.com', 2022, 'curso de programação, curso de html', 5, 'curso-de-html', 'pacote-curso-html', 'Não', 'teste2.com', 'html, css, bootstrap'),
(2, 'Curso do Professor Girafalez', 'Aprenda Português com Girafalez', 'Cursinho de português', '129.90', 1, 4, '20-05-2022-15-32-27-curso-de-aplicativo-ecommerce-react-native.jpeg', 'Aguardando', 36, '', 'arquivolink.com', 2022, 'português, curso de português, gramática, sintaxe', 4, 'curso-do-professor-girafalez', 'portugues.com', 'Não', 'linkdocurso.com', 'língua portuguesa');

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
(19, 'Professor Buzanga', '942.920.313-04', 'buzangateacher@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', 'Professor', '20-05-2022-13-56-39-buzanga.jpg', 4, 'Sim', '2022-05-20');

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
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `professores`
--
ALTER TABLE `professores`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
