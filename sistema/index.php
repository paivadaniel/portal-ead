<?php
require_once('conexao.php');
//VERIFICA SE JÁ HÁ UM USUÁRIO ADMINISTRADOR CRIADO

$query = $pdo->query("SELECT * FROM usuarios WHERE nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
echo $total_reg;

if($total_reg == 0) {
//CRIAR UM USUÁRIO ADMINISTRADOR CASO NÃO EXISTA NENHUM USUÁRIO

$senha = '123';
$senha_crip = md5($senha);

$pdo->query("INSERT into usuarios SET nome = 'Administrador', cpf = '000.000.000-00', usuario = 'danielantunespaiva@gmail.com', senha = '$senha', senha_crip = '$senha_crip', nivel = 'Administrador', foto = 'sem-perfil.jpg', id_pessoa = 1, ativo = 'Sim', data = curDate()");
//não precisa passar o id por ele ser auto increment, ou seja, quando passar o primeiro registro, ele salva id=1
//no id_pessoa, como é número, pode passar como '1' ou 1, nenhuma das formas dá problema
//curDate() é uma função do mysql, não do php

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal EAD</title>
</head>
<body>

<form action="autenticar.php" method="POST" name="form-login" id="form-login"> <!-- se não tiver method preenchindo, por padrão vai por GET -->


<label for="usuario" class="">Usuário: </label>
<input type="text" name="usuario" id="usuario" placeholder="Digite seu nome ou CPF">

<br>

<label for="senha" class="">Senha: </label>
<input type="password" name="senha" id="senha" placeholder="Digite sua senha">

<br>

<button type="submit">Login</button>

</form>
    
</body>
</html>