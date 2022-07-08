<?php 

//DOMPDf é uma biblioteca que gera pdf para PDF
//é composto por 2 arquivos, o que inicia com 'rel_' é a que faz a chamada da classe, e o outro é que tem o HTML e o CSS do relatório pdf 

include('../conexao.php');

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

//para trabalhar com imagens no DOMPDF precisa das três linhas abaixo
use Dompdf\Options;
header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$pdf = new DOMPDF($options);

$id_mat = $_POST['id_mat']; //vem de sistema/painel-aluno/paginas/cursos/listar-cursos.php

//ALIMENTAR OS DADOS NO RELATÓRIO
//a função php file_get_contents pode vir desabilitada em servidores ruins, para liberar essa função deve ser habilitado o recurso allow_frp_url_open, provavelmente no php.ini
//é necessário passar o caminho todo, não apenas a partir da pasta em que se está
//recebe id_mat (id da matrícula) via GET

//não deu certo não sei porque, url_sistema está errada
//$html = utf8_encode(file_get_contents($url_sistema."sistema/rel/certificado.php?id_mat=".$id_mat));

$html = utf8_encode(file_get_contents("http://localhost/dashboard/www/portal-ead/sistema/rel/certificado.php?id_mat=".$id_mat));




//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'landscape'); //ou portrait

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html)); //carrega o html na classe do dom pdf

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'certificado.pdf',
array("Attachment" => false) //se deixar true, baixa o arquivo, se false exibe o arquivo e tem a opção de depois salvar ou imprimir
);




?>