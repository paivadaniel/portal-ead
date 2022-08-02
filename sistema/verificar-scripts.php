<?php

//só executa o código abaixo se $script_dia != date('Y-m-d'), ou seja, se o script_dia não foi usado hoje, essa condição (if) foi definida em conexao.php

//verificações para enviar email após x dias (definido em dias_email_matricula) lembrando de concluir a matrícula 
$hoje = date('Y-m-d');
$data_anterior = date('Y/m/d', strtotime("-$dias_email_matricula day", strtotime($hoje)));

//recupera matrículas que estão com mais de 3 dias aguardando serem concluídas
$query = $pdo->query("SELECT * FROM matriculas WHERE data <= '$data_anterior' and status = 'Aguardando' and alertado is null");
//se o aluno já foi alertado de concluir a matrícula, alertado irá mudar para 1, e ele não será mais alertado
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if ($total_reg > 0) {
    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }
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
        if ($pacote != 'Sim') {
            $tabela = 'cursos';
            $url_amigavel = 'curso-de-';
        } else {
            $tabela = 'pacotes';
            $url_amigavel = 'cursos-do-';
        }

        //pega nome e url do curso, já que url de pagamento de pacote é diferente da de curso
        $query2 = $pdo->query("SELECT * FROM $tabela where id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_curso = $res2[0]['nome'];
        $url_curso = $res2[0]['nome_url'];
        $url_pagamento = $url_sistema . $url_amigavel . $url_curso;

        $url_login = $url_sistema . 'sistema';
        $url_cursos = $url_sistema.'cursos';
        $url_painel_aluno = $url_sistema.'sistema/painel-aluno';
        $url_logo = $url_sistema.'sistema/img/logo-email.png';
    
        //ATUALIZAR O CAMPO DE ALERTADO COMO SIM PARA O EMAIL NÃO SER ENVIADO NOVAMENTE
        $pdo->query("UPDATE matriculas SET alertado = 'Sim' WHERE id = '$id_mat'");

        //ENVIAR O EMAIL PARA O ALUNO
        $to = $aluno_email;
        $subject = "Lembrete de Matrícula no Curso $nome_curso";
        $message = "

		Olá <b>$nome_aluno</b>, <br>
		Verificamos que iniciou sua matrícula em um de nossos cursos, porém o pagamento ainda não foi confirmado, acesse nosso site <a title='$url_login' href='$url_login' target='_blank'>$url_login</a> e faça seu login para efetuar o pagamento direto em seu painel, o curso será liberado imediatamente, qualquer dúvida entre em contato conosco!

		<br><br>
		  <a href='$url_sistema' target='_blank'><img src='$url_logo' width='300px'></a><br>

                       <i>Nosso Site - <a href='$url_sistema' target='_blank'>$url_sistema</a></i>
                      <br>
                      WhatsApp -> <a href='http://api.whatsapp.com/send?1=pt_BR&phone=55$tel_sistema' alt='$tel_sistema' target='_blank'><i class='fab fa-whatsapp'></i>$tel_sistema</a>



		";


        $dest = $email_sistema;
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";

        if ($to != $dest) {
            $headers .= "From: " . $dest;
        }

        @mail($to, $subject, $message, $headers);
    }
}

//EXCLUIR A MATRÍCULA QUE ESTÁ AGUARDANDO APÓS X DIAS (tabela config, campo dias_excluir_matricula, pode ser alterado em sistema/painel-admin/index.php, na modalConfig)

//repare  que data anterior recebe MENOS dias_excluir_matricula, pois tem que retroceder no calendário, portanto, fazer uma subtração
//variável hoje foi definida no começo do arquivo
$data_anterior = date('Y/m/d', strtotime("-$dias_excluir_matricula day",strtotime($hoje))); 

$query = $pdo->query("SELECT * FROM matriculas WHERE data <= '$data_anterior' and status = 'Aguardando'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if ($total_reg > 0) {
    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }
        $id_mat = $res[$i]['id'];

        $pdo->query("DELETE FROM matriculas WHERE id = '$id_mat'");

    }
}

//ATUALIZAR NA TABELA CONFIG O CAMPO script_dia PARA O DIA ATUAL
//esse campo mostra em qual data o script para excluir matrículas com mais de 30 dias foi usado pela última vez
$pdo->query("UPDATE config set script_dia = curDate()");