<?php
include_once '../_include/_pos.php';
if( is_file('../__config/caja/_pos_poliza_'.$_SESSION['limites']['notaria'].'.php') ){
	include '../__config/caja/_pos_poliza_'.$_SESSION['limites']['notaria'].'.php';
	return 0;
}

$arr = array();
$arr = _pos_carga( $arr, "_global", 1, 1, 770 );
$arr = _pos_carga( $arr, "fecha", 1, 540, 200 );
$arr = _pos_carga( $arr, "beneficiario", 120, 40, 500 );
$arr = _pos_carga( $arr, "monto", 120, 570, 180 );
$arr = _pos_carga( $arr, "monto_letra", 150, 40, 700 );

$arr = _pos_carga( $arr, "usuario", 0, 30, 50 );
$arr = _pos_carga( $arr, "no", 0, 90, 200 );
$arr = _pos_carga( $arr, "poliza", 0, 300, 120 );
$arr = _pos_carga( $arr, "credito_no", 0, 430, 120 );
$arr = _pos_carga( $arr, "fecha_ddmmaa", 0, 600, 100 );

$_pos['cheque']['c_cheques'] = $arr;

$arr = array();
$arr = _pos_carga( $arr, "_global", 150, 1, 770 );
$arr = _pos_carga( $arr, "concepto", 10, 30, 410 );
$arr = _pos_carga( $arr, "beneficiario", 25, 20, 410 );
$arr = _pos_carga( $arr, "cuenta1", 110, 0, 50 );
$arr = _pos_carga( $arr, "cuenta2", 110, 60, 70 );
$arr = _pos_carga( $arr, "cuenta3", 110, 140, 60 );
$arr = _pos_carga( $arr, "cuenta4", 110, 210, 80 );
$arr = _pos_carga( $arr, "nombre", 110, 290, 190 );
$arr = _pos_carga( $arr, "expediente", 110, 490, 60 );
$arr = _pos_carga( $arr, "cargo", 110, 540, 70 );
$arr = _pos_carga( $arr, "abono", 110, 630, 80 );
$arr = _pos_carga( $arr, "cargo_total", 430, 540, 70 );
$arr = _pos_carga( $arr, "abono_total", 430, 630, 80 );

//$arr = _pos_carga( $arr, "resumen_final", 400, 0, 700 );

$_pos['cheque']['poliza'] = $arr;

?>
