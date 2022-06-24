<?php
require_once('../../sistema/conexao.php');
include_once("../../pagamentos/mercadopago/lib/mercadopago.php");
include_once("../../pagamentos/mercadopago/PagamentoMP.php");

@session_start();

$id_aluno = $_SESSION['id_pessoa']; //id_pessoa é diferente de id
//id_pessoa não é o id do aluno na tabela de alunos, mas o id em que na tabela usuários ele é relacionado com a tabela alunos

$id_do_curso_pag = $_POST['id_curso'];
$nome_curso = $_POST['nome_curso'];



$query = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id_do_curso_pag' and id_aluno = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$id_matricula = $res[0]['id'];
$valor_curso = $res[0]['subtotal'];

$pagar = new PagamentoMP;

/* para configurar suas credenciais do Mercado Pago, no arquivo pagamentos/mercadopago/PagamentoMP.php, altere as variáveis

private $client_id
private $client_secret

Para descobrir o valor delas, acesse mercadopago.com.br

Na sidebar esquerda, vá em:

Seu negócio > Configurações, e em Gestão e administração clique em Credenciais

*/

$btn = $pagar->PagarMP($id_do_curso_pag, $nome_curso, (float)$valor_curso, $url_sistema);
echo '<div align="center"><i class="neutra"><small>(Divida em até 12 Vezes) <br> <span class="neutra ocultar-mobile">Pagamento no Cartão ou Saldo</span></small></i></div>';

?>