<?php

require_once('../conexao.php');

$nome_sistema = $_POST['nome_sistema'];
$email_sistema = $_POST['email_sistema'];
$tel_sistema = $_POST['tel_sistema'];
$cnpj_sistema = $_POST['cnpj_sistema'];
$tipo_chave_pix_sistema = $_POST['tipo_chave_pix_sistema'];
$chave_pix = $_POST['chave_pix'];
$facebook_sistema = $_POST['facebook_sistema'];
$instagram_sistema = $_POST['instagram_sistema'];
$youtube_sistema = $_POST['youtube_sistema'];
$itens_pag = $_POST['itens_pag'];
$video_sobre = $_POST['video_sobre'];


//script para subir foto no servidor
//logo
$caminho = '../img/logo.png'; //substitui a outra logo na pasta de imagens
$imagem_temp = @$_FILES['logo']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
    $ext = pathinfo(@$_FILES['foto']['name'], PATHINFO_EXTENSION);
    if ($ext == 'png') {

        move_uploaded_file($imagem_temp, $caminho);
    } else {
        echo 'A extensão de imagem permitida para a logo é somente .png!';
        exit();
    }
}

//favicon
$caminho = '../img/favicon.ico'; //substitui a outra logo na pasta de imagens
$imagem_temp = @$_FILES['favicon']['tmp_name'];

if (@$_FILES['favicon']['name'] != "") {
    $ext = pathinfo(@$_FILES['favicon']['name'], PATHINFO_EXTENSION);
    if ($ext == 'ico') {

        move_uploaded_file($imagem_temp, $caminho);
    } else {
        echo 'A extensão de imagem permitida para o favicon é somente .ico!';
        exit();
    }
}

//imagem relatório
$caminho = '../img/logo_rel.jpg'; //substitui a outra logo na pasta de imagens
$imagem_temp = @$_FILES['imgRel']['tmp_name'];

if (@$_FILES['imgRel']['name'] != "") {
    $ext = pathinfo(@$_FILES['imgRel']['name'], PATHINFO_EXTENSION);
    if ($ext == 'jpg') {

        move_uploaded_file($imagem_temp, $caminho);
    } else {
        echo 'A extensão de imagem permitida para a logo do relatório é somente .jpg!';
        exit();
    }
}

//imagem pix
$caminho = '../img/qrcode.jpg'; //substitui a outra logo na pasta de imagens
$imagem_temp = @$_FILES['imgQRCode']['tmp_name'];

if (@$_FILES['imgQRCode']['name'] != "") {
    $ext = pathinfo(@$_FILES['imgQRCode']['name'], PATHINFO_EXTENSION);
    if ($ext == 'jpg') {

        move_uploaded_file($imagem_temp, $caminho);
    } else {
        echo 'A extensão de imagem permitida para a imagem do QR Code é somente .jpg!';
        exit();
    }
}

//atualiza a tabela config
$query = $pdo->prepare("UPDATE config SET nome_sistema = :nome_sistema, email_sistema = :email_sistema, tel_sistema = :tel_sistema, cnpj_sistema = :cnpj_sistema, tipo_chave_pix = '$tipo_chave_pix_sistema', chave_pix = :chave_pix, logo = 'logo.png', icone = 'favicon.ico', logo_rel = 'logo_rel.jpg', qrcode_pix = 'qrcode.jpg', facebook = :facebook, instagram = :instagram, youtube = :youtube, itens_pag = '$itens_pag', video_sobre = :video_sobre");

//não fez bindValue para inputs de select (tipo_chave_pix) e img (logo, icone, logo_rel e qrcode_pix), no caso não precisa para itens_pag e tipo_chave_pix_sistema, já que não há como injetar informações nesses campos
$query->bindValue(':nome_sistema', $nome_sistema);
$query->bindValue(':email_sistema', $email_sistema);
$query->bindValue(':tel_sistema', $tel_sistema);
$query->bindValue(':cnpj_sistema', $cnpj_sistema);
$query->bindValue(':chave_pix', $chave_pix);
$query->bindValue(':facebook', $facebook_sistema);
$query->bindValue(':instagram', $instagram_sistema);
$query->bindValue(':youtube', $youtube_sistema);
$query->bindValue(':video_sobre', $video_sobre);

$query->execute();

echo 'Editado com Sucesso!';

?>