<?php
session_start();

if (!empty($_SESSION['cpf'])) {
    setlocale(LC_TIME, 'pt_BR.UTF-8');
	define('FPDF_FONTPATH', 'font/');
	require('../fpdf/fpdf.php');
	require_once('../Database.php');
	$conexao = new Database('DB_NAME_PLE'); 

    function numeroPorExtenso($numero) {
        $numerosPorExtenso = [
            0 => 'zero',
            1 => 'um',
            2 => 'dois',
            3 => 'três',
            4 => 'quatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'sete',
            8 => 'oito',
            9 => 'nove',
            10 => 'dez',
            11 => 'onze',
            12 => 'doze',
            13 => 'treze',
            14 => 'quatorze',
            15 => 'quinze',
            16 => 'dezesseis',
            17 => 'dezessete',
            18 => 'dezoito',
            19 => 'dezenove',
            20 => 'vinte'
        ];
    
        return ($numero >= 0 && $numero <= 20) ? $numerosPorExtenso[$numero] : 'X';
    }
	
	$nome = $_SESSION['nome'];
	$mesDoExtra = isset($_POST['mesDoExtra']) ? $_POST['mesDoExtra'] : false;

	if ($mesDoExtra) {
		$data_inicial = date("Y-m-d", strtotime($mesDoExtra));
		$data_final = date_format(date_modify(date_create($data_inicial), '+1 month'), 'Y-m-d');
        
		$sql = "SELECT * FROM demanda WHERE nome = :nome and inicio >= :data_inicial and inicio < :data_final order by inicio";
		$agendamentos = $conexao->query($sql, [':nome' => $nome, ':data_inicial' => $data_inicial, ':data_final' => $data_final]);
        
        $totalDeAgendamentos = count($agendamentos);
        $totalDeAgendamentosPorExtenso = numeroPorExtenso($totalDeAgendamentos);
        $dataPorExtenso = strftime('%B de %Y', strtotime($mesDoExtra));

        // var_dump($agendamentos);
        // exit();

		$recuo_paragrafo = "                ";
		$pdf = new FPDF();
		$pdf->AddPage();
        $pdf->Image('../imagens/spex-template-agendamentos.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
		$pdf->SetMargins(20, 0, 20);
		
        $pdf->ln(40);
        $pdf->SetFont('Times', '', 12);
        $paragrafo = "Conforme os registros de agendamentos constantes no Sistema de Plantão Extraordinário - SPEX, previamente lançados dentro do período regulamentar ou excepcional, consta em  nome de {$_SESSION['nome']}, {$_SESSION['cargo']}, matrícula nº {$_SESSION['funcional']}, lotado(a) no(a) {$_SESSION['lotação']}, a programação de {$totalDeAgendamentos} ({$totalDeAgendamentosPorExtenso}) plantões extraordinários sob a competência de $dataPorExtenso.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
        $paragrafo = "Segue abaixo a relação detalhada dos plantões extraordinários agendados, incluindo as respectivas unidades de preferência, datas e turnos.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
        $paragrafo = "Informamos ainda que os plantões agendados e não realizados podem ser remanejados conforme  as necessidades operacionais da unidade.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');


		$pdf->ln(); 
        $pdf->SetFillColor(255, 255, 255);
        // $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', 'B', 12);
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
        $pdf->SetFont('Times', '', 10);
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
        $pdf->SetFont('Times', '', 12);
        $paragrafo = "No mais, colocamo-nos à inteira disposição para prestar qualquer outro esclarecimento, por meio do telefone: 3218-2056, ou, pelo e-mail: copex.seciju@gmail.com.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');

        $pdf->ln();
        $paragrafo = "Atenciosamente,";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');

        $pdf->ln();
        $pdf->SetFont('Times', 'B', 12);
        $paragrafo = "Carlos Henrique de Souza Castro";
        $pdf->MultiCell(170, 7, utf8_decode($paragrafo), 0, 'C');
        $pdf->SetFont('Times', '', 12);
        $paragrafo = "Coordenação de Plantão Extraordinário - COPEX";
        $pdf->MultiCell(170, 4, utf8_decode($paragrafo), 0, 'C');

        $pdf->ln(25);
        $momentoGeracaoRelatorio = new DateTime();
        $pdf->Cell(50, 7, "Gerado em: " .  $momentoGeracaoRelatorio->format('d/m/Y H:i:s'), 0, 1, "C");

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