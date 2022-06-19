<?php

require_once('../../sistema/conexao.php');

@session_start();

$usuario = $_POST['email'];
$id_curso_matricula = $_POST['id_curso'];
$pacote = $_POST['pacote'];

if($pacote == 'Sim') {
    $tabela = 'pacotes';
} else {
    $tabela = 'cursos';
}

$id_professor = $_SESSION['id']; //variável de sessão definida em autenticar.php

//verifica se email do aluno existe
$query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario and nivel = 'Aluno'");
$query->bindValue(":usuario", $usuario);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if ($total_reg == 0) {
    echo 'Usuário não cadastrado!';
    exit();
} else {
    $id_aluno = $res[0]['id_pessoa'];
}

//verifica se aluno já está matriculado nesse curso
$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_aluno' and id_curso = '$id_curso_matricula' and pacote = '$pacote'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if ($total_reg > 0) {
    echo 'Aluno já matriculado nesse curso';
    exit();
} else {

    //pega dados do curso/pacote em que o aluno se matriculou
    $query = $pdo->query("SELECT * FROM $tabela WHERE id = '$id_curso_matricula'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];
    $nome_curso = $res[0]['promocao'];

    if($promocao > 0) {
        $valor = $promocao;
    } 
    
    //insere matrícula do aluno na tabela matriculas
    $pdo->query("INSERT into matriculas SET id_curso = '$id_curso_matricula', id_aluno = '$id_aluno', id_professor = '$id_professor', valor = '$valor', data = curDate(), status = 'Aguardando', pacote = '$pacote'");

    echo 'Matriculado com Sucesso!';

    require_once('email-matricula.php');

}
