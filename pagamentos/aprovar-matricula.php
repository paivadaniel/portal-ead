<?php

//muito importante deixar claro que não tem como fazer teste de pagamento aprovado no Mercado Pago em localhost, tem que hospedadar os arquivos para testar

require("../../sistema/conexao.php");

//antes de atualizar o banco de dados mudando de Aguardando para Matriculado, temos que recuperar form_pgto e total_recebido (que tira as taxas da forma de pagamento)

if ($forma_pgto == 'MP') { //apenas se o pagamento foi por MP
    @session_start();
    $id_aluno = $_SESSION['id_pessoa'];

    //a explicação de que porquê usou id_matricula como id_curso foi dada no início da aula42 mod12, então teve que recuperar o verdadeiro id_matricula, mais explicações em PagamentoMP.php na linha do id_matricula 
    $query = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_matricula' and id_aluno = '$id_aluno'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $subtotal = $res[0]['subtotal'];
    $id_matricula = $res[0]['id']; //o verdadeiro id_matricula, o do SELECT acima é a variável id do curso
    $total_recebido = $subtotal - ($subtotal * ($taxa_mp / 100));
}

$query = $pdo->query("SELECT * FROM matriculas where id = '$id_matricula'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res) > 0) {
    $subtotal = $res[0]['subtotal'];
    $pacote = $res[0]['pacote'];
    $id_aluno = $res[0]['id_aluno'];
    $id_curso = $res[0]['id_curso'];
    $status =  $res[0]['status'];
    $id_professor_mat = $res[0]['id_professor']; //para buscar o nome do professor para colocar no email

    if ($status != 'Aguardando') { //diferente de aguardando, significa que é matriculado ou finalizado, portanto, para não duplicar a matrícula, sai
        //echo 'Aluno já está matriculado nesse curso.';
        exit();
    }

    if($pacote == 'Sim'){
		$tab = 'pacotes';
	}else{
		$tab = 'cursos';
	}

    $query2 = $pdo->query("SELECT * FROM alunos where id = '$id_aluno'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_aluno = $res2[0]['nome'];
    $email_aluno = $res2[0]['email'];
    $cartoes_aluno = $res2[0]['cartao'];

    //buscar o nome do professor
    //não busquei na tabela professores porque os administradores não estão cadastrados lá, e podem ser professores também
    $query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_professor_mat' and (nivel = 'Professor' or nivel = 'Administrador')");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $email_professor = $res2[0]['usuario']; //para ser usado no envio do email de notificação de novo aluno matriculado, que é enviado ao final dessa página
    

}

if ($forma_pgto == 'Paypal') {
    $total_recebido = $subtotal - ($subtotal * ($taxa_paypal / 100));
}

//atualizando a matrícula
$pdo->query("UPDATE matriculas SET status = 'Matriculado', forma_pgto = '$forma_pgto', total_recebido = '$total_recebido' WHERE id = '$id_matricula'");

//adicionar mais um cartão fidelidade para o aluno
$cartoes_aluno += 1;

$pdo->query("UPDATE alunos SET cartao = '$cartoes_aluno' WHERE id = '$id_aluno'");

//liberar todos os cursos caso seja um pacote
if ($pacote == 'Sim') {
    $query = $pdo->query("SELECT * FROM cursos_pacotes where id_pacote = '$id_curso' order by id desc"); //o order by desc é para se o pacote tiver 3 cursos, que as matrículas se iniciem do último para o primeiro curso
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) { //só não entra aqui se o pacote matriculado não tiver cursos

        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {
            }

            $id = $res[$i]['id'];
            $id_do_curso = $res[$i]['id_curso']; //id_curso no SELECT acima foi usado para o pacote, então, para não perder a referência, chamei esse de id_do_curso, o mais correto seria o id_curso do SELECT se chamar id_pacote
            //id_do_curso = curso
            //id_curso = pacote

            //deve-se inserir a matrícula do curso apenas caso ela não exista, pois às vezes o aluno iniciou a matricula de um curso, que está com status=Aguardando, e depois preferiu comprar um pacote ao qual tem esse curso, portanto, a primeira matrícula dele para esse curso ficará como Aguardando, e a segunda, se ele pagar, será a aprovada

            //pega o número de matrículas e incrementa
            $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_do_curso'"); //id_do_curso, não id_curso, este último é para pacote, e vamos liberar os cursos
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            $matriculas = $res2[$i]['matriculas']; //quantidade de vendas do curso
            $id_professor = $res2[$i]['id_professor'];
            $quant_mat = $matriculas+1; //soma 1 venda ao curso

            //pega id da matrícula
            $query3 = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_do_curso' and id_aluno = '$id_aluno'");  //id_do_curso, não id_curso, este último é para pacote, e vamos liberar os cursos
            $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
            $id_mat = $res3[0]['id']; //id da matrícula que já existe

            if (@count($res3) > 0) { //excluir a matrícula do curso se ela já existir, independente do status, tanto como Aguardando como Matriculado
                $pdo->query("DELETE FROM matriculas where id = 'id_mat'");
            }

            //insere a matrícula de cada curso do pacote, independente se ela já existia ou não
            $pdo->query("INSERT INTO matriculas SET id_curso = '$id_do_curso', id_aluno = '$id_aluno', id_professor = '$id_professor', aulas_concluidas = 1, data = curDate(), status = 'Matriculado', pacote = 'Não', id_pacote = '$id_curso', obs = 'Pacote'"); //valor é 0 do curso, pois pagou pelo pacote
            //se o valor é 0, pois não foi decladado acima, é porque os cursos foram liberados após a compra de um pacote, então para maior organização no campo de observações marcamos Pacote, esse campo obs recebe Cartão Fidelidade, quando a matrícula de um curso é liberada após o uso dos cartões fidelidade, portanto, esse campo serve para clarificar como as matrículas foram feitas

            //atualizar número de matrículas do curso na tabela cursos
            $pdo->query("UPDATE cursos SET matriculas = '$quant_mat' WHERE id = '$id_do_curso");

        }
    }
}

//adicionar mais uma venda para o curso ou pacote
$query2 = $pdo->query("SELECT * FROM $tab where id = '$id_curso'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$matriculas = $res2[0]['matriculas'];
$quantid_mat = $matriculas + 1;
$nome_curso = $res2[0]['nome']; //para o envio do email
$pdo->query("UPDATE $tab SET matriculas = '$quantid_mat' where id = '$id_curso'");

//enviar email para o admin, professor e aluno
require_once('email-aprovar-matricula.php');
