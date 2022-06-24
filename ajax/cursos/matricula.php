<?php

//essa minha página codei diferente do hugo, e criei a variável de sessão $_SESSION['id_pessoa'] em autenticar.php

require_once('../../sistema/conexao.php');

@session_start();

$usuario_logado = $_SESSION['nivel'];

//em curso.php, professor e administrador matriculam alunos pelo form-matricular, e alunos se matriculam com matriculaAluno 

if($usuario_logado == 'Administrador' || $usuario_logado == 'Professor') {
    $usuario_aluno = $_POST['email_matricula'];  

    //verificar se o aluno está cadastrado no banco de dados
    $query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario and nivel = 'Aluno'");
    $query->bindValue(":usuario", $usuario_aluno);
    $query->execute();
    
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = count($res);
    
    if ($total_reg == 0) {
        echo 'Aluno não cadastrado no banco de dados!';
        exit();
    } else {
        $id_aluno = $res[0]['id_pessoa'];
        $nome_aluno = $res[0]['nome']; //será usado em email-matricula.php (mais abaixo)
    }
    
} 

if ($usuario_logado == 'Aluno') {
    
    $id_aluno = $_SESSION['id_pessoa'];
    $nome_aluno = $_SESSION['nome']; //será usado em email-matricula.php (mais abaixo)

    //não é necessário verificar se o aluno está cadastrado no banco de dados, pois se usuario_logao='Aluno' então ele está

}

//em curso.php, id_curso e pacote='Não' são passados tanto pelo form-matricula (ou seja, se a matrícula do aluno for feita por um administrador ou professor), quanto pelo matriculaAluno(), em que a matrícula no curso é feita pela próprio aluno
$id_curso = $_POST['id_curso'];
$pacote = $_POST['pacote']; //recebe 'Não' de curso.php e 'Sim' de 'pacote.php'

if($pacote == 'Sim') {
    $tabela = 'pacotes';
} else {
    $tabela = 'cursos';
}

//verifica se aluno já está matriculado nesse curso
$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_aluno' and id_curso = '$id_curso' and pacote = '$pacote'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if ($total_reg > 0) {
    echo 'Aluno já matriculado nesse curso';
    exit();
} else {

    //pega dados do curso/pacote em que o aluno se matriculou
    $query = $pdo->query("SELECT * FROM $tabela WHERE id = '$id_curso'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];
    $nome_curso = $res[0]['nome']; //será usado em email-matricula.php (mais abaixo)
    $id_professor = $res[0]['professor']; //da forma como implementei, ainda que um professor matricule um aluno, o nome do professor a constar na matrícula será o professor desse curso, ou seja, isso não favorece comissionamento por venda

    if($promocao > 0) {
        $valor = $promocao;
    } 
    
    //insere matrícula do aluno na tabela matriculas
    $pdo->query("INSERT into matriculas SET id_curso = '$id_curso', id_aluno = '$id_aluno', id_professor = '$id_professor', valor = '$valor', data = curDate(), status = 'Aguardando', pacote = '$pacote', subtotal = '$valor'");

    echo 'Matriculado com Sucesso!';

    require_once('email-matricula.php');

}
