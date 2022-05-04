<?php

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

echo 'usuario = ' . $usuario . ' e senha = '. $senha;

?>

<div id="usuario">dadada</div>

<script>

var usuario = <?php $usuario ?>;

document.getElementById('usuario').val(usuario);

</script>