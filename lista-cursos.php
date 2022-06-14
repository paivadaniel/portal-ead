<?php 
require_once("cabecalho.php");

?>



<br>
<hr>


<?php 
$query = $pdo->query("SELECT * FROM cursos where status = 'Aprovado' and sistema = 'Não' ORDER BY id desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
   ?>


    <div class="row" style="margin-left: 10px; margin-right: 10px;">
                <div class="col-md-8 col-xs-6" >
                <p><span class="ocultar-mobile">Total - </span> <?php echo $total_reg ?> Cursos</p>
             <!-- no .ocultar-mobile usou <span> ao invés de <div> porque este causa quebra de linha 
            classe .ocultar-mobile foi definida com max-width: 700px   
            -->
            </div>

             <div class="col-md-4 col-xs-6">
                  <div class="search-box-pag " style="margin-top: 10px;">
                        <button class="btn-search-pag"><i class="fa fa-search"></i></button> <!-- para pegar o ícone da lupa tive que alterar de 'fas fa-search' para 'fa fa-search' -->
                        <input onkeyup="listar()" type="text" class="input-search-pag" placeholder="Busque um Curso..." id="buscar">
                    </div>

                  </div>

        </div>

        <hr>

    <br>
                
      <div id="listar-cursos">    


      </div>

        <?php } else {
            echo '<p align="center">Nenhum curso encontrado.</p>';
          }?>



<br><br>

<?php 
require_once("rodape.php");
?>



<script type="text/javascript">
  $(document).ready(function() {
    listar();
} );



function listar(pagina){
  console.log(pagina)

  var busca = $("#buscar").val();
    $.ajax({
        url: "script/ajax-listar-cursos.php",
        method: 'POST',
        data: {busca, pagina},
        dataType: "html",

        success:function(result){
            $("#listar-cursos").html(result);
           
        }
    });
}
</script>