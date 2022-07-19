<?php 

require("../../sistema/conexao.php");

 if($_GET['collection_id'] || $_GET['id']){   
                   // Conexão
   require_once 'lib/mercadopago.php';  // Biblioteca Mercado Pago
   require_once 'PagamentoMP.php';            // Classe Pagamento
   
   $pagar = new PagamentoMP;
   
   if(isset($_GET['collection_id'])):
    $id =  $_GET['collection_id'];
   elseif(isset($_GET['id'])):
    $id =  $_GET['id'];
   endif; 
   
   
   $retorno = $pagar->Retorno($id , $pdo); //apagou $conexao no segundo argumento e deixou vazio, não entendi bem o porquê, explicou no 04:00 da mod12 aula 41
   //na aula 42, mudou de vazio para $pdo, e disse que do outro jeito não funcionaria
   //retorno é uma função que está em PagamentoMP>php

   //não entendi também porque um if se tanto se der certo quanto se der errado vai retornar para a mesma url, talvez porque os argumentos na url de retorno sejam diferentes (que deixam o link à mostra para o usuário diferente, por exemplo retorno?=failure, retorno?=success), mas o link de redirecionamento é o mesmo
   if($retorno){ //se o pagamento for aprovado
      // Redirecionar usuario
      echo '<script>location.href="../sistema/painel-aluno/"</script>';
   }else{ //se o pagamento não for aprovado
     // Redirecionar usuario e informar erro ao admin
      echo '<script>location.href="../sistema/painel-aluno/"</script>';
      
      /*
       
       ENVIAR EMAIL AO ADMIN
      
      */
   }
   
 }
 
 
?>