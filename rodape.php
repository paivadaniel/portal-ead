<?php

require_once('sistema/conexao.php'); //acho que não precisa, pois toda página que tiver rodapé vai ter cabeçalho, e já está chamando a conexao no cabeçalho, que vem primeiro

?>

</div> <!-- fechamento da div area-conteudo, que começa em cabecalho.php -->

<section id="bottom-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 btm-footer-links ocultar-mobile">
                <a href="politica">Política de Privacidade</a>
                <a href="termos">Termos de Uso</a>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 copyright">
                <span class="cor-branca ocultar-mobile"><?php echo $nome_sistema ?> / </span> <i class="fa fa-envelope" style="color:#FFF; margin-right:5px"> </i><a href="#" style="color:#FFF"><?php echo $email_sistema ?></a> / <i class="fa fa-whatsapp" style="color:#FFF; margin-right:5px"></i><a href="http://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $tel_sistema ?>" target="_blank" style="color:#FFF"><?php echo $tel_sistema ?></a>
            </div>


        </div>
    </div>
</section>

<?php

$url = basename($_SERVER['PHP_SELF'], '.php'); //basename e a variável de sessão PHP_SELF, com o segundo argumento .php, retornam o nome da página php

if ($url == 'index') {

?>

    <div id="panel">
        <div id="panel-admin">
            <div class="panel-admin-box">
                <div id="tootlbar_colors">
                    <!-- o código está em script/index.js, que tem function mytheme(index)-->
                    <button class="color" style="background-color:#1abac8;" onclick="mytheme(0)"></button>
                    <button class="color" style="background-color:#ff8a00;" onclick="mytheme(1)"> </button>
                    <button class="color" style="background-color:#b4de50;" onclick="mytheme(2)"> </button>
                    <button class="color" style="background-color:#e54e53;" onclick="mytheme(3)"> </button>
                    <button class="color" style="background-color:#1abc9c;" onclick="mytheme(4)"> </button>
                    <button class="color" style="background-color:#159eee;" onclick="mytheme(5)"> </button>
                </div>
            </div>

        </div>


        <a class="open" href="#"><span><i class="fa fa-gear fa-spin"></i></span></a>


    </div>

<?php
}

?>

</html>

<!-- link para chamar o AJAX para poder utilizar o ajax-listar-cursos.php -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!-- js do bootstrap3, estava sendo chamado no cabecalho.php, porém, a modalContato no curso.php não estava abrindo, abriu quando colocou no rodapé, autor não sabe explicar o porquê desse erro
de posicionamento -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Mascaras JS -->
<script type="text/javascript" src="sistema/js/mascaras.js"></script>
<!-- para a máscara funcionar, o input do telefone tem que ser do tipo text -->

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
