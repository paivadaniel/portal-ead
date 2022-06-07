<?php
require_once("../sistema/conexao.php");

$busca = '%' . $_POST['busca'] . '%';

//isso foi feito pois depois de feita uma busca, quando apagamos tudo que estiver no buscar_cab, ele traz todos os cursos, quando queremos que não traga nenhum
if($busca == '%%') { //se a busca for vazia
exit();
}

//procura por pacotes no campo buscar e exibe em id=buscar_cab, que está definido e também o AJAX em cabecalho.php
$query = $pdo->query("SELECT * FROM pacotes WHERE nome LIKE '$busca' or desc_rapida LIKE '$busca' ORDER BY id desc"); //LIMIT vai de limit à itens_pag
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  echo <<<HTML
    <section id="portfolio" style="margin-top:100px;">

<div class="row" style="margin-left:10px; margin-right:10px; margin-top:-100px;">
HTML;

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }
    $id = $res[$i]['id'];
    $nome = $res[$i]['nome'];
    $desc_rapida = $res[$i]['desc_rapida'];
    $valor = $res[$i]['valor'];
    $foto = $res[$i]['imagem'];
    $promocao = $res[$i]['promocao'];
    $primeira_aula = $res[$i]['video'];

    $valorF = number_format($valor, 2, ',', '.');
    $promocaoF = number_format($promocao, 2, ',', '.');

    if ($promocao > 0) {
      $ativo = '';
      $ativo2 = 'ocultar';
    } else {
      $ativo = 'ocultar';
      $ativo2 = '';
    }
    
    echo <<<HTML
   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                    <div class="portfolio-one">
                        <div class="portfolio-head">
                            <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/pacotes/{$foto}"></div>
                            <div class="portfolio-hover">
                                <iframe class="video-card" src="{$primeira_aula}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                <div class="" align="center" style="margin-top:20px;">
                                    <a href="#" type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                </div>


                            </div>
                        </div>
                        <!-- End portfolio-head -->
                        <div class="portfolio-content" align="center">
                            <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                            <a href="#" title="Detalhes do Pacote">

                                <h5 class="title">{$nome}</h5>
                                <p style="margin-top:0px;">{$desc_rapida}</p>
                            </a>
                            <div class="product-bottom-details">
HTML;

    if ($promocao > 0) {

      echo <<<HTML
                                    <div class="product-price"><small>R$ {$valorF}</small>R$ {$promocaoF}</div>
HTML;
    } else {
      echo <<<HTML

                                    <div class="product-price">R$ {$valorF}</div>
HTML;
    }
    echo <<<HTML

                                <div class="product-links">
                                    <a href=""><i class="fa fa-heart"></i></a>
                                    <a href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- End portfolio-content -->
                    </div>
                    <!-- End portfolio-item -->
                </div>
HTML;
  }


}//fechamento do if



//procura por campos no campo buscar e exibe em id=buscar_cab, que está definido e também o AJAX em cabecalho.php
$query = $pdo->query("SELECT * FROM cursos where status = 'Aprovado' and sistema = 'Não' and (nome LIKE '$busca' or desc_rapida LIKE '$busca') ORDER BY id desc"); //LIMIT vai de limit à itens_pag
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }
    $id = $res[$i]['id'];
    $nome = $res[$i]['nome'];
    $desc_rapida = $res[$i]['desc_rapida'];
    $valor = $res[$i]['valor'];
    $foto = $res[$i]['imagem'];
    $promocao = $res[$i]['promocao'];

    $valorF = number_format($valor, 2, ',', '.');
    $promocaoF = number_format($promocao, 2, ',', '.');

    if ($promocao > 0) {
      $ativo = '';
      $ativo2 = 'ocultar';
    } else {
      $ativo = 'ocultar';
      $ativo2 = '';
    }

    //video primeira aula
    $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id' and numero = 1 and (sessao = 0 or sessao = 1)"); //outra forma de resolver aqui para pegar a aula com o id menor, e daí poderia tirar sessao = 0 or sessao = 1 e substituir por order by id asc, que pegamos apenas o primeiro resultado aqui res2[0]['link']
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_reg2 = @count($res2);

    if ($total_reg2 > 0) {
      $primeira_aula = $res2[0]['link'];
    } else {
      $primeira_aula = '';
    }

    echo <<<HTML
   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                    <div class="portfolio-one">
                        <div class="portfolio-head">
                            <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/cursos/{$foto}"></div>
                            <div class="portfolio-hover">
                                <iframe class="video-card" src="{$primeira_aula}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                <div class="" align="center" style="margin-top:20px;">
                                    <a href="#" type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                </div>


                            </div>
                        </div>
                        <!-- End portfolio-head -->
                        <div class="portfolio-content" align="center">
                            <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                            <a href="#" title="Detalhes do Curso">

                                <h5 class="title">{$nome}</h5>
                                <p style="margin-top:0px;">{$desc_rapida}</p>
                            </a>
                            <div class="product-bottom-details">
HTML;

    if ($promocao > 0) {

      echo <<<HTML
                                    <div class="product-price"><small>R$ {$valorF}</small>R$ {$promocaoF}</div>
HTML;
    } else {
      echo <<<HTML

                                    <div class="product-price">R$ {$valorF}</div>
HTML;
    }
    echo <<<HTML

                                <div class="product-links">
                                    <a href=""><i class="fa fa-heart"></i></a>
                                    <a href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- End portfolio-content -->
                    </div>
                    <!-- End portfolio-item -->
                </div>
HTML;
  }


  echo <<<HTML
</div>
</section>


HTML;
} 
/*
//não pode ter esse else, pois se não tiver o curso, pode ter o pacote (que está sendo procurado lá em cima), no pior dos casos não terá os dois, e as duas mensagens de não tem (pacote e curso) não poderão ser mostradas juntas, a não ser que fosse feito um if grande para tratar tudo isso
else {
  echo '<br><p align="center">Não possui nenhum curso com este nome!</p>';
}

*/
