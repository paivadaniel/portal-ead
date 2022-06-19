<?php

require_once('../../sistema/conexao.php');

$remetente = $email_sistema;
$assunto = 'Matrícula no Curso - ' .$nome_curso;

$mensagem = 

$dest = $usuario; //$usuario = $_POST['email']; definido em matricula.php
$cabecalhos = "From: " .$dest;

mail($remetente, $assunto, $mensagem, $cabecalhos);



?> 
