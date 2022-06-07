<?php

require_once('sistema/conexao.php');

$url = $_GET['url'];

$query = $pdo->query("SELECT * FROM cursos WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    $palavras_chaves = $res[0]['palavras'];
    $nome_curso_titulo = $res[0]['nome'];

}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>
fdfdfd

<br>
<hr>


<?php

require_once('rodape.php');

?>