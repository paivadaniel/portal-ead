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

$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];

$html = utf8_encode(file_get_contents("http://localhost/dashboard/www/portal-ead/sistema/rel/lucro.php?dataInicial=$dataInicial&dataFinal=$dataFinal"));

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait'); //ou portrait

//CARREGAR O CONTEÚDO HTML
$pdf->load_html(utf8_decode($html)); //carrega o html na classe do dom pdf

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
'lucro.pdf',
array("Attachment" => false) //se deixar true, baixa o arquivo, se false exibe o arquivo e tem a opção de depois salvar ou imprimir
);




?>