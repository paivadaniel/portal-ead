<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cursos';

@session_start();

if ($_SESSION['nivel'] == 'Administrador') {
    $acesso = '';
    $id_usuario = '%' . '' . '%';
} else { // se um professor estiver acessando a página
    $acesso = 'ocultar';
    $id_usuario = '%' . $_SESSION['id'] . '%'; //o porcento antes e depois é uma obrigatoriedade do LIKE, para que busque por aproximações no começo e no final do que se procura
}

echo <<<HTML
<small>
HTML;

//se id_usuario = '', ou seja, for vazio, neste caso o acesso é de um administrador, e traz todos os cursos, assim o LIKE é ignorado, se id_usuario = $_SESSION['id'], por exemplo, 2, traz o id apenas daquele usuário 
$query = $pdo->query("SELECT * FROM $tabela WHERE professor LIKE '$id_usuario' ORDER BY id desc");
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
        $nome_professor = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM categorias WHERE id = '$categoria'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_categoria = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM grupos WHERE id = '$grupo'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_grupo = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM aulas WHERE id = '$id'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $aulas = @count($res2);

        if ($status == 'Aprovado') {
            $excluir = 'ocultar'; //cursos aprovados não podem ser excluidos
            $icone = 'fa-check-square';
            $titulo_link = 'Desaprovar Curso';
            $acao = 'Aguardando'; //ação é o contrário, se está aprovado, e for clicado, a ação é mudar para 'Aguardando'
            $classe_linha = '';
            $classe_square = 'verde';
        } else {
            $excluir = '';
            $icone = 'fa-square-o';
            $titulo_link = 'Aprovar Curso';
            $acao = 'Aprovado';
            $classe_linha = 'text-muted';
            $classe_square = 'text-danger';
        }

        if ($mensagem != '') {
            $classe_mensagem = 'warning';
            $icone2 = 'fa-comment';
        } else {
            $classe_mensagem = 'text-warning';
            $icone2 = 'fa-comment-o';
        }

        //valor formatodo e descrição_longa formatada
        $valorF = number_format($valor, 2, ',', '.',);
        $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema

        echo <<<HTML

<tr class="{$classe_linha}">
        <td>
        <img src="img/cursos/{$foto}" width="27px" class="me-2">


        </td>
        <td class="">
        <a href="#" onclick="aulas('{$id}', '{$nome}', '{$aulas}')" style="text-decoration:none; color:#4f4f4e"> <!-- nome é passado como parâmetro apenas para aparecer na modal -->    
        <!-- se não colocar cerquilha no href, e deixá-lo vazio, não funciona o onclick e daí não chama a modalAulas -->
        {$nome}

      <i class="fa fa-video-camera text-danger"></i>  <!-- classe text-primary dava quebra de linha, trocou para text-danger -->

    </a>
        </td> <!-- repare que <?php echo $nome ?> é substituído aqui por {$nome}-->
        <td class="">R$ {$valorF}</td>
        <td class="">{$nome_professor}</td>
        <td class="">{$nome_categoria}</td>
        <td class="esc">0</td>
        <td class="esc">{$aulas}</td>

        <td>

        <!-- não tem como editar o professor que registrou o curso -->
		<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$desc_rapida}', '{$desc_longa}' , '{$valor}' , '{$categoria}' , '{$foto}' , '{$carga}' , '{$arquivo}' , '{$ano}' , '{$palavras}' , '{$grupo}' , '{$pacote}', '{$sistema}', '{$link}', '{$tecnologias}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>


		<big><a href="#" onclick="mostrar('{$nome}', '{$desc_rapida}', '{$desc_longa}' , '{$valorF}' , '{$nome_professor}' ,'{$nome_categoria}' , '{$foto}' , '{$status}', '{$carga}' , '{$arquivo}' , '{$ano}' , '{$palavras}' , '{$nome_grupo}' , '{$pacote}', '{$sistema}', '{$link}', '{$tecnologias}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>


        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2 {$excluir}" style="display: inline-block;">
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

        <!-- mostrar observações -->
        <big><a href="#" onclick="obs('{$id}', '{$nome}', '{$mensagem}')" title="Ver Mensagens"><i class="fa {$icone2} {$classe_mensagem}"></i></a></big>

    </td>


    </tr>

HTML;
    } //fechamento do for

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
    function editar(id, nome, desc_rapida, desc_longa, valor, categoria, foto, carga, arquivo, ano, palavras, grupo, pacote, sistema, link, tecnologias) {

        //para cada caracter de descrição longa, se for um asterico, ele substituirá dois astericos por uma aspas
        for (let letra of desc_longa) {
            if (letra === '*') {
                desc_longa = desc_longa.replace('**', '"');
            }
        }

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val(nome);
        $('#desc_rapida').val(desc_rapida);
        nicEditors.findEditor("area").setContent(desc_longa); //aqui não é mais saveContent()
        $('#valor').val(valor);
        $('#categoria').val(categoria).change(); //esse change() é desnecessário para que ele salve a edição no select, funciona sem ele também
        $('#carga').val(carga);
        $('#arquivo').val(arquivo);
        $('#ano').val(ano);
        $('#palavras').val(palavras);
        $('#grupo').val(grupo).change(); //esse change() é desnecessário para que ele salve a edição no select, funciona sem ele também
        $('#pacote').val(pacote);
        $('#sistema').val(sistema).change(); //esse change() é desnecessário para que ele salve a edição no select, funciona sem ele também
        $('#link').val(link);
        $('#tecnologias').val(tecnologias);

        //$('#foto').val(foto); //só por ter uma linha repita com foto não estava abrindo a modal
        $('#foto').val(''); //caminho da foto
        $('#target').attr('src', 'img/cursos/' + foto); //mostra imagem da foto

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    function mostrar(nome, desc_rapida, desc_longa, valor, professor, categoria, foto, status, carga, arquivo, ano, palavras, grupo, pacote, sistema, link, tecnologias) {

        $('#nome_mostrar').text(nome);
        $('#desc_rapida_mostrar').text(desc_rapida);
        $('#desc_longa_mostrar').html(desc_longa); //se tiver negrito, aspas e outros caracteres HTML, exibe-os do jeito como foram inseridos
        $('#valor_mostrar').text(valor);
        $('#professor_mostrar').text(professor);
        $('#categoria_mostrar').text(categoria);
        $('#status_mostrar').text(status);
        $('#carga_mostrar').text(carga);
        $('#arquivo_mostrar').text(arquivo);
        $('#ano_mostrar').text(ano);
        $('#palavras_mostrar').text(palavras);
        $('#pacote_mostrar').text(pacote);
        $('#grupo_mostrar').text(grupo);
        $('#link_mostrar').text(link);
        $('#tecnologias_mostrar').text(tecnologias);

        $('#target_mostrar').attr('src', 'img/cursos/' + foto);
        $('#link_pacote').attr('href', '<?= $url_sistema ?>' + pacote); //no javascript, para chamar php, troca 'php' por '='
        $('#link_arquivo').attr('href', '<?= $url_sistema ?>' + arquivo);
        $('#link_curso').attr('href', '<?= $url_sistema ?>' + link);

        $('#modalMostrar').modal('show');

    }

    function obs(id, nome, mensagem) {

        $('#id_mensagem').val(id); //id_mensagem é um input, portanto usa val, de value, e não text
        $('#nome_mensagem').text(nome);
        nicEditors.findEditor('mensagem_mensagem').setContent(mensagem);

        $('#modalMensagem').modal('show');

    }



    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {

        $('#id').val(''); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val('');
        $('#desc_rapida').val('');
        nicEditors.findEditor('area').setContent('');
        $('#valor').val('');
        $('#carga').val('');
        $('#arquivo').val('');
        $('#palavras').val('');
        $('#pacote').val('');
        $('#link').val('');
        $('#tecnologias').val('');


        $('#foto').val('');
        $('#target').attr('src', 'img/cursos/sem-foto.png');
    }

    function aulas(id, nome, aulas) {
        $('#id_aula').val(id);
        $('#nome_aula').text(nome);
        $('#aulas_aula').text(aulas);

        $('#modalAulas').modal('show');
        listarAulas();



    }
</script>