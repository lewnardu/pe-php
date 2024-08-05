<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!empty($_SESSION['cpf'])){
    define('FPDF_FONTPATH', 'font/');
    require('fpdf/fpdf.php');
    include_once("conexao.php");

    $nome = $_SESSION['nome'];
    $mesDoExtra = $_GET['matricula'];

    $sql= "SELECT * FROM aep WHERE funcional='".$mesDoExtra."'";
    $busca = mysqli_query($conexao, $sql);
    $result = mysqli_fetch_array($busca);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->AddFont('Arial','','arial.ttf',true);

    $pdf->Image('imagens/logoX.png',10,10,190,30,'PNG');

    $pdf->ln(45); 
    $pdf->Cell(190,20,utf8_decode('COMPROVANTE DE MANIFESTAÇÃO DE DISPONIBILIDADE'),0,0,"C");
    $pdf->ln(25);
    $pdf->Cell(190,20,utf8_decode('INFORMAÇÕES DO POLICIAL PENAL'),0,0,"C");
    $pdf->ln(25);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(100,10, utf8_decode('MATRÍCULA FUNCIONAL:'),0,0,'C');
    $pdf->Cell(100,10, $result['funcional'] ,0,0,'LR');
    $pdf->ln(6);
    $pdf->Cell(100,10, utf8_decode('NOME COMPLETO:'),0,0,'C');
    $pdf->Cell(100,10, utf8_decode($result['nome']),0,0,'LR');
    $pdf->ln(12);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(190,20,utf8_decode('INFORMAÇÕES DA DISPONIBILIDADE'),0,0,"C");

    $pdf->SetFont('Arial','B',10);
    $pdf->ln(25);
    $pdf->Cell(100,10, utf8_decode('MÊS DISPONÍVEL PARA EXTRA:'),0,0,'C');
    //$pdf->Cell(100,10, (date('m')+1).'/'.date(Y) ,0,0,'LR');
    //$pdf->Cell(100,10, $dt +1 ,0,0,'LR');
    $data = new DateTime();
    if($data >= DateTime::createFromFormat('Y-m-d H:i:s', "2023-07-13 13:00:00") and $data <= DateTime::createFromFormat('Y-m-d H:i:s', "2023-07-14 23:59:59")) {
        $pdf->Cell(100,10, '07/2023 - Disponibilidade Complentar' ,0,0,'LR');
    }else {
        $data->modify("+1 month");
        $pdf->Cell(100,10, $data->format('m/Y') ,0,0,'LR');
    }
    $pdf->ln(6);
    $pdf->Cell(100,10, utf8_decode('UNIDADE DE PREFERÊNCIA: '),0,0,'C');
    $pdf->Cell(100,10, utf8_decode($result['preferencia']) ,0,0,'LR');
    $pdf->ln(6);
    $pdf->Cell(100,10, 'DATA E HORA DO REGISTRO:',0,0,'C');
    $pdf->Cell(100,10, $result['carimbo'] ,0,0,'LR');

    //$codigo = password_hash($result['carimbo'].':'.$result['carimbo'], PASSWORD_DEFAULT);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(100,10,("Gerado ".date('H:i d-m-Y ')) ,0,0,"C");
    $pdf->ln(55);
    $pdf->Cell(190,20,utf8_decode('Código de Autenticidade'),0,0,"C");
    $pdf->ln(6);
    //$pdf->Cell(190,20,md5($result['carimbo'].$result['carimbo']),0,0,"C");
    $pdf->Cell(190,20, $result['codigo'],0,0,"C");
    $pdf->ln(15);
    $pdf->Cell(190,20,'SGT - 2024',0,0,"C");
    //$pdf->Image('imagens/logoEES.png',45,260,120,35,'PNG');

    $pdf->Output('I', $nome."_".$mesDoExtra.".pdf");

}else{
	$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario n�o logado!</div>";
	header("Location: index.php");
} 
?>