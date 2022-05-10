<?php

@session_start();

echo 'Seja bem vindo ' . $_SESSION['nome']. ', você é nosso ' . $_SESSION['nivel'];

?>

<br>
<a href="../logout.php" title="Logout" style="text-decoration:none">Sair</a>
