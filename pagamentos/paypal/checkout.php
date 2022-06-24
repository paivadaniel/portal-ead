<?php
// Include and initialize database class
include_once('../../sistema/conexao.php');
@session_start();
$id_aluno = $_SESSION['id_pessoa']; //id_pessoa é diferente de id
//id_pessoa não é o id do aluno na tabela de alunos, mas o id em que na tabela usuários ele é relacionado com a tabela alunos

/*para configurar a conta paypal, no arquivo pagamentos/paypal/PaypalExpress.class.php altere:

public $paypalClientID
private $paypalSecret

para descobrir o valor delas, acesse developer.paypal.com/home

vá em Tools > API Executor,
escolha Paypal Checkout Standard,
copie Clied Id e Secret

*/


// Include and initialize paypal class
include 'PaypalExpress.class.php';
$paypal = new PaypalExpress;

// buscar do banco informações do cursp
$id_curso = $_GET['id'];

$query = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_curso' and id_aluno = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$matricula = $res[0]['id'];
$valor = $res[0]['subtotal'];
$pacote = $res[0]['pacote'];

if($pacote == 'Sim'){ //para pacote
                $query = $pdo->query("SELECT * from pacotes where id = '$id_curso' ");
                $res_curso = $query->fetchAll(PDO::FETCH_ASSOC);                            
                
                $curso = $res_curso[0]['nome'];
                $imagem = $res_curso[0]['imagem'];
                $desc_rapida = $res_curso[0]['desc_rapida'];

    }else{ //para curso
                $query = $pdo->query("SELECT * from cursos where id = '$id_curso' ");
                $res_curso = $query->fetchAll(PDO::FETCH_ASSOC);                
                
                $curso = $res_curso[0]['nome'];
                $imagem = $res_curso[0]['imagem'];
                $desc_rapida = $res_curso[0]['desc_rapida'];
    }




                         $nome_novo = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", 
        strtr(utf8_decode(trim($curso)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
        "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

          $nome_sem_espaco = preg_replace('/[ -]+/' , '-' , $nome_novo);



// Get product details
$conditions = array(
    'where' => array('id' => $matricula),
    'return_type' => 'single'
);



?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
   

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <title>Pagamento Paypal</title>
</head>
<body>

</body>
</html>



<!-- Modal Aula -->
      <div id="modalPaypal" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <!-- Modal content-->
          <div class="modal-content">
            <form method="POST" action="">
              <div class="modal-header">
              
                <h5 class="modal-title"><small>Pagamento Pelo Paypal - Aprovação Imediata</small></h5>
                <button type="submit" class="close" name="fecharModal">&times;</button>
              </form>
            </div>
            
                    <div class="modal-body">
                     
                        <div class="col-md-12 cursos-item">
                 
                    <div class="cursos-hover">
                    
                    </div>

                    <?php 
                        if($pacote == "Sim"){ ?>
                           <img class="img-fluid" src="../../sistema/painel-admin/img/pacotes/<?php echo $imagem; ?>" width="200" alt="">';
                       <?php }else{ ?>
                            <img class="img-fluid" src="../../sistema/painel-admin/img/cursos/<?php echo $imagem; ?>" width="200" alt="">';
                        <?php }
                     ?>
                   
                  
                  <div class="cursos-caption">
                     <span class="nome_curso"><?php echo $curso; ?></span><br>
                    <span class="text-muted"><?php echo $desc_rapida; ?></span>
                    <p class="valor_curso">R$ <?php echo $valor; ?></p>
                     <div id="paypal-button"></div>
                  </div>
                </div>
             
            </div>
                   
            
          </div>
        </div>
      </div>    



 
    
    <!-- Checkout button -->
    




<!--
JavaScript code to render PayPal checkout button
and execute payment
-->
<script>
paypal.Button.render({
    // Configure environment
    env: '<?php echo $paypal->paypalEnv; ?>',
    client: {
        sandbox: '<?php echo $paypal->paypalClientID; ?>',
        production: '<?php echo $paypal->paypalClientID; ?>'
    },
    // Customize button (optional)
    locale: 'pt_BR',
    style: {
        size: 'small',
        color: 'gold',
        shape: 'pill',
    },
    // Set up a payment
    payment: function (data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: '<?php echo $valor; ?>',
                    currency: 'BRL',
                   
                },
                 description: '<?php echo $curso; ?>',
                 custom: '<?php echo $matricula; ?>'
            }]
      });
    },
    // Execute the payment
    onAuthorize: function (data, actions) {
        return actions.payment.execute()
        .then(function () {
            // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');

            console.log(data);
            
            // Redirect to the payment process page
            window.location = "process.php?paymentID="+data.paymentID+"&token="+data.paymentToken+"&payerID="+data.payerID+"&pid=<?php echo $matricula; ?>";
        });
    }
}, '#paypal-button');
</script>



<script>

$("#modalPaypal").modal("show");

 </script> 