<?php

require_once('../conexao.php');
require_once('verificar.php'); //aqui é dado @session_start();

$pag= 'alunos';

//apenas administradores podem acessar, professores não
if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
    echo "<script> window.location='index.php'</script>";
    exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- botão que quando clicado chama a função de inserir aluno -->
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Aluno</button>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>



<!-- id="modalForm", h4 com id="tituloModal" e form com id="form" serão padrão -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tituloModal">Editar Dados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" class="form-control" name="cpf" id="cpf" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua X Número 20 Bairro Y">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>País</label>
                                <input type="text" class="form-control" id="pais" name="pais">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" id="foto" name="foto" onChange="carregarImg();">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="divImg">
                                <img src="img/perfil/sem-perfil.jpg" width="100px" id="target-usu">
                            </div>
                        </div>

                    </div>

                    <small>
                        <div id="mensagem" align="center" class="mt-3"></div>
                    </small>

                    <input type="hidden" name="id" id="id">

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar Dados</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript"> var pag = "<?=$pag?>" </script>

<script src="js/ajax.js"></script>