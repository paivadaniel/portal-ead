<?php
/*
listar.php é chamado na function listar(), que está em "../../js/ajax.js",
que por sua vez é chamado em toda página que tem incluído <script src="js/ajax.js"></script>
como "../cursos.php"

*/

require_once("../../../conexao.php");
$tabela = 'matriculas';

//vem de matriculas_aprovadas.php
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];

echo <<<HTML
<small>
HTML;

//só mostra os cursos
$query = $pdo->query("SELECT * FROM $tabela WHERE (status = 'Matriculado' or status = 'Finalizado')and data >= '$dataInicial' and data <= '$dataFinal' ORDER BY data desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th class="">Curso</th>
	<th class="esc">Professor</th>
    <th class="esc">Aluno</th>	
    <th class="">Email</th>	
    <th class="">Subtotal</th>	
    <th class="esc">Data</th>	
    <th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }
        $id_mat = $res[$i]['id']; //id da matrícula
        $id_curso = $res[$i]['id_curso'];
        $id_professor = $res[$i]['id_professor'];
        $id_aluno = $res[$i]['id_aluno'];
        $subtotal = $res[$i]['subtotal']; //pega subtotal e não valor, pois pode ter sido aplicado um cupom sobre o valor do curso
        $data = $res[$i]['data'];
        $obs = $res[$i]['obs'];
        $aulas_concluidas = $res[$i]['aulas_concluidas'];
        $status = $res[$i]['status'];

        $pacote = $res[$i]['pacote']; //se 'Sim' é pacote, se 'Não' é curso

        if($pacote == 'Sim'){
            $tabela2 = 'pacotes';
    
            $item_curso = ' (Pacote)';
            $classe_curso = 'text-primary';	
            $concluir_aulas = 'ocultar';
                
        }else{
            $tabela2 = 'cursos';
            $item_curso = '';
            $classe_curso = '';	
            $concluir_aulas = '';	
    
            $query2 = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso'");
            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
            $aulas = @count($res2);

            if($status == 'Finalizado'){
                $classe_curso = 'text-success';
            }else{
                $classe_curso = 'text-danger';
            }
            
            $item_curso = ' ('.$aulas_concluidas.'/'.$aulas.')';
    
        }

        $query2 = $pdo->query("SELECT * FROM $tabela2 WHERE id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_curso = $res2[0]['nome'];

        //as duas queries a seguir buscam obter nome_professor
        $query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_professor' and nivel = 'Administrador'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        if (@count($res2) > 0) { //criador do curso é um administrador
            $nome_professor = $res2[0]['nome'];
        }

        $query2 = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_professor' and nivel = 'Professor'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        if (@count($res2) > 0) { //criador do curso é um professor
            $nome_professor = $res2[0]['nome'];
        }

        //obter nome e email do aluno
        $query2 = $pdo->query("SELECT * FROM usuarios WHERE id_pessoa = '$id_aluno' and nivel = 'Aluno'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_aluno = $res2[0]['nome'];
        $email_aluno = $res2[0]['usuario'];

        //valor formatado e descrição_longa formatada
        $subtotalF = number_format($subtotal, 2, ',', '.');
        $dataF = implode('/', array_reverse(explode('-', $data)));

        echo <<<HTML

<tr>
    
<!-- quando o curso estiver pago oculta a mensagem de pagar com a classe ocultar_pagar
e quando o curso não estiver pago oculta o link que chama a função aulas -->
        <td>
        <i class="fa fa-square verde" style="margin-right:3px"></i> {$nome_curso}
        <span class="{$classe_curso}">{$item_curso}</span>		

        </td>
        <td class="esc">{$nome_professor}</td>
        <td class="esc">{$nome_aluno}</td>
        <td class="">{$email_aluno}</td>

        <td class="">R$ {$subtotalF}</td>

        <td class="esc">{$dataF}</td>
        <td>

        <!-- abertura excluir -->
        <!-- autor mudou o display de inline-block para flex pois estava afetando no posicionamento do ícone de certificado e de avaliação, mesmo o excluir ficando oculto-->
        <li class="dropdown head-dpdn2" style="display: inline-block; margin-right:3px">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id_mat}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>

		</li>
        <!-- fechamento excluir -->
   

        <!-- abertura concluir aulas -->


        <!-- concluir_aulas tem que colocar como class da li (linha) e do a (link) -->
        <li class="dropdown head-dpdn2 {$concluir_aulas}" style="display: inline-block; margin-right:3px">
		<a href="#" class="dropdown-toggle {$concluir_aulas}" data-toggle="dropdown" aria-expanded="false" title="Concluir Aulas"><big><i class="fa fa-check-circle-o text-primary"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Concluir Aulas para o Certificado? <a href="#" onclick="concluir('{$id_mat}', '{$id_curso}',)"><span class="verde">Sim</span></a></p>
		</div>
		</li>										
		</ul>

		</li>

        <!-- fechamento concluir aulas -->


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



    function concluir(id_mat, id_curso){
    $.ajax({
        url: 'paginas/' + pag + "/concluir.php",
        method: 'POST',
        data: {id_mat, id_curso},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Concluído com Sucesso") {                
                listar();                
            } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

        },      

    });
}

</script>


