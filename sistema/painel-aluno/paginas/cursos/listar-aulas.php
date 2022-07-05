<?php

require_once("../../../conexao.php");
$tabela = 'aulas';

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$id_curso = $_POST['id_curso'];
$id_matricula = $_POST['id_matricula'];

//verificar se aluno está matriculado no curso
$query = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_curso' and id_aluno = '$id_aluno' and status != 'Aguardando'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if(@count($res) == 0) {
    echo 'Você não está matriculado nesse curso!';
    exit();
}

//aulas concluídas pelo aluno
$query = $pdo->query("SELECT * FROM matriculas where id = '$id_matricula'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aulas_concluidas = $res[0]['aulas_concluidas'];

//link dos arquivos do curso
$query = $pdo->query("SELECT * FROM cursos where id = '$id_curso'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$link_arquivo = $res[0]['arquivo'];

//na verdade ele está em painel-aluno/index.php, pois cursos.php abre dentro de index.php, e no final de cursos.php está js/ajax.js que chama listar.php e esse chama listar-aulas.php
echo '<a href="'.$link_arquivo.'" target="_blank" class="cor_aula link-aula"><b><p><img src="img/rar.png" width="20px"><small> Arquivos do Curso</small></p></b><hr style="margin:10px"></a>';

$query_m = $pdo->query("SELECT * FROM sessao where id_curso = '$id_curso' ORDER BY id asc");
$res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
$total_reg_m = @count($res_m);

if ($total_reg_m > 0) { //para curso que tem sessão

    $primeira_sessao = $res_m[0]['id']; //se tiver sessão

    for ($i_m = 0; $i_m < $total_reg_m; $i_m++) {
        foreach ($res_m[$i_m] as $key => $value) {
        }
        $sessao = $res_m[$i_m]['id'];
        $nome_sessao = $res_m[$i_m]['nome'];


        echo '<b><p class="titulo-curso"><small>'.$nome_sessao.'</small></p></b>';


        $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' and sessao = '$sessao' ORDER BY numero asc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);

        if ($total_reg > 0) {

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }
                $id_aula = $res[$i]['id'];
                $nome_aula = $res[$i]['nome'];
                $num_aula = $res[$i]['numero'];
                $sessao_aula = $res[$i]['sessao'];
                $link = $res[$i]['link'];
                $seq_aula = $res[$i]['sequencia_aula'];

                /*isso só funciona se o módulo 1 tiver, por exemplo, 20 aulas, e o módulo 2 começar a partir da aula 21, se não, vai mostrar ($num_aula <= $aulas_concluidas) aulas de cada módulo para abrir
                */
                if($seq_aula <= $aulas_concluidas) {
                    $cor_aula = 'cor_aula';
                } else {
                    $cor_aula = 'text-muted';
                }

echo <<<HTML
                    <a href="#" onclick="abrirAula('{$id_aula}', 'aula', '{$nome_sessao}')" title="Ver Aula" class="link-aula">
                    <i class="fa fa-video-camera {$cor_aula}"></i> <span class="{$cor_aula}">Aula {$num_aula} - {$nome_aula}</span> <br>
                    </a>
HTML;
            }
        } else {
            echo '<span class="neutra">Nenhuma aula Cadastrada</span>';
        }

        echo '<hr>';
    }
} else { //para curso que não tem sessão

    $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' ORDER BY numero asc");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);

    if ($total_reg > 0) {

        for ($i = 0; $i < $total_reg; $i++) {
            foreach ($res[$i] as $key => $value) {
            }
            $id_aula = $res[$i]['id'];
            $nome_aula = $res[$i]['nome'];
            $num_aula = $res[$i]['numero'];
            $link = $res[$i]['link'];

            if($num_aula <= $aulas_concluidas) {
                $cor_aula = 'cor_aula';
            } else {
                $cor_aula = 'text-muted';
            }

echo <<<HTML
                    <a href="#" onclick="abrirAula('{$id_aula}', 'aula', '')" title="Ver Aula" class="link-aula"> <!-- passa vazio pois não tem sessão, portanto, nome_sessao é vazio -->
                    <i class="fa fa-video-camera {$cor_aula}"></i> <span class="{$cor_aula}">Aula {$num_aula} - {$nome_aula}</span> <br>
                    </a>

HTML;

        }
    } else {
        echo '<span class="neutra">Nenhuma aula Cadastrada</span>';
    }
}

?>