<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'usuarios';

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
    <th class="esc"></th>
	<th>Nome</th>
    <th class="">Email</th> 
    <th class="">Senha</th> 
    <th class="esc">CPF</th>	
    <th class="esc">Nível</th>	
    <th class="esc">Cadastro</th>	
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $nome = $res[$i]['nome'];
        $email = $res[$i]['usuario'];
        $cpf = $res[$i]['cpf'];
        $data = $res[$i]['data'];
        $senha = $res[$i]['senha'];
        $foto = $res[$i]['foto'];
        $ativo = $res[$i]['ativo'];
        $nivel = $res[$i]['nivel'];


        $dataF = implode('/', array_reverse(explode('-', $data)));

        if($nivel == 'Administrador') {
            $senha = '***';
        }

        if($ativo == 'Sim'){//recuperou $res[$i]['ativo'] apenas para esse if
			$classe_linha = '';
		}else{			
			$classe_linha = 'text-muted';
		}

echo <<<HTML
    <tr class="{$classe_linha}">
        <td class="esc">
        <img src="img/perfil/{$foto}" width="27px" class="me-2">
        </td>
        <td class="">{$nome}</td> <!-- repare que <?php echo $nome ?> é substituído aqui por {$nome}-->
        <td class="">{$email}</td>
        <td class="">{$senha}</td>
        <td class="esc">{$cpf}</td>
        <td class="esc">{$nivel}</td>
        <td class="esc">{$dataF}</td>


    </tr>

HTML;
    }

    echo <<<HTML
    </tbody>
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

</script>