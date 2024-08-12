<?php
session_start();

if (!empty($_SESSION['cpf'])) {
    setlocale(LC_TIME, 'pt_BR.UTF-8');
	define('FPDF_FONTPATH', 'font/');
	require('../fpdf/fpdf.php');
    
    if($_SESSION['carimbo'] and $_SESSION['extra'] != '') {
        $momentoDoCadastroDisponibilidade =  new DateTime($_SESSION['carimbo']);
        $momentoDoCadastroDisponibilidadeFormatado = $momentoDoCadastroDisponibilidade->format('d/m/Y H:i:s');
        $momentoDoCadastroDisponibilidade = $momentoDoCadastroDisponibilidade->modify('+1 month');
        $competenciaDaDisponibilidade = strftime('%B de %Y', $momentoDoCadastroDisponibilidade->getTimestamp());

        $recuo_paragrafo = "                ";
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('../imagens/spex-template-disponibilidade.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
        $pdf->SetMargins(20, 0, 20);
        
        $pdf->ln(40);
        $pdf->SetFont('Times', '', 12);
        $paragrafo = "Conforme os registros de disponibilidade constantes no Sistema de Plantão Extraordinário - SPEX, previamente cadastrados dentro do período regulamentar ou em caráter excepcional, consta que {$_SESSION['nome']}, {$_SESSION['cargo']}, matrícula nº {$_SESSION['funcional']}, lotado(a) no(a) {$_SESSION['lotação']} manifestou a disponibilidade para realizar plantões extraordinários na competência de {$competenciaDaDisponibilidade}.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'L');
        $paragrafo = "Segue abaixo o detalhamento do registro de disponibilidade, incluindo as respectivas unidade de preferência, data e hora do cadastro.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
        $paragrafo = "Informamos ainda que o registro de disponibilidade pode ser alterado conforme  as necessidades operacionais da unidade.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');

        $pdf->ln(); 
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(110, 8, utf8_decode('UNIDADE DE PREFERÊNCIA'), 1, 0, "C", true);
        $pdf->Cell(60, 8, utf8_decode('MOMENTO DO CADASTRO'), 1, 0, "C", true);

        function customPrintTextBySize($x, $length) {
            if (strlen($x) <= $length) {
                return $x;
            }
            return substr($x,0,$length) . '...';
        }
        
        $pdf->Ln();         
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(110, 7, customPrintTextBySize(utf8_decode($_SESSION['preferencia']),50), 1, 0, "L");
        $pdf->Cell(60, 7, $momentoDoCadastroDisponibilidadeFormatado, 1, 0, "C");
        $pdf->Ln();

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

        $pdf->ln(72);
        $momentoGeracaoRelatorio = new DateTime();
        $pdf->Cell(50, 7, "Gerado em: " .  $momentoGeracaoRelatorio->format('d/m/Y H:i:s'), 0, 1, "C");
        $pdf->Cell(170, 7, utf8_decode("Código verificador: ") .  $_SESSION['codigo'], 0, 0, "C");

        $pdf->Output('I', ucwords($nome) . "- disponibilidade - " . $competenciaDaDisponibilidade . ".pdf");
    } else {
        $recuo_paragrafo = "                ";
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('../imagens/spex-template-disponibilidade.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
        $pdf->SetMargins(20, 0, 20);
        
        $pdf->ln(40);
        $pdf->SetFont('Times', '', 12);
        $paragrafo = "Conforme os registros de disponibilidade constantes no Sistema de Plantão Extraordinário - SPEX, previamente cadastrados dentro do período regulamentar ou em caráter excepcional, consta que {$_SESSION['nome']}, {$_SESSION['cargo']}, matrícula nº {$_SESSION['funcional']}, lotado(a) no(a) {$_SESSION['lotação']} não possui manifestação de disponibilidade cadastrada para realizar plantões extraordinários.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'L');
        $paragrafo = "Informamos ainda que o registro de disponibilidade deve ser realizado dentro do prazo definido pela COPEX.";
        $pdf->MultiCell(170, 7, $recuo_paragrafo . utf8_decode($paragrafo), 0, 'J');
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

        $pdf->ln(72);
        $momentoGeracaoRelatorio = new DateTime();
        $pdf->Cell(50, 7, "Gerado em: " .  $momentoGeracaoRelatorio->format('d/m/Y H:i:s'), 0, 1, "C");
        $pdf->Cell(170, 7, utf8_decode("Código verificador: ") .  $_SESSION['codigo'], 0, 0, "C");

        $pdf->Output('I', ucwords($nome) . " - disponibilidade não manifestada.pdf");
    }        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não autenticado!</div>";
    header("Location: ../index.php");
}
?>