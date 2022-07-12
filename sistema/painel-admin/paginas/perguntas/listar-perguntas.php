<?php

require_once("../../../conexao.php");

@session_start();
$aluno_logado = $_SESSION['id_pessoa'];

$id_curso = $_POST['id_curso'];

$query = $pdo->query("SELECT * FROM perguntas where id_curso = '$id_curso' order by id desc");
//order by id desc mostra da última à primeira pergunta
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

$id_pergunta = $res[$i]['id']; //id da pergunta
$pergunta = $res[$i]['pergunta'];
$num_aula = $res[$i]['num_aula'];
$data = $res[$i]['data'];
$dataF = implode('/', array_reverse(explode('-', $data)));
$id_aluno = $res[$i]['id_aluno'];

//se o aluno que estiver logado for o que fez a pergunta, ele poderá exclui-la, caso contrário, não
if($id_aluno == $aluno_logado) {
    $mostrar_excluir = '';
} else {
    $mostrar_excluir = 'ocultar';
}

$query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_aluno'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res2[0]['nome'];
$foto_aluno = $res2[0]['foto'];

$query3 = $pdo->query("SELECT * FROM respostas where id_pergunta = '$id_pergunta'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$respostas = @count($res3);

/*

é possível remover o campo respostas (que conta o número de respostas para cada pergunta) na tabela perguntas, e filtrar a tabela de respostas pelo id da pergunta, como feito abaixo

$query = $pdo->query("SELECT * FROM respostas where id_pergunta = '$id_pergunta'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$respostas = @count($res);

daí em listar-respostas.php, remove:

$query = $pdo->query("SELECT * FROM perguntas WHERE id = '$id_pergunta'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$respostas = $res[0]['respostas'] + 1;

e em cursos.php, remove de $("#form-respostas").submit(function()...:

listarPerguntas(id_curso); 

*/

echo <<<HTML
    <div class="mt-3">
        <!-- listar-perguntas.php é chamado em cursos.php, este por sua vez está dentro de painel-aluno/index.php -->
    <span> <img style="border-radius: 100%;" class="rounded-circle z-depth-0" src="../painel-aluno/img/perfil/{$foto_aluno}" width="25" height="25">  
    <span class="text-muted"><b>{$nome_aluno}</b> </span>
    <span class="text-muted" style="margin-left:10px">{$dataF}</span> 
    <span class="text-muted" style="margin-left:10px">{$respostas} Respostas</span> </span>
    
        <li class="dropdown head-dpdn2" style="display: inline-block;">
            <a class="{$mostrar_excluir}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Pergunta"><big><i class="fa fa-trash-o text-danger "></i></big></a>
    
            <ul class="dropdown-menu" style="margin-left:-230px;">
            <li>
            <div class="notification_desc2">
            <p>Confirmar Exclusão? <a href="#" onclick="excluirPergunta('{$id_pergunta}')"><span class="text-danger">Sim</span></a></p>
            </div>
            </li>										
            </ul>
            </li>
    
    <br>
    <span > <a class="link-aula" href="#" onclick="abreModalResposta('{$id_pergunta}', '{$pergunta}')" title="Abrir Pergunta">Aula {$num_aula} - {$pergunta}</a> </span></small>
    </div>
    <hr>
HTML;
    }
}
