<?php

require_once('../conexao.php');
require_once('verificar.php'); //aqui é dado @session_start();

//apenas administradores podem acessar, professores não
if(@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
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
    <div class="modal-dialog" role="document">
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
                                <input type="text" class="form-control" name="nome_usu" value="<?php echo $nome_usuario ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" class="form-control" id="cpf_usu" name="cpf_usu" value="<?php echo $cpf_usuario ?>" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email_usu" value="<?php echo $email_usuario ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" class="form-control" name="senha_usu" value="<?php echo $senha_usuario ?>" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" onChange="carregarImgPerfil();" id="foto-usu">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="divImg">
                                <img src="img/perfil/<?php echo $foto_usuario ?>" width="100px" id="target-usu">
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">
                    <input type="hidden" name="foto_usu" value="<?php echo $foto_usuario ?>">

                    <input type="hidden" name="antigoEmail" value="<?php echo $email_usuario; ?>">
                    <input type="hidden" name="antigoCpf" value="<?php echo $cpf_usuario; ?>">


                    <small>
                        <div id="mensagem-usu" align="center" class="mt-3"></div>
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar Dados</button>
                </div>
            </form>

        </div>
    </div>
</div>


