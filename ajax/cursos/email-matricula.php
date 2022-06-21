<?php

require_once('../../sistema/conexao.php');

$remetente = $email_sistema;
$assunto = 'Matrícula no Curso - ' .$nome_curso;

//urlsistema = 'http://localhost/dashboard/www/portal-ead/';
$url_cursos = $url_sistema.'cursos'; //não é uma pasta, porém, há uma rota cursos definida no htaccess
$url_painel_aluno = $url_sistema.'sistema/painel-aluno';

$mensagem = "

Olá $nome_aluno, obrigado por se matricular no curso $nome_curso!! 

<br><br> Assim que seu pagamento for aprovado o curso será liberado em seu painél do Aluno. </b> 

<br><br> Ir Para o Painel do Aluno -> <a href='$url_painel_aluno' target='_blank'> Clique Aqui </a>

<br><br> Ir Para os Cursos -> <a href='$url_cursos' target='_blank'> Clique Aqui </a>


<br><br><br> <i>Nosso Site - <a href='$url_sistema' target='_blank'>$url_sistema</a></i>
<br>
WhatsApp -> <a href='http://api.whatsapp.com/send?1=pt_BR&phone=55$tel_sistema' alt='$tel_sistema' target='_blank'><i class='fab fa-whatsapp'></i>$tel_sistema</a>

";

$dest = $usuario; //$usuario = $_POST['email']; definido em matricula.php

//para não dar problemas na formatação do texto do email, e reconhecer quebra de linha, negrito, etc, coloque o seguinte texto antes de From dest
$cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$dest;

/*
alternativa a única linha acima
$cabecalhos = 'MIME-Version: 1.0' . "\r\n";
$cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
$cabecalhos .= "From: " .$dest;
*/

mail($remetente, $assunto, $mensagem, $cabecalhos);
