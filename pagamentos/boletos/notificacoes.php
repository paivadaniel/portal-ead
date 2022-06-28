<?php
 
/*essa página serve para notificar da aprovação ou não do boleto, a notificação é enviada pela manhã,
a verificação é diária, o gerencianet atualiza o status de aprovação do pagamento dos boletos
de madrugada, pelas 3h da manhã
*/
//CHAVES DO GERENCIANET gerencianet.com.br
require_once('config.php');

// AUTO LOAD PARA O COMPOSER
require_once('vendor/autoload.php');


use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
$clientId = CONF_ID; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
$clientSecret = CONF_SECRETO; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
 
$options = [
  'client_id' => $clientId,
  'client_secret' => $clientSecret,
  'sandbox' => CONF_SANDBOX,
];
 
/*
* Este token será recebido em sua variável que representa os parâmetros do POST
* Ex.: $_POST['notification']
*/
$params = [
  'id' => $boleto // $charge_id refere-se ao ID da transação ("charge_id")
  /*para testar aqui posso substituir a variável boleto pelo número do boleto,
  que pode ser encontrado no boleto, ou na tabela matriculas, campo boleto, por exemplo 447966522
  e então acessar http://localhost/dashboard/www/portal-ead/pagamentos/boletos/notificacoes.php
  o resultado deve ser waiting se o pagamento do boleto estiver aguardando aprovação
  para ver esse resultado, tem que estar descomentado a linha print_r($charge['data']['status']);  
  */
];

try {
    $api = new Gerencianet($options);
    $charge = $api->detailCharge($params, []);
    //print_r($charge);   
    print_r($charge['data']['status']);  

    $status = $charge['data']['status'];   
   
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}