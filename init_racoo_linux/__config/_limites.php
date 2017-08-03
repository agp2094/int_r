<?php
$_SESSION['limites']['master'] = "no";
$_SESSION['limites']['notaria'] = "#RACOO";/** ejemplo: 9df,48pue/*/
$_SESSION['limites']['modulos']['caja'] = "si";//si, vacio , no = no muestra nada de caja


$_SESSION['limites']['modulos']['impuestos'] = "si";
$_SESSION['limites']['email'] = "racoo@racoo.com.mx";/**/
$_SESSION['limites']['dbexp'] = "";
$_SESSION['limites']['color'] = "";

$_SESSION['limites']['cotejos']['reg_x_pagina'] = "";/**/ //numero de registros por paguina.
$_SESSION['limites']['cotejos']['fol_x_libro'] = "";/**/ //numero de folios por libro de cotejo.
$_SESSION['limites']['cotejos']['la_primera'] = "";/**/ //el primer registro de cotejo del libro 1.
$_SESSION['limites']['cotejos']['libro_uno'] = "";/**/ //el primer libro del registro.

$_SESSION['limites']['caja']['cierre_inicial'] = "si";//si, no, recorre todos los movimientos y los agrupa en el cierre segun la fech

//$_SESSION['limites']['min_tachar_firmas'] = "1";
$_SESSION['limites']['min_tachar_firmas'] = "1";
//verifica si la escritura a agregar existe en el protocolo
$_SESSION['limites']['validar_protocolo'] = "si";

//$_SESSION['limites']['expedientes']['mascara'] = "A#/";
$_SESSION['limites']['expedientes']['mascara'] = "##/";/**/

$_SESSION['limites']['entidade_id'] = "#RACOO#";/* ejemplo: 9 ñara el DF, 15 edom mex */
$_SESSION['limites']['entidade_nombre'] = "#RACOO#";/*ejemplo: Distrito Federal*/

$_SESSION['limites']['gestorias']['llenado_tablas'] = "si";
$_SESSION['limites']['gestorias']['racoo_notarios'] = "no";
$_SESSION['limites']['gestorias']['dsnot'] = "no";
$_SESSION['limites']['gestorias']['verificar'] = "si";
//orden de aparicion jerarquica de los abogados
$_SESSION['limites']['gestorias']['orden'] = "asc";
//ver tres tipos de listas DF, EDO MEX y FORANEOS
$_SESSION['limites']['gestorias']['listas'] = "2";

//ACUERDOS: 1=domingo, 2=lunes, 3=martes, 4=miercoes, 5=jueves, 6=viernes, 7=sabado
$_SESSION['limites']['acuerdo']['dias'] = "2,4";/**/

//notarios a buscar en la pána de RPP
$_SESSION['limites']['rpp']['notarios'] = "PRUEBA PRUEBA PRUEBA";/**/

$_SESSION['limites']['agendas']['ini'] = "#RACOO#07:00";/*ejemplo: 07:00*/
$_SESSION['limites']['agendas']['fin'] = "#RACOO#15:00";/*ejemplo: 15:00*/
$_SESSION['limites']['agendas']['comida'] = "#RACOO#15:00,15:30";/*ejemplo: 15:00,15:30*/
$_SESSION['limites']['agendas']['acuerdo'] = "#RACOO#07:00,08:30,lunes,miércoles";/*ejemplo: 07:00,08:30,lunes,miércoles*/
$_SESSION['limites']['agendas']['no_repetir'] = "TPA,---,ALTA";/**/
$_SESSION['limites']['agendas']['fondo_completo'] = "SALIDA";
//controlar salas y expedientes en la agenda. Valores = 'si'(se ven los expedientes y las salas) o 'sala'(solo se ven las salas)
$_SESSION['limites']['agendas']['salas_expediente'] = "si";
$_SESSION['limites']['agendas']['ope_default'] = '---';

$_SESSION['limites']['remote']['usuario'] = "QSCDR$#%TF";
$_SESSION['limites']['remote']['clave'] = "LIJU(YHGT%";

$_SESSION['limites']['ta']['gn'] = 'si';

//segundos para actualizar los mensajes recibidos
$_SESSION['limites']['msgs']['time_update'] = '30';
$_SESSION['limites']['msgs']['sonido'] = 'si';

$_SESSION['limites']['archivos']['activado'] = "si";
$_SESSION['limites']['archivos']['usuario'] = "racoo";
$_SESSION['limites']['archivos']['clave'] = "racoo";
$_SESSION['limites']['archivos']['direccion_web'] = "http://".$_SERVER['HTTP_HOST']."/";/**/
$_SESSION['limites']['archivos']['apps'] = "si";
$_SESSION['limites']['archivos']['direccion'] = "/mnt/datos/docs/racoo/";
$_SESSION['limites']['archivos']['carpetas'] = "test,mail,__previos,_post,firma,scan";
$_SESSION['limites']['archivos']['letra'] = "X";


$_SESSION['limites']['caja']['desgloce_gastos'] = "no";
?>