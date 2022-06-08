<?php

require_once('sistema/conexao.php');

$url = $_GET['url'];

$query = $pdo->query("SELECT * FROM cursos WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    $palavras_chaves = $res[0]['palavras'];
    $nome_curso_titulo = $res[0]['nome'];


    $id = $res[0]['id'];
    $desc_rapida = $res[0]['desc_rapida'];
    $desc_longa = $res[0]['desc_longa'];
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];
    $professor = $res[0]['professor'];
    $categoria = $res[0]['categoria'];
    $foto = $res[0]['imagem'];
    $status = $res[0]['status'];
    $carga = $res[0]['carga'];
    $mensagem = $res[0]['mensagem'];
    $arquivo = $res[0]['arquivo'];
    $ano = $res[0]['ano'];
    $grupo = $res[0]['grupo'];
    $nome_url = $res[0]['nome_url'];
    $pacote = $res[0]['pacote'];
    $sistema = $res[0]['sistema'];
    $link = $res[0]['link'];
    $tecnologias = $res[0]['tecnologias'];
}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h4><?php echo $nome_curso_titulo ?> - <small><?php echo $desc_rapida ?></small></h4>
        </div>
        <div class="col-md-4 col-sm-12">
            <h4><i class="fa fa-question-circle mr-1"></i> Dúvidas? Contate-nos!</h4>
        </div>
    </div>
</div>

<br>
<hr>


<?php

require_once('rodape.php');

?>