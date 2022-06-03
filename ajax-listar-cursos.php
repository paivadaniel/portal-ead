<?php 
require_once("sistema/conexao.php");

$busca = '%'.$_POST['busca'].'%';

// pegar a pagina atual
if(@$_POST['pagina'] == ""){
    @$_POST['pagina'] = 0;  //fica na primeira página
}

//pegar a página atual
$pagina = intval(@$_POST['pagina']); //número da página que estou clicando
$limite = $pagina * $itens_pag; //se for pagina = 0, vai de 0 à última página * itens_pag

$query = $pdo->query("SELECT * FROM cursos where status = 'Aprovado' and sistema = 'Não' and (nome LIKE '$busca' or desc_rapida LIKE '$busca') ORDER BY id desc LIMIT $limite, $itens_pag"); //LIMIT vai de limit à itens_pag
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

echo <<<HTML
<div class="row" style="margin-left:10px; margin-right:10px; margin-top:-50px;" >
HTML;

for($i=0; $i < $total_reg; $i++){
    foreach ($res[$i] as $key => $value){}
        $id = $res[$i]['id'];
    $nome = $res[$i]['nome'];
    $desc_rapida = $res[$i]['desc_rapida'];      
    $valor = $res[$i]['valor'];     
    $foto = $res[$i]['imagem']; 
    $promocao = $res[$i]['promocao'];

    $valorF = number_format($valor, 2, ',', '.');    
    $promocaoF = number_format($promocao, 2, ',', '.');

    if($promocao > 0){
        $ativo = '';
        $ativo2 = 'ocultar';
    }else{
        $ativo = 'ocultar';
         $ativo2 = '';
    } 


    $query2 = $pdo->query("SELECT * FROM cursos where status = 'Aprovado' and sistema = 'Não' and (nome LIKE '$busca' or desc_rapida LIKE '$busca') ORDER BY id desc ");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_reg2 = @count($res2);

     $num_paginas = ceil($total_reg2/$itens_pag); //itens_pag é variável global definida em sistema/conexao.php
    

echo <<<HTML
    <div class="col-md-2 col-sm-6 col-xs-6">    
        <div class="product-card">                  
            <div class="product-tumb">
                <a href=""><img src="sistema/painel-admin/img/cursos/{$foto}" alt="" width="100%"></a>
            </div>
            <div class="product-details">                       
                <h4><a href="">{$nome}</a></h4>
                <p>{$desc_rapida}</p>
                
                    <div class="product-bottom-details {$ativo}">
                        <div class="product-price"><small>{$valorF}</small>R$ {$promocaoF}</div>
                    </div>
                
                    <div class="product-bottom-details {$ativo2}">
                        <div class="product-price">R$ {$valorF}</div>
                    </div>
              

            </div>
        </div>
    </div>
HTML;


}


echo <<<HTML
</div>
<hr>
   <div class="row" align="center">
     <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a onclick="listar(0)" class="paginador" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
HTML;

            for($i=0;$i<$num_paginas;$i++){
            $estilo = "";
            if($pagina >= ($i - 2) and $pagina <= ($i + 2)){
            if($pagina == $i)
              $estilo = "active";

          $pag = $i+1;
          $ultimo_reg = $num_paginas - 1; //num_paginas é o total de páginas, e é acrescido de 2, porém, depois ele viu que se subtraisse 2 aparecia uma página a mais, daí colocou -1

echo <<<HTML

             <li class="page-item {$estilo}">
              <a onclick="listar({$i})" class="paginador " href="#" >{$pag}
                
              </a></li>
HTML;

          } 
      } 

echo <<<HTML

            <li class="page-item">
              <a onclick="listar({$ultimo_reg})" class="paginador" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </nav>
      </div> 

HTML;      

}else{
    echo '<br><p align="center">Não possui nenhum curso com este nome!</p>';
}

?>