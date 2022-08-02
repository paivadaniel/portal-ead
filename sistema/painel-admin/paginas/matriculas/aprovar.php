<?php
require_once("../../../conexao.php");
//require_once("../../../../pagamentos/aprovar-matricula.php");

$tabela = 'matriculas';

$id_mat = $_POST['id_mat'];
$subtotal = $_POST['subtotal'];
$subtotal = str_replace(',', '.', $subtotal); 
$forma_pgto = $_POST['pago'];
$obs = $_POST['obs'];
$cartao = $_POST['cartao'];

if ($forma_pgto == 'MP') {
    $total_recebido = $subtotal - ($subtotal * ($taxa_mp / 100));
} else if ($forma_pgto == 'Paypal') {
    $total_recebido = $subtotal - ($subtotal * ($taxa_paypal / 100));
} else if ($forma_pgto == 'Boleto') {
    $total_recebido = $subtotal - $taxa_boleto; //taxa do boleto é fixa, por exemplo, R$3,45, e não é em porcentagem
} else if ($forma_pgto == 'Pix') { //não tem taxa de desconto no PIX
    $total_recebido = $subtotal;
}

$query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res) > 0) {
    $pacote = $res[0]['pacote'];
    $id_aluno = $res[0]['id_aluno'];
    $id_curso = $res[0]['id_curso'];
    $id_professor = $res[0]['id_professor']; //para buscar o nome do professor para colocar no email

    if($pacote == 'Sim'){
		$tab = 'pacotes';
	}else{
		$tab = 'cursos';
	}

    $query2 = $pdo->query("SELECT * FROM alunos where id = '$id_aluno'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_aluno = $res2[0]['nome']; //será usado para o email
    $email_aluno = $res2[0]['email']; //será usado para o email
    $cartoes_aluno = $res2[0]['cartao']; //será usada caso seja necessário incrementar o número de cartões fidelidade do aluno

    //buscar o nome do professor
    //não busquei na tabela professores porque os administradores não estão cadastrados lá, e podem ser professores também
    $query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_professor' and (nivel = 'Professor' or nivel = 'Administrador')");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $email_professor = $res2[0]['usuario']; //para ser usado no envio do email de notificação de novo aluno matriculado, que é enviado ao final dessa página
    

}



//atualizando a matrícula
$query = $pdo->prepare("UPDATE matriculas SET status = 'Matriculado', forma_pgto = '$forma_pgto', total_recebido = :total_recebido, data = curDate(), obs = :obs, subtotal = :subtotal  where id = '$id_mat'");  //total_recebido tem que passar por parâmetro, pois ele recebe o que está no subtotal e foi digitado pelo usuário
//data é atualizada, pois estamos trabalhando com a data de aprovação da matrícula, e não no dia em que foi feito o pedido dela, uma alternativa era criar data_inicio_matricula e data_aprovacao_matricula

$query->bindValue(":subtotal", "$subtotal");
$query->bindValue(":total_recebido", "$total_recebido");
$query->bindValue(":obs", "$obs");
$query->execute();

if($cartao == 'Sim') {////adicionar mais um cartão fidelidade para o aluno

$cartoes_aluno += 1;

$pdo->query("UPDATE alunos SET cartao = '$cartoes_aluno' WHERE id = '$id_aluno'");

}

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

            //deve-se inserir a matrícula do curso apenas caso ela não exista, pois às vezes o aluno iniciou a matricula de um curso, que está com status=Aguardando, e depois preferiu comprar um pacote ao qual tem esse curso, portanto, a primeira matrícula dele para esse curso ficará como Aguardando, e a segunda, se ele pagar, será a aprovada, e a primeira será excluída

            //pega o número de matrículas e incrementa
            $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_do_curso'"); //id_do_curso, não id_curso, este último é para pacote, e vamos liberar os cursos
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            $matriculas = $res2[$i]['matriculas']; //quantidade de vendas do curso
            $id_professor = $res2[$i]['professor'];
            $quant_mat = $matriculas+1; //soma 1 venda ao curso

            //pega id da matrícula por curso (não do pacote), caso já existir matrícula desse aluno para esse curso, e então ela será apagada
            $query3 = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_do_curso' and id_aluno = '$id_aluno'");  //id_do_curso, não id_curso, este último é para pacote, e vamos liberar os cursos
            $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);

            if (@count($res3) > 0) { //excluir a matrícula do curso se ela já existir, independente do status, tanto como Aguardando como Matriculado
                $id_mat = $res3[0]['id']; //id da matrícula do curso que já existe, porém, tem que ficar dentro do if, pois pode não existir

                $pdo->query("DELETE FROM matriculas where id = 'id_mat'");
            }

            //insere a matrícula de cada curso do pacote, independente se ela já existia ou não
            $pdo->query("INSERT INTO matriculas SET id_curso = '$id_do_curso', id_aluno = '$id_aluno', id_professor = '$id_professor', aulas_concluidas = 1, data = curDate(), status = 'Matriculado', pacote = 'Não', id_pacote = '$id_curso', obs = 'Pacote'"); //valor é 0 do curso, pois pagou pelo pacote
            //se o valor é 0, pois não foi decladado acima, é porque os cursos foram liberados após a compra de um pacote, então para maior organização no campo de observações marcamos Pacote, esse campo obs recebe Cartão Fidelidade quando a matrícula de um curso é liberada após o uso dos cartões fidelidade, portanto, esse campo serve para esclarecer como as matrículas foram feitas

            //atualizar número de matrículas do curso na tabela cursos
			$pdo->query("UPDATE cursos SET matriculas = '$quant_mat' where id = '$id_do_curso'");

        }
    }
}

//adicionar mais uma venda para o curso ou pacote
$query2 = $pdo->query("SELECT * FROM $tab where id = '$id_curso'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$matriculas = $res2[0]['matriculas'];
$quantid_mat = $matriculas + 1; //não nomeou a variável como quant_mat pois esse nome já foi usado 
$nome_curso = $res2[0]['nome']; //para o envio do email
$pdo->query("UPDATE $tab SET matriculas = '$quantid_mat' where id = '$id_curso'");

//enviar email para o admin, professor e aluno
require_once('../../../../pagamentos/email-aprovar-matricula.php');

echo 'Aprovado com Sucesso';

?>
