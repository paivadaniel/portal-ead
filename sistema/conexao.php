<?php

require_once('config.php');

date_default_timezone_set('America/Sao_Paulo');

try {
    //fora a PDO, existem outros tipos de conexões com o banco de dados, como mysqli
    $pdo = new PDO("mysql:dbname=$banco; host=$servidor", "$usuario", "$senha");
} catch (Throwable $th) { //Exception $e não funciona para mim
    echo 'Erro ao conectar ao banco de dados! <br><br>' . $th;
}

?>
