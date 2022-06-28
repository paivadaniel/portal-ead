<?php
//alguns servidores, com o da hostgator (mas não o localhost), apresentam um limite de tempo por sessão, deixando-a aberta por 20 a 30 minutos e depois deslogam, isso é para aumentar o tempo da sessão
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* define o prazo do cache em 120 minutos */
session_cache_expire(1200);
$cache_expire = session_cache_expire();

@session_start(); //colocou @ pois se tiver uma sessão já aberta, e abrir uma outra, o php costuma emitir um warning, o @ ignora o warning

require_once('../../sistema/conexao.php');

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);

//verifica se email do aluno existe
$query = $pdo->prepare("SELECT * FROM usuarios WHERE (usuario = :usuario OR cpf = :usuario) and nivel = 'Aluno'");
$query->bindValue(":usuario", $usuario);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if ($total_reg == 0) {
    echo 'Usuário não cadastrado!';
    exit();

}

$query = $pdo->prepare("SELECT * FROM usuarios WHERE (usuario = :usuario OR cpf = :usuario) AND senha_crip = :senha_crip and nivel = 'Aluno'"); //passa a senha criptografada
//login apenas para aluno, não interessa que administradores e professores loguem por aqui
//sem prepare(), se ele digitasse no campo senha 'or'='', seria o mesmo que incluise na instrução SQL acima o seguinte: OR senha_crip='', e ele entraria sem digitar senha agluma
$query->bindValue(":usuario", $usuario); //bindParam só aceita variáveis, não valores diretos, como no caso do 'Sim' do ativo
$query->bindValue(":senha_crip", $senha_crip);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if ($total_reg > 0) {

    if ($res[0]['ativo'] != 'Sim') {

        //não existe mais aqui a devolução por script
        //echo "<script> window.alert('Usuário inativo!')</script>";
        //echo "<script> window.location='index.php'</script>";
        echo 'Usuário inativo!';

        exit();
    }

    //recuperar o nível do usuário
    $_SESSION['nivel'] = $res[0]['nivel'];
    $_SESSION['cpf'] = $res[0]['cpf'];
    $_SESSION['nome'] = $res[0]['nome'];
    $_SESSION['id'] = $res[0]['id'];
    @$_SESSION['id_pessoa'] = $res[0]['id_pessoa'];


    if ($_SESSION['nivel'] == 'Aluno') {
        //echo "<script> window.location='painel-aluno/index.php'</script>";
        echo 'Logado com Sucesso!';
    }
} else {
    echo 'Senha incorreta!';
}
