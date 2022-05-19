<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cursos';

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
	<th class="">Valor</th>
    <th class="">Professor</th>	
    <th class="">Categoria</th>	
    <th class="esc">Alunos</th>	
    <th class="esc">Aulas</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $nome = $res[$i]['nome'];
        $desc_rapida = $res[$i]['desc_rapida'];
        $desc_longa = $res[$i]['desc_longa'];
        $valor = $res[$i]['valor'];
        $professor = $res[$i]['professor'];
        $categoria = $res[$i]['categoria'];
        $foto = $res[$i]['imagem'];
        $status = $res[$i]['status'];
        $carga = $res[$i]['carga'];
        $mensagem = $res[$i]['mensagem'];
        $arquivo = $res[$i]['arquivo'];
        $ano = $res[$i]['ano'];
        $palavras = $res[$i]['palavras'];
        $grupo = $res[$i]['grupo'];
        $nome_url = $res[$i]['nome_url'];
        $pacote = $res[$i]['pacote'];
        $sistema = $res[$i]['sistema'];
        $link = $res[$i]['link'];
        $tecnologias = $res[$i]['tecnologias'];
    
        $query2 = $pdo->query("SELECT * FROM usuarios WHERE id = '$professor'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_professor = $res2[$i]['nome'];
        
        $query2 = $pdo->query("SELECT * FROM categorias WHERE id = '$categoria'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_categoria = $res2[$i]['nome'];

        $query2 = $pdo->query("SELECT * FROM grupos WHERE id = '$grupo'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_grupo = $res2[$i]['nome'];

        if($status == 'Aprovado'){
            $excluir = 'ocultar'; //cursos aprovados não podem ser excluidos
            $icone = 'fa-check-square';
            $titulo_link = 'Desaprovar Curso';
            $acao = 'Aguardando'; //ação é o contrário, se está aprovado, e for clicado, a ação é mudar para 'Aguardando'
            $classe_linha = '';
            $classe_square = 'verde';
        }else{
            $excluir = '';
            $icone = 'fa-square-o';
            $titulo_link = 'Aprovar Curso';
            $acao = 'Aprovado';
            $classe_linha = 'text-muted';
            $classe_square = 'text-danger';
        }
    

        //valor formatodo e descrição_longa formatada
        $valorF = number_format($valor, 2, ',', '.', );
        $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema

        echo <<<HTML
    <tr>
        <td>
        <img src="img/cursos/{$foto}" width="27px" class="me-2">
        </td>
        <td class="">{$nome}</td> <!-- repare que <?php echo $nome ?> é substituído aqui por {$nome}-->
        <td class="">R$ {$valorF}</td>
        <td class="">{$nome_professor}</td>
        <td class="">{$nome_categoria}</td>
        <td class="esc">0</td>
        <td class="esc">0</td>

        <td>

        <!-- não tem como editar o professor que registrou o curso -->
		<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$desc_rapida}', '{$desc_longa}' , '{$valor}' , '{$categoria}' , '{$foto}' , '{$carga}' , '{$arquivo}' , '{$ano}' , '{$palavras}' , '{$grupo}' , '{$pacote}', '{$sistema}', '{$link}', '{$tecnologias}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>


		<big><a href="#" onclick="mostrar('{$nome}', '{$desc_rapida}','{$desc_longa}','{$valorF}','{$nome_professor}','{$nome_categoria}','{$foto}','{$status}', '{$carga}', '{$arquivo}', '{$ano}', '{$palavras}', '{$nome_grupo}', '{$pacote}', '{$sistema}', '{$link}', '{$tecnologias}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>


        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2 {$ocultar}" style="display: inline-block;">
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
        
        <!-- ativar/desativar curso -->
		<big><a class="{$acesso}" href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} $classe_square"></i></a></big>


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
    function editar(id, nome, descricao, foto) {

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val(nome);
        $('#descricao').val(descricao);
        //$('#foto').val(foto); //só por ter uma linha a mais não estava abrindo a modal
        $('#foto').val(''); //caminho da foto
        $('#target').attr('src', 'img/categorias/' + foto); //mostra imagem da foto

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }


    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {
        $('#id').val('');
        $('#nome').val('');
        $('#descricao').val('');
        $('#foto').val('');
        $('#target').attr('src', 'img/categorias/sem-foto.png');
    }

</script>