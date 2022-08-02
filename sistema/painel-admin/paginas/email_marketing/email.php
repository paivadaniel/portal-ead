<?php
require_once("../../../conexao.php");

//esse arquivo serve para enviar 480 emails por vez, não fique enviando até acabar a lista (por exemplo se ela tiver 5000 emails), daí precisamos para um script de envio automático de email

$assunto = $_POST['assunto-email-marketing'];
$link = $_POST['link-email-marketing'];
$mensagem = $_POST['mensagem_email_mkt'];
$inicio = 0;
$final = $total_emails_por_envio; //total_emails_por_envio é variável global, definida e recuperada do banco dados (se alterada) em conexao.php

if ($assunto == "") {
    echo 'Preencha o Campo Assunto!';
    exit();
}

if ($mensagem == "") {
    echo 'Preencha o Campo Mensagem!';
    exit();
}

//SALVAR NA TABELA ENVIO EMAILS (data e hora de envio dos emails)
$agora = date('Y-m-d H:i:s');

//nova_hora é a hora de agora somada de mais 70 minutos, para o próximo disparo de emails, a soma é em minutos (por isso o minute), essa hora será gravada para que o próximo disparo de emails seja nessa hora
$nova_hora = date('Y-m-d H:i:s', strtotime('+' . $intervalo_envio_email . ' minute', strtotime($agora)));
$query = $pdo->query("UPDATE envios SET data = '$nova_hora', final = '$final', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");
//id=1 pois só tem que armazenar enquanto estiver rodando a lista, depois limpa a tabela

$query = $pdo->query("SELECT * FROM emails where enviar = 'Sim' order by id asc limit $final");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$url_s = $url_sistema;
$url_nova = $url_sistema . $link; //url do sistema concatenada com o link que é para o leitor do email clicar
$url_cursos = $url_sistema . 'cursos';
$url_painel_aluno = $url_sistema . 'sistema/painel-aluno';
$url_logo = $url_sistema . 'sistema/img/logo-email.png';

for ($i = 0; $i < count($res); $i++) {
    foreach ($res[$i] as $key => $value) {
    }
    //recuperados da tabela emails
    $to = $res[$i]['email'];
    $nome_aluno = $res[$i]['nome'];

    //passado por post de email_marketing.php
    $subject = "$assunto";

    $url_descadastrar = $url_sistema . 'descadastrar.php';

    //echo $to . '<br>'; //mostra cada endereço de email que a mensagem foi enviada

    $message = "


				Olá <b>$nome_aluno</b>, <br><br>
				$mensagem

				<br><br> <i> <a title='$url_nova' href='$url_nova' target='_blank'>Clique aqui </a> para ver o treinamento em nosso site !!</i> <br><br>

				<a title='$url_nova' href='$url_nova' target='_blank'>$url_nova</a>
				
				<br><br><br>
				   <a href='$url_sistema' target='_blank'><img src='$url_logo' width='300px'></a><br>

                       <i>Nosso Site - <a href='$url_sistema' target='_blank'>$url_sistema</a></i>
                      <br>
                      WhatsApp -> <a href='http://api.whatsapp.com/send?1=pt_BR&phone=55$tel_sistema' alt='$tel_sistema' target='_blank'><i class='fab fa-whatsapp'></i>$tel_sistema</a>
                    
				<br><br><br>
       <i> Caso não queira mais receber nossos emails <a href='$url_descadastrar' target='_blank'> clique aqui </a> para se descadastrar!</i> <br><br>

				";


    $remetente = $email_sistema;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

    if ($to != $remetente) {
        $headers .= "From: " . $remetente;
    }

    @mail($to, $subject, $message, $headers);
}

//ENVIAR EMAIL PARA O ADMIM INFORMANDO SOBRE O ULTIMO ENVIO DE EMAIL
$destinatario = $email_sistema;
$assunto = $nome_sistema . ' - Campanha Email';
$mensagem = 'Email enviado até o email de número ' . $final;
$cabecalhos = "From: " . $email_sistema;
@mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Enviado com Sucesso';

?>