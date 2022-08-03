<?php
require_once('../../sistema/conexao.php');

$email = $_POST['email'];

if($email == ""){
    echo 'Preencha o Campo Email!';
    exit();
}

$query = $pdo->query("SELECT * FROM emails where email = '$email'"); 
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) > 0){
    
    $pdo->query("UPDATE emails SET enviar = 'Não' where email = '$email'"); 
    echo 'Descadastrado da Lista com Sucesso!';
}else{
   echo 'Este email não está cadastrado!';

}

?>