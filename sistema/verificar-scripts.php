<?php

//verificações para enviar email após x dias (definido em dias_email_matricula) lembrando de concluir a matrícula 
$hoje = date('Y-m-d');
$data_anterior = date('Y/m/d', strtotime("-$dias_email_matricula day",strtotime($hoje))); 

//recupera matrículas que estão com mais de 3 dias aguardando serem concluídas
$query = $pdo->query("SELECT * FROM matriculas WHERE data <= '$data_anterior' and status = 'Aguardando' and alertado is null");
//se o aluno já foi alertado de concluir a matrícula, alertado irá mudar para 1, e ele não será mais alertado
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
	$id_mat = $res[$i]['id'];
	$id_curso = $res[$i]['id_curso'];
	$id_aluno = $res[$i]['id_aluno'];
	$pacote = $res[$i]['pacote'];

    //pega nome e email do aluno
    $query2 = $pdo->query("SELECT * FROM usuarios WHERE id_pessoa = '$id_aluno'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_aluno = $res2[0]['nome'];
	$aluno_email = $res2[0]['usuario'];

    //verifica se é pacote ou curso
	if($pacote != 'Sim'){
		$tabela = 'cursos';	
		$url_amigavel = 'curso-de-';		
	}else{
		$tabela = 'pacotes';
		$url_amigavel = 'cursos-do-';
	}

    //pega nome e url do curso, já que url de pagamento de pacote é diferente da de curso
    $query2 = $pdo->query("SELECT * FROM $tabela where id = '$id_curso'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_curso = $res2[0]['nome'];
    $url_curso = $res2[0]['nome_url'];
    $url_pagamento = $url_sistema.$url_amigavel.$url_curso;

    /* vai ser vsto na próxima aula
    
    $url_cursos = $url_sistema.'cursos';
    $url_painel_aluno = $url_sistema.'sistema/painel-aluno';
    $url_logo = $url_sistema.'sistema/img/logo-email.png';
    */



    }
}
