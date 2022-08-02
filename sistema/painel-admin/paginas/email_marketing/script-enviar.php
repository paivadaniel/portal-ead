<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script Email</title>
</head>

<body>

</body>

</html>

<?php
require_once("../../../conexao.php");

//para atualizar a página de 1200 em 1200 segundos (20 minutos), na prática dá um f5 automático, para testar diminua de 1200 para 5 e acesse a url no navegador
echo "<meta HTTP-EQUIV='refresh' CONTENT='1200;URL=script-enviar.php'>";

$agora = date('Y-m-d H:i:s');
$email_adm = $email_sistema; //email_sistema é variável global definida em conexao.php

//PEGAR TOTAL DE EMAILS DO BANCO
$query = $pdo->query("SELECT * FROM emails where enviar = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_emails = @count($res);

$query = $pdo->query("SELECT * FROM envios where id = '1' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$data = $res[0]["data"];
$final = $res[0]["final"];
$mensagem = $res[0]["mensagem"];
$assunto = $res[0]["assunto"];
$link = $res[0]["link"];

if ($final == 0) { //no primeiro acesso final só pode ser 480, pois na página de login do sistema (sistema/index.php), o valor de 480 é definido para ele
    echo 'Não tem mais emails pendentes, todos já foram enviados!';
} else { //se o final for diferente de zero, é porque está no meio de uma campanha de envio de emails


    if ($agora >= $data) { //se a hora atual, já passou da hora definida no último envio de email, que acrescenta 70 minutos à hora de envio dos últimos emails, ou seja, já pode enviá-los novamente
        //VER SE JÁ PASSOU TODA A LISTA DE EMAILS

        if ($final >= $total_emails) { //se o final for maior ou igual ao total_emails, significa que chegou ao fim a lista de emails com campo enviar 'Sim"
            //muda final para 0
            $query = $pdo->query("UPDATE envios SET data = '$agora', final = '0', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");

            exit();
        }
        //se tem ainda mais emails na lista que não receberam o último disparo de emails, segue com o código para disparar mais emails para quem não recebeu

        $inicio = $final;
        $final_novo = $total_emails_por_envio + $final; //isso é soma de números, não é concatenação

        //APÓS ENVIAR O EMAIL É PRECISO SALVAR A HORA NA TABELA DE ENVIOS
        $nova_hora = date('Y-m-d H:i:s', strtotime('+' . $intervalo_envio_email . 'minute', strtotime($agora)));

        $query = $pdo->query("UPDATE envios SET data = '$nova_hora', final = '$final_novo', assunto = '$assunto', mensagem = '$mensagem', link = '$link' where id = 1");

        $url_s = $url_sistema;
        $url_nova = $url_sistema . $link;
        $url_cursos = $url_sistema . 'cursos';
        $url_painel_aluno = $url_sistema . 'sistema/painel-aluno';
        $url_logo = $url_sistema . 'sistema/img/logo-email.png';
        $url_descadastrar = $url_sistema . 'descadastrar.php';



        //DISPARAR EMAIL PARA OS CLIENTES DE HORA EM HORA
        $query_emails = $pdo->query("SELECT * from emails where enviar = 'Sim' and (id > '$inicio' and id <= '$final_novo')"); //na segunda vez vai de 481 até 960
        $res_emails = $query_emails->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($res_emails); $i++) {
            foreach ($res_emails[$i] as $key => $value) {
            }


            $nome_aluno_email = $res_emails[$i]['nome'];
            $aluno_email = $res_emails[$i]['email'];
            $id_email = $res_emails[$i]['id'];

            $to = $aluno_email;
            $subject = "$assunto";
            $message = "

            Olá <b>$nome_aluno_email</b>, <br><br>
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


            $dest = $email_sistema; //acho que aqui teria que ser remetente não dest (de destinatário)
            //as duas linhas a seguir que fazem com que seja reconhecido e funcione o html no email, caso contrário, irá aparecer <br> no email, ao invés de uma quebra de linha
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

            if ($to != $dest) {
                $headers .= "From: " . $dest; //teria que ser remetente
            }

            @mail($to, $subject, $message, $headers);
        }


        //ENVIAR EMAIL PARA O ADMIM INFORMANDO SOBRE O ULTIMO ENVIO DE EMAIL
        $destinatario = $email_sistema;
        $assunto = "Disparo Email Inicio $inicio e Final $final_novo ";

        //as duas linhas a seguir que fazem com que seja reconhecido e funcione o html no email, caso contrário, irá aparecer <br> no email, ao invés de uma quebra de lin
        $cabecalhos = 'MIME-Version: 1.0' . "\r\n";
        $cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

        $cabecalhos .= "From: " . $email_sistema;
        @mail($destinatario, $assunto, $mensagem, $cabecalhos);

    }
}

?>