<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'alunos';

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) { //cria a tabela

    /*
para abrir HTML Dentro do PHP, sem ter que fechar o PHP, siga exatamente a sintaxe a seguir, respeito o HTML colocado por linhaenão não roda

echo <<<HTML //aqui abre o HTML dentro do PHP
<small> <b> Conteúdo </b> <br> HTML </small>
HTML; //aqui fecha o HTML dentro do PHP 

*/

    //não dá para usar o recurso de autocompletar do HTML na forma abaixo, diferente se fechar a tag php para iniciar o HTML
    //tem que usar a abertura e fechamento HTML colado no canto esquerdo, sem espaço, senão pode dar problema ao interpretar
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
    <th></th>
	<th>Nome</th>
    <th class="esc">Email</th> 	<!-- lembrando que para testar alterações css tem que dar ctrl + f5 -->
	<th class="esc">Telefone</th> <!-- esc é uma classe que não deixa visível em mobile -->
	<th class="esc">Cadastro</th>	
	<th class="">Cartões</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $nome = $res[$i]['nome'];
        $email = $res[$i]['email'];
        $telefone = $res[$i]['telefone'];
        $pais = $res[$i]['pais'];
        $data = $res[$i]['data'];
        $cartao = $res[$i]['cartao'];

        $id = $res[$i]['id'];
        $cpf = $res[$i]['cpf'];
        $endereco = $res[$i]['endereco'];
        $cidade = $res[$i]['cidade'];
        $estado = $res[$i]['estado'];
        $foto = $res[$i]['foto'];
        $ativo = $res[$i]['ativo'];

        $dataF = implode('/', array_reverse(explode('-', $data)));

        //recuperar senha, está na tabela usuários
        $query2 = $pdo->query("SELECT * FROM usuarios WHERE id_pessoa = '$id' AND nivel = 'Aluno'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $senha_usuario = $res2[0]['senha'];

        //ativar/desativar aluno
        if ($ativo == 'Sim') {
            $icone = 'fa-check-square';
            $titulo_link = 'Desativar Item';
            $acao = 'Não'; //manda para o campo ativo o valor 'Não"
            $classe_linha = '';
        } else {
            $icone = 'fa-square-o';
            $titulo_link = 'Ativar Item';
            $acao = 'Sim'; //manda para o campo ativo o valor 'Sim"
            $classe_linha = 'text-muted';
        }

        echo <<<HTML
    <tr class="{$classe_linha}">
        <td> <!-- $classe_linha é uma formatação para a linha de alunos inativos -->
        <img src="img/perfil/{$foto}" width="27px" class="me-2">
        </td>
        <td class="">{$nome}</td> <!-- repare que <?php echo $nome ?> é substituído aqui por {$nome}-->
        <td class="esc">{$email}</td>
        <td class="esc">
            {$telefone}
            <a href="https://api.whatsapp.com/send?1=pt_BR&phone=55{$telefone}" target="_blank" title="Chamar no Whatsapp"><i class="fa fa-whatsapp verde"></i></a>
        
        </td>
        <td class="esc">{$dataF}</td>
        <td class=""> <input type="number" id="cartao" value="{$cartao}" style="width:45px; height:27px; margin-right:5px; text-align:center; border: 2px solid #cfcfcf">
    
        <a href="#" onclick="editarCartoes('{$id}')" title="Editar Cartões"><i class="fa fa-check verde"></i></a>
        </td>
        <td>

        <big><a href="#" onclick="editar('{$id}', '{$nome}', '{$cpf}', '{$email}', '{$telefone}', '{$endereco}', '{$cidade}', '{$estado}', '{$pais}', '{$foto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

		<big><a href="#" onclick="mostrar('{$nome}', '{$cpf}','{$email}','{$telefone}','{$endereco}','{$cidade}','{$estado}','{$pais}', '{$foto}', '{$dataF}', '{$cartao}', '{$ativo}', '{$senha_usuario}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        <!-- fechamento excluir -->


        <!-- abertura ativar/desativar aluno -->
		<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
        <!-- fechamento ativar/desativar aluno -->

    </td>


    </tr>

HTML;
    }

    echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem-excluir"></div></small>
    </table>	
    HTML;
} else {
    echo 'Nenhum registro cadastrado';
}

echo <<<HTML
</small>
HTML;

?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabela').DataTable({ //id="tabela" é o id da tabela dessa página
            "ordering": false, //desconsidera a ordenação padrão, e considera a do mysql, ou seja, mostrando os últimos alunos inseridos
            "stateSave": true, //se fizer alguma alteração no aluno, que tiver sido encontrado no campo busca, após salvar a alteração, volta para a página sem busca, e com stateSave true, faz a alteração e conserva a página com a busca digitada, isso foi explicado no final da mod02 aula 52
        });
        $('#tabela_filter label input').focus();
    });

    //não vai no js/ajax.js pois não é genérica, por exemplo, a função de editar cursos recebe outros parâmetros
    //função para abrir a modal de editar com os valores preenchidos carregados
    //ela poderia ir dentro de alunos.php, porém, tudo que está aqui dentro, está sendo carregado em alunos.php, no elemento com id="listar"
    function editar(id, nome, cpf, email, telefone, endereco, cidade, estado, pais, foto) {

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val(nome);
        $('#telefone').val(telefone);
        $('#cpf').val(cpf);
        $('#email').val(email);
        $('#endereco').val(endereco);
        $('#cidade').val(cidade);
        $('#estado').val(estado);
        $('#pais').val(pais);
        //$('#foto').val(foto); //só por ter uma linha a mais não estava abrindo a modal
        $('#foto').val(''); //caminho da foto
        $('#target').attr('src', 'img/perfil/' + foto); //mostra imagem da foto

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    function mostrar(nome, cpf, email, telefone, endereco, cidade, estado, pais, foto, data, cartao, ativo, senha) {

        $('#nome_mostrar').text(nome);
        $('#telefone_mostrar').text(telefone);
        $('#cpf_mostrar').text(cpf);
        $('#email_mostrar').text(email);
        $('#senha_mostrar').text(senha);
        $('#endereco_mostrar').text(endereco);
        $('#cidade_mostrar').text(cidade);
        $('#estado_mostrar').text(estado);
        $('#pais_mostrar').text(pais);
        $('#data_mostrar').text(data);
        $('#cartao_mostrar').text(cartao);
        $('#ativo_mostrar').text(ativo);
        $('#target_mostrar').attr('src', 'img/perfil/' + foto);

        $('#modalMostrar').modal('show');

    }

    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {
        $('#id').val('');
        $('#nome').val('');
        $('#telefone').val('');
        $('#cpf').val('');
        $('#email').val('');
        $('#endereco').val('');
        $('#cidade').val('');
        $('#estado').val('');
        $('#pais').val('');
        $('#foto').val('');
        $('#target').attr('src', 'img/perfil/sem-perfil.jpg');
    }


    function editarCartoes(id) {

        var cartao = $('#cartao').val();

        $.ajax({
            url: 'paginas/' + pag + "/editar-cartoes.php",
            method: 'POST',
            data: {
                id,
                cartao
            },
            dataType: "text",

            success: function(mensagem) {
                $('#mensagem-excluir').addClass('')
                if (mensagem.trim() == "Alterado com Sucesso") {
                    //listar();
                    $('#mensagem-excluir').addClass('verde')
                    $('#mensagem-excluir').text(mensagem)

                } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)

                }
            },

        });

    }
</script>