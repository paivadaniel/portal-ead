<?php

require_once("../../../conexao.php");

@session_start();
$aluno_logado = $_SESSION['id_pessoa'];

$id_pergunta = $_POST['id_pergunta_resposta'];

$query = $pdo->query("SELECT * FROM respostas where id_pergunta = '$id_pergunta' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

$id_resposta = $res[$i]['id']; //id da pergunta
$resposta = $res[$i]['resposta'];
$id_curso = $res[$i]['id_curso'];
$data = $res[$i]['data'];
$dataF = implode('/', array_reverse(explode('-', $data)));
$id_aluno = $res[$i]['id_pessoa'];
$funcao = $res[$i]['funcao'];

//se o aluno que estiver logado for o que respondeu, ele poderá exclui-la, caso contrário, não
if($id_aluno == $aluno_logado) {
    $mostrar_excluir = '';
} else {
    $mostrar_excluir = 'ocultar';
}

$query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_aluno'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_de_quem_respondeu = $res2[0]['nome'];
$foto_de_quem_respondeu = $res2[0]['foto'];

echo <<<HTML
    <div class="mt-3">
        <!-- listar-perguntas.php é chamado em cursos.php, este por sua vez está dentro de painel-aluno/index.php -->
    <span> <img style="border-radius: 100%;" class="rounded-circle z-depth-0" src="img/perfil/{$foto_de_quem_respondeu}" width="25" height="25">  
    <span class="text-muted"><b>{$nome_de_quem_respondeu}</b> </span>
    <span class="text-muted" style="margin-left:10px">{$dataF}</span> 
    
        <li class="dropdown head-dpdn2" style="display: inline-block;">
            <a class="{$mostrar_excluir}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Resposta"><big><i class="fa fa-trash-o text-danger "></i></big></a>
    
            <ul class="dropdown-menu" style="margin-left:-230px;">
            <li>
            <div class="notification_desc2">
            <p>Confirmar Exclusão? <a href="#" onclick="excluirResposta('{$id_resposta}')"><span class="text-danger">Sim</span></a></p>
            </div>
            </li>										
            </ul>
            </li>
    
    <br>
    <span class="text-muted"><small><i>{$resposta}</i></small></span>
    </div>
    <hr>
HTML;
    }
}
