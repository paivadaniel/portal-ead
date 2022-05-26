<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'pacotes';

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
    <th class="">Linguagem</th>	
    <th class="esc">Alunos</th>	
    <th class="esc">Cursos</th>	
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
        $promocao = $res[$i]['promocao'];

        $professor = $res[$i]['professor'];
        $linguagem = $res[$i]['linguagem'];
        $foto = $res[$i]['imagem'];
        $ano = $res[$i]['ano'];
        $palavras = $res[$i]['palavras'];
        $grupo = $res[$i]['grupo'];
        $nome_url = $res[$i]['nome_url'];
        $video = $res[$i]['video'];

        $query2 = $pdo->query("SELECT * FROM usuarios WHERE id = '$professor'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_professor = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM linguagens WHERE id = '$linguagem'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_linguagem = $res2[0]['nome'];
        } else {
            $nome_linguagem = 'Sem Registro';
        }

        $query2 = $pdo->query("SELECT * FROM grupos WHERE id = '$grupo'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_grupo = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM cursos_pacotes WHERE id_pacote = '$id'"); //autor criou uma tabela inútil aqui, a cursos_pacotes, não precisa, há um campo pacote na tabela cursos
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $cursos = @count($res2);

        if ($cursos > 0) {
            for ($i2 = 0; $i2 < $cursos; $i2++) {
                foreach ($res2[$i] as $key => $value) {
                }
                $carga = $res2[$i]['carga'];
            }
        } else {
            $carga = 0;

        }

        //valor formatodo e descrição_longa formatada
        $valorF = number_format($valor, 2, ',', '.',);
        $promocaoF = number_format($promocao, 2, ',', '.',);
        $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema

        if($promocao > 0) {
            $promo = ' / ' . $promocaoF;
        } else {
            $promo = '';
        }

        echo <<<HTML

<tr class="">
        <td>
        <img src="img/pacotes/{$foto}" width="27px" class="me-2">
        </td>
        <td class="">
        <a href="#" onclick="cursos('{$id}', '{$nome}', '{$cursos}')" style="text-decoration:none; color:#4f4f4e"> <!-- nome é passado como parâmetro apenas para aparecer na modal -->    
        <!-- se não colocar cerquilha no href, e deixá-lo vazio, não funciona o onclick e daí não chama a modalAulas -->
        {$nome}

    </a>
        </td> <!-- repare que <?php echo $nome ?> é substituído aqui por {$nome}-->
        <td class="">R$ {$valorF} <small><span class="text-danger"><b> {$promo} </b></span></small></td>
        <td class="">{$nome_professor}</td>
        <td class="">{$nome_linguagem}</td>
        <td class="esc">0</td>
        <td class="esc">{$cursos}</td>

        <td>

        <!-- não tem como editar o professor que registrou o curso -->
		<big><a href="#" onclick="editar('{$id}', '{$nome}', '{$desc_rapida}', '{$desc_longa}' , '{$valor}', '{$promocao}', '{$linguagem}' , '{$foto}' , '{$palavras}' , '{$grupo}', '{$video}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>


		<big><a href="#" onclick="mostrar('{$nome}', '{$desc_rapida}', '{$desc_longa}' , '{$valorF}' , '{$promocaoF}', '{$nome_professor}','{$nome_linguagem}', '{$foto}', '{$ano}', '{$palavras}', '{$nome_grupo}', '{$video}', '{$carga}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

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
   
        <!-- criar sessão -->
        <big><a href="#" onclick="cursos('{$id}', '{$nome}', '{$cursos}')" title="Inserir Cursos"><i class="fa fa-book verde"></i></a></big>

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
    function editar(id, nome, desc_rapida, desc_longa, valor, promocao, linguagem, foto, palavras, grupo, video) {

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
        $('#promocao').val(promocao);
        $('#linguagem').val(linguagem).change(); //esse change() é desnecessário para que ele salve a edição no select, funciona sem ele também
        $('#palavras').val(palavras);
        $('#grupo').val(grupo).change(); //esse change() é desnecessário para que ele salve a edição no select, funciona sem ele também

        //$('#foto').val(foto); //só por ter uma linha repita com foto não estava abrindo a modal
        $('#foto').val(''); //caminho da foto
        $('#target').attr('src', 'img/pacotes/' + foto); //mostra imagem da foto

        $('#video').val('video'); //url do vídeo
        $('#target-video').attr('src', video); //video propriamente dito

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    function mostrar(nome, desc_rapida, desc_longa, valor, promocao, professor, linguagem, foto, ano, palavras, grupo, video, carga) {

        $('#nome_mostrar').text(nome);
        $('#desc_rapida_mostrar').text(desc_rapida);
        $('#desc_longa_mostrar').html(desc_longa); //se tiver negrito, aspas e outros caracteres HTML, exibe-os do jeito como foram inseridos
        $('#valor_mostrar').text(valor);
        $('#promocao_mostrar').text(promocao);
        $('#professor_mostrar').text(professor);
        $('#linguagem_mostrar').text(linguagem);
        $('#target_mostrar').attr('src', 'img/pacotes/' + foto);
        $('#ano_mostrar').text(ano);
        $('#palavras_mostrar').text(palavras);
        $('#grupo_mostrar').text(grupo);
        $('#target_video_mostrar').attr('src', video);
        $('#carga_mostrar').text(carga);

        $('#modalMostrar').modal('show');

    }

    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {

        $('#id').val(''); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val('');
        $('#desc_rapida').val('');
        nicEditors.findEditor('area').setContent('');
        $('#valor').val('');
        $('#promocao').val('');
        $('#linguagem').val('');
        $('#palavras').val('');

        $('#foto').val('');
        $('#video').val('');

        $('#target').attr('src', 'img/cursos/sem-foto.png');
        $('#target-video').attr('src', '');

    }

    function cursos(id, nome, cursos) {
        $('#id-pacote').val(id);
        $('#nome_pacote_titulo').text(nome);
        $('#total_cursos').text(cursos);

        $('#modalCursos').modal('show');
        listarCursos();
     }
</script>