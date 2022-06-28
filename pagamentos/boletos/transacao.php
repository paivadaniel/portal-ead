<?php
require_once("../../sistema/conexao.php");
@session_start();
$id_aluno = $_SESSION['id_pessoa'];
$data_hoje = date('Y-m-d');

//o resultado final de transacao.php (ver no final do código) passa para gerar-boleto.php

//ALIMENTAR O BOLETO
$id_curso = $_POST['id_curso']; //id do curso
$cpf_aluno = $_POST['cpf'];

if($id_curso == ""){
  echo 'Você não selecionou nenhum curso!';
  exit();
}

//recupera id da matrícula e se é pacote ou curso
$query = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_curso' and id_aluno = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
$id_matricula = $res[0]['id'];
$valor = $res[0]['subtotal'] * 100; //segundo autor se for 100 reais, ele coloca 1, por isso multiplica por 100, não entendi o porque de colocar 1 se for 100
$data_venc = date('Y-m-d', strtotime("+7 days",strtotime($data_hoje)));
$pacote = $res[0]['pacote'];

if($pacote == 'Sim'){
  $tabela = 'pacotes';
}else{
  $tabela = 'cursos';
}

//recupera nome do curso
$query = $pdo->query("SELECT * FROM $tabela where id = '$id_curso'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$titulo = $res[0]['nome'];

//recupera nome e email do aluno
$query = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_aluno'"); //alterei de id para id_pessoa
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aluno = $res[0]['nome'];
$email = $res[0]['email'];

//o que vai sair no boleto
$nome = $aluno; //pra que?
$telefone = $tel_sistema; //coloca o telefone do sistema ao invés do do aluno, pois ele pode preencher errado
$email = $email_sistema;  //coloca o email do sistema ao invés do do aluno, pois ele pode preencher errado
$cpf = $cpf_aluno;



$cpf = str_replace('.', '', $cpf);   
$cpf = str_replace('-', '', $cpf);   

$telefone = str_replace('-', '', $telefone);   
$telefone = str_replace('(', '', $telefone); 
$telefone = str_replace(')', '', $telefone); 
$telefone = str_replace(' ', '', $telefone); 


}else{
 echo 'Você não selecionou uma matrícula válida!';
  exit();
}


//CHAVES DO GERENCIANET gerencianet.com.br
require_once('config.php');

// AUTO LOAD PARA O COMPOSER
require_once('vendor/autoload.php');


use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = CONF_ID; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientSecret = CONF_SECRETO; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

/* no pagseguro e no mercado pago o id da matrícula é o mesmo que será utilizado para fazer
a aprovação do pagamento, mas para boleto temos que criar um id específico para o pagamento daquele boleto

*/
$boleto = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);    

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => CONF_SANDBOX,
      ];
       
      $item_1 = [
          'name' => $titulo, // nome do item, produto ou serviço
          'amount' => 1, // quantidade
          'value' => intval($valor) // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
      ];
       

      $items =  [
          $item_1
      ];

      $body  =  [
        'items' => $items
    ];
    
    try {
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);

         //SALVAR O ID DO BOLETO NA TABELA DAS CONTAS A RECEBER
        $id_boleto = $charge['data']['charge_id'];
        $query = $pdo->query("UPDATE matriculas SET boleto = '$id_boleto' WHERE id = '$id_matricula' ");
     
        //print_r($charge);
        header("Location: gerar-boleto.php?id=".$charge['data']['charge_id']."&nome=".$nome."&cpf=".$cpf."&fone=".$telefone."&vencimento=".$data_venc);
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }

    


?>