<?php

require_once("../../../conexao.php");

@session_start();
$id_usuario = $_SESSION['id_pessoa'];

//SELECT DISTINCT serve para selecionar apenas registro distintos, e em group by definimos qual parâmetro ele deve considerar para ser distinguido
$query = $pdo->query("SELECT DISTINCT * FROM perguntas where respondida = 'Não' group by id_curso"); //se for edição
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) > 0) {

for ($i = 0; $i < @count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $id_curso = $res[$i]['id_curso'];

    $query2 = $pdo->query("SELECT * FROM cursos where id = '$id_curso' and professor = '$id_usuario'"); //se for edição
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_curso = $res2[0]['nome'];
    $nome_cursoF = mb_strimwidth($nome_curso, 0, 20, "...");
    $foto_curso = $res2[0]['imagem'];


echo <<<HTML

    <a href="#" onclick="abrirModalPerguntas('{$id_curso}', '{$nome_curso}')" >
        <div class="col-md-2 col-sm-6 col-xs-6" style="margin-bottom:15px">

            <img src="img/cursos/{$foto_curso}" alt="" width="100%">
            <p align="center"><small>{$nome_cursoF}</small></p>

        </div>
    </a>

HTML;

}

} else {
    echo 'Não existem perguntas a serem respondidas!';
}

?>
