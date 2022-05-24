<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'aulas';
$id_curso = $_POST['id_curso'];
$sessao_sel = @$_POST['sessao_sel']; //sessão selecionada

//listagem de aulas de curso dividido em módulos
$query_m = $pdo->query("SELECT * FROM sessao where id_curso = '$id_curso' ORDER BY id asc");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
$total_reg_m = @count($res_m);
$ultima_aula = 1;

if ($total_reg_m > 0) {
    for ($i_m = 0; $i_m < $total_reg_m; $i_m++) {
        foreach ($res_m[$i_m] as $key => $value) {
        }
        $id_sessao = $res_m[$i_m]['id'];
        $nome_sessao = $res_m[$i_m]['nome'];

        //pegar o id da primeira sessão
        if ($i_m == 0) {
            $primeira_sessao = $res_m[$i_m]['id'];
        }

        echo '<small><b>' . $nome_sessao . '</small></b>';
        echo '<hr>';


        echo <<<HTML
    <small>
    HTML;

        $query = $pdo->query("SELECT * FROM $tabela WHERE id_curso = '$id_curso' AND sessao = '$id_sessao' ORDER BY numero desc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);

        //caso curso só tenha uma aula, será escrito "1 aula", ao invés de "1 aulas"
        if ($total_reg == 1) {
            $quantidade_aulas = 'aula';
        } else {
            $quantidade_aulas = 'aulas';
        }

        if ($total_reg > 0) { //cria a tabela

            if ($sessao_sel == "undefined" || $sessao_sel == 0) {
                $sessao_sel = $primeira_sessao;
            }

            $query2 = $pdo->query("SELECT * FROM $tabela WHERE id_curso = '$id_curso' AND sessao = '$sessao_sel' ORDER BY numero desc");
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            $total_reg2 = @count($res2);

            $ultima_aula = $res[0]['numero'] + 1;

            //pegar a última aula cadastrada e somar um para incrementar o número da próxima aula a inserir

            echo <<<HTML
    
    <table class="table table-hover"> <!-- removeu id="tabela" pois não iremos usar DataTable nessa tabela, veja em listar.php que para usar DataTable (script do final) referenciamos o elemento com id="tabela" -->
        <thead> 
        <tr> 
        <th class="">Aula</th>
        <th class="">Nome</th>	
        <th class="esc">Link</th>	
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
                $link = $res[$i]['link'];
                $numero = $res[$i]['numero'];
                $sessao = $res[$i]['sessao'];

                $linkF = mb_strimwidth($link, 0, 15, "..."); //defino quantos caracteres do link quero mostrar, e a partir desse número até o final terá "..."

                echo <<<HTML
        <tr>
            <td class="">{$numero}</td>
            <td class="">{$nome}</td>
            <td class="esc"><a href="{$link}" title="{$link}" target="_blank">{$linkF}</a></td>
            <td>
    
            <big><a href="#" onclick="editarAulas('{$id}', '{$numero}', '{$nome}', '{$link}', '{$sessao}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
            
            <!-- abertura excluir -->
            <li class="dropdown head-dpdn2" style="display: inline-block;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>
    
            <ul class="dropdown-menu" style="margin-left:-230px;">
            <li>
            <div class="notification_desc2">
            <p>Confirmar Exclusão? <a href="#" onclick="excluirAulas('{$id}')"><span class="text-danger">Sim</span></a></p>
            </div>
            </li>										
            </ul>
            </li>
            <!-- fechamento excluir -->
            
        </td>
    
    
        </tr>
    
    HTML;
            }

            echo <<<HTML
        </tbody>
        <small><div align="center" id="mensagem_aula"></div></small>
        </table>	
        HTML;
        } else {
            echo 'Nenhum registro cadastrado <br><br>';
        }

        echo <<<HTML
    </small>
    HTML;
    }
} else { //listagem de aulas de curso NÃO DIVIDIDO em módulos (quando um curso não tiver sessões)

    echo <<<HTML
    <small>
    HTML;

    $query = $pdo->query("SELECT * FROM $tabela WHERE id_curso = '$id_curso' ORDER BY numero desc");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    $ultima_aula = 1;

    //caso curso só tenha uma aula, será escrito "1 aula", ao invés de "1 aulas"
    if ($total_reg == 1) {
        $quantidade_aulas = 'aula';
    } else {
        $quantidade_aulas = 'aulas';
    }

    if ($total_reg > 0) { //cria a tabela    

        $ultima_aula = $res[0]['numero'] + 1;

        echo <<<HTML
    
    <table class="table table-hover"> <!-- removeu id="tabela" pois não iremos usar DataTable nessa tabela, veja em listar.php que para usar DataTable (script do final) referenciamos o elemento com id="tabela" -->
        <thead> 
        <tr> 
        <th class="">Aula</th>
        <th class="">Nome</th>	
        <th class="esc">Link</th>	
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
            $link = $res[$i]['link'];
            $numero = $res[$i]['numero'];
            $sessao = $res[$i]['sessao'];


            $linkF = mb_strimwidth($link, 0, 15, "..."); //defino quantos caracteres do link quero mostrar, e a partir desse número até o final terá "..."

            echo <<<HTML
        <tr>
            <td class="">{$numero}</td>
            <td class="">{$nome}</td>
            <td class="esc"><a href="{$link}" title="{$link}" target="_blank">{$linkF}</a></td>
            <td>
    
            <big><a href="#" onclick="editarAulas('{$id}', '{$numero}', '{$nome}', '{$link}', '{$sessao}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
            
            <!-- abertura excluir -->
            <li class="dropdown head-dpdn2" style="display: inline-block;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>
    
            <ul class="dropdown-menu" style="margin-left:-230px;">
            <li>
            <div class="notification_desc2">
            <p>Confirmar Exclusão? <a href="#" onclick="excluirAulas('{$id}')"><span class="text-danger">Sim</span></a></p>
            </div>
            </li>										
            </ul>
            </li>
            <!-- fechamento excluir -->
            
        </td>
    
    
        </tr>
    
    HTML;
        }

        echo <<<HTML
        </tbody>
        <small><div align="center" id="mensagem_aula"></div></small>
        </table>	
        HTML;
    } else {
        echo 'Nenhum registro cadastrado <br><br>';
    }

    echo <<<HTML
    </small>
    HTML;
}


?>

<script type="text/javascript">
    function editarAulas(id, numero, nome, link, sessao) {

        $('#id_aula').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#numero_aula').val(numero);
        $('#nome_aula').val(nome);
        $('#link_aula').val(link);

        $('#sessao_curso').val(sessao);


    }

    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCamposAulas() {
        $('#id_aula').val('');
        $('#nome_aula').val('');
        $('#link_aula').val('');
        $('#sessao_curso').val('');
        $('#target-video').attr('src', ''); //é um campo iframe, portanto, não dá para limpar usando val('')


        $('#numero_aula').val('<?= $ultima_aula ?>');
        $('#aulas_aula').text('<?= $total_reg ?>');
        $('#aulas_singular_plural').text('<?= $quantidade_aulas ?>');

    }

    function excluirAulas(id) {
        $.ajax({
            url: 'paginas/' + pag + "/excluir-aulas.php",
            method: 'POST',
            data: {
                id
            },
            dataType: "text",

            success: function(mensagem) {
                if (mensagem.trim() == "Excluído com Sucesso") {
                    listarAulas();
                } else {
                    $('#mensagem_aula').addClass('text-danger')
                    $('#mensagem_aula').text(mensagem)
                }

            },

        });
    }
</script>