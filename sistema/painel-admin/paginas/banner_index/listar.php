<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'banner_index';

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
	<th>Título</th>
    <th class="esc">Descrição</th>
    <th class="esc">Link</th> 	<!-- lembrando que para testar alterações css tem que dar ctrl + f5 -->
    <th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $titulo = $res[$i]['titulo'];
        $link = $res[$i]['link'];
        $descricao = $res[$i]['descricao'];
        $foto = $res[$i]['foto'];
        $ativo = $res[$i]['ativo'];

        //formata descrição para mostrar apenas os primeiros 40 caracteres e depois completar com reticências
        $descricaoF = mb_strimwidth($descricao, 0, 40, "...");


        //ativar/desativar administrador
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
        <img src="img/banners/{$foto}" width="27px" class="me-2">
        {$titulo}</td>
        <td class="esc">{$descricaoF}</td>
        <td class="esc">{$link}</td>

        <td>
        <big><a href="#" onclick="editar('{$id}', '{$titulo}', '{$link}', '{$descricao}', '{$foto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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


        <!-- abertura ativar/desativar administrador -->
		<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>
        <!-- fechamento ativar/desativar administrador -->

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
    function editar(id, titulo, link, descricao, foto) {

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#titulo').val(titulo);
        $('#link').val(link);
        $('#descricao').val(descricao);


        $('#foto').val(''); //caminho da foto
        $('#target').attr('src', 'img/banners/' + foto); //mostra imagem da foto

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {
        $('#id').val('');
        $('#titulo').val('');
        $('#link').val('');
        $('#descricao').val('');

        $('#foto').val('');
        $('#target').attr('src', 'img/banners/sem-foto.png');
    }
</script>