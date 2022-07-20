<?php

//esse arquivo é chamado dentro de aprovar-matricula.php

require_once('../../sistema/conexao.php');

//email-matricula.php é aberto dentro de matricula.php

//envio de email para o aluno
$destinatario = $email_aluno; //$email_aluno = $res[0]['usuario'] definido em matricula.php;
$assunto = 'Sua Matrícula no Curso ' .$nome_curso . ' Foi Aprovada!';

//urlsistema = 'http://localhost/dashboard/www/portal-ead/';
$url_cursos = $url_sistema.'cursos'; //não é uma pasta, porém, há uma rota cursos definida no htaccess
$url_painel_aluno = $url_sistema.'sistema/painel-aluno';
$url_logo = $url_sistema.'sistema/img/logo-email.png';

$mensagem = "

Olá $nome_aluno, sua matrícula no curso $nome_curso foi aprovada e ele já está liberado em seu painel do aluno!! 

<br><br> Ir Para o Painel do Aluno -> <a href='$url_painel_aluno' target='_blank'> Clique Aqui </a>

<br><br> Ir Para os Cursos -> <a href='$url_cursos' target='_blank'> Clique Aqui </a>

<a href='$url_sistema' target='_blank'><img src='$url_logo' width='350px'></a> <br>

<br><br><br> <i>Nosso Site - <a href='$url_sistema' target='_blank'>$url_sistema</a></i>
<br>
WhatsApp -> <a href='http://api.whatsapp.com/send?1=pt_BR&phone=55$tel_sistema' alt='$tel_sistema' target='_blank'><i class='fab fa-whatsapp'></i>$tel_sistema</a>

";

$remetente = $email_sistema;

//para não dar problemas na formatação do texto do email, e reconhecer quebra de linha, negrito, etc, coloque o seguinte texto antes de From dest
$cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$destinatario;

/*
alternativa a única linha acima
$cabecalhos = 'MIME-Version: 1.0' . "\r\n";
$cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$cabecalhos .= "From: " .$dest;
*/

@mail($destinatario, $assunto, $mensagem, $cabecalhos);



//envio de email para o administrador

if($email_adm_mat == 'Sim') { //email_adm_mat é selecionada nas configurações no painel admin
$destinatario = $email_sistema; //$email_aluno = $res[0]['usuario'] definido em matricula.php;
$assunto = 'Matrícula Aprovada no Curso - ' .$nome_curso;

$mensagem = "Aluno $nome_aluno teve sua matrícula aprovada no curso $nome_curso!";

$remetente = $email_sistema;

//para não dar problemas na formatação do texto do email, e reconhecer quebra de linha, negrito, etc, coloque o seguinte texto antes de From dest
$cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$remetente;

/*
alternativa a única linha acima
$cabecalhos = 'MIME-Version: 1.0' . "\r\n";
$cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$cabecalhos .= "From: " .$remetente;
*/

@mail($destinatario, $assunto, $mensagem, $cabecalhos);

}

//envio de email para o professor

if($email_sistema != $email_professor) {
    $destinatario = $email_professor; //email_professor está em aprovar-matricula.php
    $assunto = 'Matrícula Aprovada no Curso - ' .$nome_curso;
    
    $mensagem = "Aluno $nome_aluno teve sua matrícula aprovada no curso $nome_curso!";
    
    $remetente = $email_sistema;
    
    $cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$remetente;
    
    @mail($destinatario, $assunto, $mensagem, $cabecalhos);
    
    }