<?php
//alguns servidores, com o da hostgator (mas não o localhost), apresentam um limite de tempo por sessão, deixando-a aberta por 20 a 30 minutos e depois deslogam, isso é para aumentar o tempo da sessão
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();

/* define o prazo do cache em 120 minutos */
session_cache_expire(1200);
$cache_expire = session_cache_expire();

@session_start(); //colocou @ pois se tiver uma sessão já aberta, e abrir uma outra, o php costuma emitir um warning, o @ ignora o warning

require_once('conexao.php');

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$senha_crip = md5($senha);

$query = $pdo->prepare("SELECT * FROM usuarios WHERE (usuario = :usuario OR cpf = :usuario) AND senha_crip = :senha_crip"); //passa a senha criptografada
//sem prepare(), se ele digitasse no campo senha 'or'='', seria o mesmo que incluise na instrução SQL acima o seguinte: OR senha_crip='', e ele entraria sem digitar senha agluma
$query->bindValue(":usuario", $usuario); //bindParam só aceita variáveis, não valores diretos, como no caso do 'Sim' do ativo
$query->bindValue(":senha_crip", $senha_crip);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = count($res);

if($total_reg > 0) {
    //recuperar o nível do usuário
    $_SESSION['nivel'] = $res[0]['nivel'];
    $_SESSION['cpf'] = $res[0]['cpf'];
    $_SESSION['nome'] = $res[0]['nome'];
    $_SESSION['id'] = $res[0]['id'];

    if($_SESSION['nivel'] == 'Administrador') {
        //é possível fazer o redirecionamento por php ou javascript, autor já teve problemas com erro no servidor com redirecionamento por php
        echo "<script> window.location='painel-admin/index.php'</script>";
    } else if ($_SESSION['nivel'] == 'Professor') {
        echo "<script> window.location='painel-admin/index.php'</script>";

    } else if ($_SESSION['nivel'] == 'Aluno') {

    }
} else {
    echo "<script> window.alert('Dados Incorretos!')</script>";
    echo "<script> window.location='index.php'</script>";

}

?>

