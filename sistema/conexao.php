<?php

//VARIÁVEIS DO SERVIDOR LOCAL

$servidor = 'localhost';
$banco = 'portalead';
$usuario = 'root';
$senha = '';

//url sistema
//ao invés de digitar $url_sistema = 'http://localhost/dashboard/www/portal-ead/';, automatiza da seguinte maneira:
$url_sistema = "http://$_SERVER[HTTP_HOST]/"; //se for servidor local, armazena localhost, do contrário, armazena http://hugocursos.com.br, se este for o domínio em que está hospedado os arquivos
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/portalead/";
}

//VARIÁVEIS DO SISTEMA
$nome_sistema = 'Portal EAD do Danielzinho'; //esse é o nome padrão, depois o usuário pode mudar o nome do sistema, que o resultado ficará armazenado na variável nome_sistema na tabela config do banco de dados
$email_sistema = 'danielantunespaiva@gmail.com';
$tel_sistema = '(15) 99180-5895';

date_default_timezone_set('America/Sao_Paulo');

try {
    //fora a PDO, existem outros tipos de conexões com o banco de dados, como mysqli
    $pdo = new PDO("mysql:dbname=$banco; host=$servidor", "$usuario", "$senha");
} catch (Throwable $th) { //Exception $e não funciona para mim
    echo 'Erro ao conectar ao banco de dados! <br><br>' . $th;
}

//VERIFICA SE JÁ HÁ UM USUÁRIO ADMINISTRADOR CRIADO

$query = $pdo->query("SELECT * FROM config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg == 0) { //se a tabela config não tiver nenhum registro

    $pdo->query("INSERT into config SET nome_sistema = '$nome_sistema', email_sistema = '$email_sistema', tel_sistema = '$tel_sistema', logo = 'logo.png', icone = 'favicon.ico', logo_rel = 'logo.jpg'"); //na biblioteca dompdf, relatório em pdf não faz leitura de png, somente jpg, por isso a logo do relatório tem que ser em .jpg
} else { //se a tabela config já tiver dados

    //RECUPERA OS DADOS DA TABELA CONFIG

    $nome_sistema = $res[0]['nome_sistema']; //o usuário pode ter alterado o nome do sistema no painel de controle para um diferente que o criado inicialmente, daí ele tem que puxar esse novo nome, o mesmo para telefone e email 
    $email_sistema = $res[0]['email_sistema']; 
    $cnpj_sistema = $res[0]['cnpj_sistema']; 
    $tipo_chave_pix = $res[0]['tipo_chave_pix']; 
    $chave_pix = $res[0]['chave_pix']; 
    $facebook_sistema = $res[0]['facebook']; 
    $instagram_sistema = $res[0]['instagram']; 
    $youtube_sistema = $res[0]['youtube']; 
    //$logo = $res[0]['logo']; //não precisa pois o nome nunca muda
    //$icone = $res[0]['icone']; 
    //$logo_rel = $res[0]['logo_rel']; 
    //$qrcode_pix = $res[0]['qrcode_pix'];  //não precisa pois o nome nunca muda


}

?>
