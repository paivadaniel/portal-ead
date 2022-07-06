<?php

require_once("../../../conexao.php");

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$id_aula = $_POST['id_aula'];
$anterior_proxima_atual_aula = $_POST['aula'];

$query = $pdo->query("SELECT * FROM aulas where id = '$id_aula'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    $id_curso = $res[0]['id_curso'];
    $sessao = $res[0]['sessao']; //recuperado para saber se o curso tem ou não sessão
    $sequencia_aula = $res[0]['sequencia_aula'];

    $nome_aula = $res[0]['nome'];
    $num_aula = $res[0]['numero'];
    $link = $res[0]['link'];
    $id_aula = $res[0]['id']; //id da aula atualizado

    //pegar o nome da sessão
    $query = $pdo->query("SELECT * FROM sessao where id = '$sessao'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

    //está mostrando nome da sessão errado, na primeira aula do módulo 02 está mostrando a sessão como módulo 01 ainda, só está mudando na aula 02 do módulo 02
    if (@count($res) > 0) {
        $nome_sessao = $res[0]['nome'] . ' - ';
    } else {
        $nome_sessao = '';
    }

    //pega o id da matrícula (que será usado para atualizar as aulas concluídas, ou seja, vistas, pelo aluno)
    $query_a = $pdo->query("SELECT * FROM matriculas where id_curso = '$id_curso' and id_aluno = '$id_aluno'");
    $res_a = $query_a->fetchAll(PDO::FETCH_ASSOC);
    $id_matricula = $res_a[0]['id'];
    $aulas_concluidas = $res_a[0]['aulas_concluidas'];

    //verificar total de aulas do curso
    $query_a = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso'");
    $res_a = $query_a->fetchAll(PDO::FETCH_ASSOC);
    $total_aulas = @count($res_a);

    //próxima aula
    if ($anterior_proxima_atual_aula == 'proximo' /*and $num_aula < $total_aulas*/ and $sessao == 0) { //curso sem sessão

        $proxima_aula = $num_aula + 1;

        if ($proxima_aula > $total_aulas) { //afinal de contas, é possível que num_aula seja maior que total_aulas??? como isso pode acontecer?

            $nome_aula = 'Curso Finalizado';
            $num_aula = '';
            $link = '';
            //$id_aula = ''; //id da aula atualizado

            echo 'Curso Finalizado';
            exit();
        }

        if ($aulas_concluidas < $proxima_aula) {
            //atualizar aulas concluidas na matrícula
            $query = $pdo->query("UPDATE matriculas SET aulas_concluidas = '$proxima_aula' where id = '$id_matricula'");
        }



        $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' and numero ='$proxima_aula'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_aula = $res[0]['nome'];
        $num_aula = $res[0]['numero'];
        $link = $res[0]['link'];
        $id_aula = $res[0]['id']; //id da aula atualizado

    }




    if ($anterior_proxima_atual_aula == 'proximo' and $sessao != 0) { //curso com sessão

        $proxima_aula = $sequencia_aula + 1;

        if ($proxima_aula > $total_aulas) { //afinal de contas, é possível que num_aula seja maior que total_aulas??? como isso pode acontecer?

            $nome_aula = 'Curso Finalizado';
            $num_aula = '';
            $link = '';
            //$id_aula = ''; //id da aula atualizado

            echo 'Curso Finalizado';
            exit();
        }

        if ($aulas_concluidas < $proxima_aula) {
            //atualizar aulas concluidas na matrícula
            $query = $pdo->query("UPDATE matriculas SET aulas_concluidas = '$proxima_aula' where id = '$id_matricula'");
        }

        $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' and sequencia_aula ='$proxima_aula'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_aula = $res[0]['nome'];
        $num_aula = $res[0]['numero'];
        $link = $res[0]['link'];
        $id_aula = $res[0]['id']; //id da aula atualizado
        $sessao = $res[0]['sessao'];

        //traz o novo nome da sessão
        $query = $pdo->query("SELECT * FROM sessao where id = '$sessao'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $nome_sessao = $res[0]['nome'] . ' - ';
    }





    if ($anterior_proxima_atual_aula == 'anterior' and $num_aula > 1 and $sessao == 0) {

        /*o if acima continha and $num_aula > 1
porém, o código abaixo em sistema/painel-aluno/paginas/cursos.php.php fez essa linha ser desnecessária, segue qual foi:
					document.getElementById('btn-anterior').style.display = 'none';
*/

        $anterior_aula = $num_aula - 1;

        $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' and numero ='$anterior_aula'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_aula = $res[0]['nome'];
        $num_aula = $res[0]['numero'];
        $link = $res[0]['link'];
        $id_aula = $res[0]['id']; //id da aula atualizado

    }



    if ($anterior_proxima_atual_aula == 'anterior' and $sequencia_aula > 1 and $sessao != 0) {
        //isso é se o curso tiver módulos, o num_aula do módulo 02 vai voltar para 01, já o sequencia_aula é um contador das aulas do curso, e só aumenta conforme os módulos

        $anterior_aula = $sequencia_aula - 1;

        $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_curso' and sequencia_aula ='$anterior_aula'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        $nome_aula = $res[0]['nome'];
        $num_aula = $res[0]['numero'];
        $link = $res[0]['link'];
        $id_aula = $res[0]['id']; //id da aula atualizado
        $sessao = $res[0]['sessao'];

        //traz o novo nome da sessão
        $query = $pdo->query("SELECT * FROM sessao where id = '$sessao'");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $nome_sessao = $res[0]['nome'] . ' - ';
    }

    echo $num_aula . '***' . $nome_aula . '***' . $link . '***' . $id_aula  . '***' . $nome_sessao;
}
