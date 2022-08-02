<?php

require_once('cabecalho.php');

?>

<section id="contact-page">
    <div class="container">
        <div class="section-heading text-center">
            <h2>Envie sua <span>Mensagem</span></h2>
            <p class="subheading">Responderemos em breve!</p>
        </div>
        <div class="row contact-wrap">
            <div class="status alert alert-success" style="display: none"></div>
            <form id="form" class="contact-form" name="contact-form" method="post">
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="nome" id="nome" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" id="email" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control">
                    </div>


                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="novidades" name="novidades" value="Sim" checked> <!-- checked deixa marcado a caixa como padrão -->
                        <label for="novidades" class="form-check-label"><small>Marque para receber nossas novidades por email.</small></label>
                    </div>


                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Mensagem *</label>
                        <textarea name="mensagem" id="mensagem" required="required" class="form-control" rows="8"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" name="btn-enviar" id="btn-enviar" class="btn btn-default submit-button">Enviar <i class="fa fa-caret-right"></i></button>
                        <!-- como o ajax não vai ser acionado pelo submit do form-contatos, e sim pelo clique no btn-enviar, pode trocar o tipo dele de submit para button -->
                    </div>
                </div>
            </form>
        </div>

        <div id="msg" align="center"></div>
    </div>
</section>

<?php

require_once('rodape.php');

?>

<!-- Mascaras JS -->
<script type="text/javascript" src="sistema/js/mascaras.js"></script>
<!-- para a máscara funcionar, o input do telefone tem que ser do tipo text -->

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<!--AJAX PARA CHAMAR O ENVIAR.PHP DO EMAIL -->
<script type="text/javascript">
    $(document).ready(function() {

        //poderia ser $('#form-contatos').submit ao invés do clique no btn-enviar, dá na mesma
        $('#btn-enviar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "enviar.php",
                method: "post",
                data: $('form').serialize(), //não funcionou quando chamei o id do form de form-contatos, e aqui também coloquei form-contatos
                dataType: "text",
                success: function(mensagem) {

                    $('#msg').removeClass()

                    if (mensagem.trim() === 'Enviado com Sucesso!') {

                        $('#msg').addClass('text-success')


                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#email').val('');
                        $('#mensagem').val('');


                        //$('#btn-fechar').click();
                        //location.reload();


                    } else {

                        $('#msg').addClass('text-danger')
                    }

                    $('#msg').text(mensagem)

                },

            })
        })
    })
</script>