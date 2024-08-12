<?php
session_start();

if (!empty($_SESSION['cpf'])) {
	define('FPDF_FONTPATH', 'font/');
	require('../fpdf/fpdf.php');
	require_once('../Database.php');
	$conexao = new Database('DB_NAME_PLE'); 
	
	$nome = $_SESSION['nome'];
	$mesDoExtra = isset($_POST['mesDoExtra']) ? $_POST['mesDoExtra'] : false;

	if ($mesDoExtra) {
		$data_inicial = date("Y-m-d", strtotime($mesDoExtra));
		$data_final = date_format(date_modify(date_create($data_inicial), '+1 month'), 'Y-m-d');
        
		$sql = "SELECT * FROM demanda WHERE nome = :nome and inicio >= :data_inicial and inicio < :data_final order by inicio";
		$agendamentos = $conexao->query($sql, [':nome' => $nome, ':data_inicial' => $data_inicial, ':data_final' => $data_final]);
		$recuo_paragrafo = "                ";
		$pdf = new FPDF();
		$pdf->AddPage();
        $pdf->Image('../imagens/spex-template-agendamentos.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
		$pdf->SetMargins(20, 0, 20);
		
        $pdf->ln(40);
        $pdf->SetFont('TimesNR', '', 12);
        $paragrafo = "Conforme os registros de agendamentos constantes no Sistema de Plantão Extraordinário – SPEX, previamente lançados dentro do período regulamentar ou excepcional, consta em  nome de Leonardo Araujo, Policial Penal, matrícula nº 1282263, lotado(a) no(a) Setor de Gestão Tecnológica – SGT, a programação de 6 (três) plantões extraordinários para o mês de agosto de 2024.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
        $paragrafo = "Segue abaixo a relação detalhada dos plantões extraordinários agendados, incluindo as respectivas unidades de preferência, datas e turnos.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
        $paragrafo = "Informamos ainda que esses plantões podem ser remanejados conforme  as necessidades operacionais da unidade.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');


		$pdf->ln(); 
        $pdf->SetFillColor(255, 255, 255);
        // $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('TimesNR', 'B', 12);
        // $pdf->Cell(-10);
		$pdf->Cell(82.5, 8, utf8_decode('UNIDADE DE PREFERÊNCIA'), 1, 0, "C", true);
        $pdf->Cell(41.5, 8, utf8_decode('CARGA HORÁRIA'), 1, 0, "C", true);
        $pdf->Cell(25.5, 8, 'DATA', 1, 0, "C", true);
        $pdf->Cell(21, 8, utf8_decode('TURNO'), 1, 0, "C", true);

        function customPrintTextBySize($x, $length) {
            if (strlen($x) <= $length) {
               return $x;
            }
            return substr($x,0,$length) . '...';
        }
        
        $pdf->Ln();         
        $pdf->SetFont('TimesNR', '', 10);
		foreach ($agendamentos as $agendamento) {
			list($string_data, $string_hora) = explode(" ", $agendamento['inicio']);
			$data = new DateTime($string_data);
			$periodo = ($hora == '07:00') ? 'Diurno' : 'Noturno';

            // $pdf->Cell(-10);
			$pdf->Cell(82.5, 7, customPrintTextBySize(utf8_decode($agendamento['unidade']),36), 1, 0, "L");
            $pdf->Cell(41.5, 7, $agendamento['ch'], 1, 0, "C");
            $pdf->Cell(25.5, 7, $data->format('d/m/Y'), 1, 0, "C");
            $pdf->Cell(21, 7, $periodo, 1, 0, "C");
            $pdf->Ln();
        }

        $pdf->ln();
        $pdf->SetFont('TimesNR', '', 12);
        $paragrafo = "No mais, colocamo-nos à inteira disposição para prestar qualquer outro esclarecimento, por meio do telefone: 3218-2056, ou, pelo e-mail: copex.seciju@gmail.com.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');

        $pdf->ln();
        $paragrafo = "Atenciosamente,";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');

        $pdf->ln();
        $pdf->SetFont('TimesNR', 'B', 12);
        $paragrafo = "Carlos Henrique de Souza Castro";
        $pdf->MultiCell(170, 7, utf8_decode($paragrafo), 0, 'C');
        $pdf->SetFont('TimesNR', '', 12);
        $paragrafo = "Coordenação de Plantão Extraordinário – COPEX";
        $pdf->MultiCell(170, 4, $paragrafo, 0, 'C');

        // $pdf->SetFont('TimesNR', '', 10);
        // $pdf->Cell(100, 10, "Gerado " . date('H:i d-m-Y'), 0, 0, "C");
        // $pdf->Ln(15);
        // $pdf->Cell(190, 20, 'SGT - SISPEN 2020-2024', 0, 0, "C");
        // $pdf->Image('../imagens/logoEES.png', 45, 260, 120, 35, 'PNG');

        $pdf->Output('I', $nome . " AGENDAMENTOS - " . $mesDoExtra . ".pdf");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Escolha o período para visualizar os agendamentos!</div>";
        header("Location: ../home.php");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
    header("Location: ../index.php");
}
?>