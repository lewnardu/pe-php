<?php
session_start();
if (!empty($_SESSION['cpf'])) {
	define('FPDF_FONTPATH', 'font/');
	require('fpdf/fpdf.php');
	include_once("escala/conexao.php");

	$nome = $_SESSION['nome'];
	$mesDoExtra = isset($_POST['mesDoExtra']) ? $_POST['mesDoExtra'] : false;

	if ($mesDoExtra) {
		$data_inicial = date("Y-m-d", strtotime($mesDoExtra));
		$data_final = date_format(date_modify(date_create($data_inicial), '+1 month'), 'Y-m-d');
		$sql = "SELECT * FROM extra WHERE nome='" . $nome . "' and inicio>='" . $data_inicial . "' and inicio<'" . $data_final . "' order by inicio";

		$busca = mysqli_query($conexao, $sql);
		$result = mysqli_fetch_array($busca);

		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);

		//exibir imagem no pdf
		$pdf->Image('imagens/logoE.png', 10, 10, 190, 40, 'PNG');

		$pdf->ln(55); // espa�amento entra linhas de 15 mm
		$pdf->Cell(190, 20, utf8_decode('PLANTÃO EXTRA'), 0, 0, "C");
		$pdf->ln(25); // espa�amento entra linhas de 15 mm
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(100, 10, utf8_decode($nome), 0, 0, "C");
		$pdf->Cell(100, 10, $_SESSION['cpf'], 0, 0, "C");


		$pdf->ln(15); // espa�amento entra linhas de 15 mm
		//$pdf->setFillColor(0,0,0);
		$pdf->Cell(100, 7, 'UNIDADE', 1, 0, "C");
		$pdf->Cell(20, 7, 'CH', 1, 0, "C");
		$pdf->Cell(35, 7, 'DATA', 1, 0, "C");
		$pdf->Cell(35, 7, utf8_decode('PERÍODO'), 1, 0, "C");
		$pdf->ln(); //nenhum espa�amentos entre linhas
		$pdf->SetFont('Arial', '', 10);

		$busca = mysqli_query($conexao, $sql);
		while ($resultado = mysqli_fetch_array($busca)) {

			$val = explode(" ", $resultado['inicio']);
			list($data, $hora) = $val;
			$data = array_reverse(explode("-", $data));
			$data = implode("-", $data);

			if ($hora == '07:00') {
				$periodo = 'DIURNO';
			} else {
				$periodo = 'NOTURNO';
			}


			$pdf->Cell(100, 7, utf8_decode($resultado['unidade']), 1, 0, "C");
			$pdf->Cell(20, 7, $resultado['ch'], 1, 0, "C");
			$pdf->Cell(35, 7, $data, 1, 0, "C");
			$pdf->Cell(35, 7, $periodo, 1, 0, "C");
			$pdf->Ln();
		}

		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(100, 10, ("Gerado " . date('H:i d-m-Y ')), 0, 0, "C");
		$pdf->ln(15);
		$pdf->Cell(190, 20, 'SGT - SISPEN 2020-2024', 0, 0, "C");
		$pdf->Image('imagens/logoEES.png', 45, 260, 120, 35, 'PNG');

		$pdf->Output('I', $nome . "_" . $mesDoExtra);
	} else {
		$_SESSION['msg'] = "<div class='alert alert-danger'>Escolha o período para visualizar os agendamentos!</div>";
		header("Location: home.php");
	}
} else {
	$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario n�o logado!</div>";
	header("Location: index.php");
}