<?php
session_start();
if (!empty($_SESSION['cpf'])) {

	include 'conexao.php';
	//ALTERAÇÃO MENSAL
	$result_events = "select * from demanda where unidade='" . $_SESSION['preferencia'] . "' and nome='" . $_SESSION['nome'] . "' and data>='2024-08-01' or nome='livre' && unidade='" . $_SESSION['preferencia'] . "' and data>='2024-08-01'";

	$resultado_events = mysqli_query($conexao, $result_events);
	while ($row_events = mysqli_fetch_array($resultado_events)) {


		$periodo = $row_events['periodo'];
		$start = $row_events['inicio'];

		$data = explode(" ", $start);
		list($date, $hora) = $data;
		$end = $date . " 23:59";

		$id = $row_events['id'];
		$title = $row_events['nome'];

		//	$end= $row_events['fim'];

		if ($periodo == 'diurno') {
			$color = '#FF8C00';
		} else {
			$color = '#48D1CC';
		}

		$eventos[] = [
			'id' => $id,
			'title' => $title,
			'color' => $color,
			'start' => $start,
			'end' => $end
		];
		$data = $row_events['data'];
	}

	echo json_encode($eventos);
} else {
	$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
	header("Location: ../index.php");
}
