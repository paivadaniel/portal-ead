<?php
require_once('../../sistema/conexao.php');
include_once("../../pagamentos/mercadopago/lib/mercadopago.php");
include_once("../../pagamentos/mercadopago/PagamentoMP.php");

//esse arquivo lista o botão do mercado pago na modal Pagamento (que fica em curso.php e pacote.php)

//@session_start();
//$id_aluno = $_SESSION['id_pessoa']; //id_pessoa é diferente de id
/*
no mod 09 aula 06, autor mudou de receber por SESSION o id_aluno para receber por POST da listarBotaoMP() em curso.php, e passou a recuperar id_aluno por SESSION em curso.php
ele fez isso porque o botão do mercado livre não estava aparecendo no arquivo hospedado no servidor,
segundo ele isso está ocorrendo por listar-btn-mp ser chamada via AJAX
*/

//id_pessoa não é o id do aluno na tabela de alunos, mas o id em que na tabela usuários ele é relacionado com a tabela alunos

$id_do_curso_pag = $_POST['id_curso'];
$nome_curso = $_POST['nome_curso'];
$id_aluno = $_POST['id_aluno'];
$pacote = $_POST['pacote'];

$query = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id_do_curso_pag' and id_aluno = $id_aluno and pacote = '$pacote'");
/*
autor falou algo que não tem lógica nenhuma e ele mesmo assumiu isso e não soube explicar o porquê de ter que tirar as aspas simples em volta de $id_aluno no SELECT acima, isso está no mod12 aula03 minutagem 03:55

para mim fazer isso aparentemente não mudou nada, o botão do mercado livre continua aparecendo e sumindo

*/
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) > 0) {

$id_matricula = $res[0]['id'];
$valor_curso = $res[0]['subtotal'];

if($valor_curso == 0) { //fez isso para evitar um problema que ele citou mod13 aula03, que seria o aluno logar clicando em comprar um curso que ele já comprou e ainda com o cartão fidelidade
    $valor_curso = 1;
}


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
}
