<? 
$ret_isr = 0;
$ret_iva = 0;
if( $row_c_tarjeta['retencion'] != "no" ){
	$ret_isr = $this->f_mt()->Redondea( $cuentas['honorarios']['total']*.1, 2 );
	$ret_iva = $this->f_mt()->retencion( $cuentas['honorarios']['total'], $row_c_tarjeta['retencion'] );
} 
?>
		<center>
		<div style="position: relative; width: 500px; height:750px; border: 1px solid #dfdfdf; padding-left: 60px; padding-right: 2px;">
		<center>
			<h2 style="margin: 0; padding : 0"><?=$row_not['nombre']?></h2>
			<h4 style="margin: 0; padding : 0">NOTARIA <?=$row_not['no_notario']?> del <?=str_replace( "exi", "éxi", $_SESSION['limites']['entidade_nombre'] )?></h4>
			 <table cellpadding="0" cellspacing="0" align="center">
			 	<tr>
			 		<td><img src="../apps/barcode/barcode.php?bdata=F001<?=$row_c_tarjeta['c_tarjeta_id']?>F"></td>
			 		<td>
						<h1><?=$row_c_tarjeta['tarjeta']?><span class="t_8ari">(<?=$row_expediente['expediente']?>)</span>{<?=$row_expediente['escritura']?>}</h1>
			 		</td>
			 </table>
		</center>
		<div class="ui-widget ui-widget-content ui-corner-all">
			<table style="font:14px arial" cellspacing="0" border="0">
				<tr>
					<?=$this->v_td( "expediente", $row_expediente , "100")?>
					<?=$this->v_td( "escritura", $row_expediente, "80", "font:bold 18px arial; text-align:right" )?>
					<td rowspan="3" valign="top">
					<?
						$this->_t_c_tarjeta_parts = $this->_mk_tabla( "c_tarjeta_parts" );
						$cuentas['RP']['total'] += $this->_t_c_tarjeta_parts->m_calcula_rp( $c_tarjeta_id );
					?>	
					
						<?=$this->v_detalle( "RP", $cuentas['RP'] )?>
					</td>
					
				</tr>
				<tr>
					<?=$this->v_td( "tarjeta", $row_c_tarjeta )?>
					<?=$this->v_td( "fecha", $row_c_tarjeta )?>
				</tr>
				<tr>
					<td>operación:</td>
					<td colspan="5" class="b_bot"><?=$row_expediente['operacion']?></td>
				</tr>
				<tr>
					<td>nombre:</td>
					<td colspan="5" class="b_bot"><?=$row_expediente['descripcion']?></td>
				</tr>
				<tr>
					<td>banco:</td>
					<td colspan="5" class="b_bot"><?=$row_expediente['banco']?></td>
				</tr>
			</table>
		</div>
		<? if( $row_cliente['otro']['nombre'] != "" ) {?>
		<div class="ui-widget ui-widget-content ui-corner-all">
			<?=$row_cliente['otro']['nombre']?>
		</div>
		<?}?>
		<div class="ui-widget ui-widget-content ui-corner-all">
		<table  cellspacing="0" border="0" style="font:12px arial">
			<tr>
				<td width="350px" valign="top">
					<div>nombre: <b><?=$row_cliente['principal']['nombre']?></b></div>
					<div>rfc: <b><?=$row_cliente['principal']['rfc']?></b></div>
					<div>curp: <b><?=$row_cliente['principal']['curp']?></b></div>
					<div>dirección: <b><?=$row_cliente['principal']['direccion']?></b></div>
				</td>
			</tr>
		</table>
		</div>
		<?
		if( $row_c_tarjeta['observaciones'] != "" ){
						$this->f_ht()->msg_state_( "OBS:".$row_c_tarjeta['observaciones'] );
					}?>
		<div><?=$this->v_detalle_3( "honorarios", $cuentas["honorarios"], "detalles")?></div>
		<div><?=$this->v_detalle_3( "honorarios_iva", $cuentas["honorarios_iva"], "detalles")?></div>
		<?if( $row_c_tarjeta['retencion'] != "no" ){?>
		<div style="border-top: 1px dashed black; margin-top: 4px;">
			<table width="99%" border="0">
				<tr>
					<td class="" valign="top" width="50%">Retención ISR:</td>
					<td class="t-rig" width="50%" valign="top" style="color:tomato">
						<?=number_format($ret_isr, 2 )?>
					</td>
				</tr>
				<tr>
					<td class="" valign="top" width="50%">Retención IVA:</td>
					<td class="t-rig" width="50%" valign="top" style="color:tomato">
						<?=number_format($ret_iva, 2 )?>
					</td>
				</tr>
			</table>
		</div>
		<?}?>
		<div style="border-top: 1px dashed black; margin-top: 4px;">
			<table width="99%" border="0">
				<tr>
					<td class="t-rig t_14ari" valign="top" width="70%"><b>TOTAL:</b></td>
					<td class="t-rig t_14ari b_bot" valign="top" width="*">
						<b><?=number_format($cuentas['honorarios']['total']+$cuentas['honorarios_iva']['total']-$ret_isr-$ret_iva,2)?></b>
					</td>
				</tr>
				<tr>
					<td class="t-rig t_14ari" valign="top" width="70%"><b>Pago por Cuenta del Cliente:</b></td>
					<td class="t-rig t_14ari" valign="top" width="*">
						<b><?=number_format($IDE,2)?></b>
					</td>
				</tr>
			</table>
		</div>
		
		<div style="position: relative; margin-right: 60px; border: 1px dashed gray; border-top: 1px solid white;">
			<div><?=$this->v_detalle_3( "impuestos", $cuentas['impuestos'], "detalles" )?></div>
			<div><?=$this->v_detalle_3( "derechos", $cuentas['derechos'], "detalles" )?></div>
			<div><?=$this->v_detalle_3( "erogaciones", $cuentas['erogaciones'], "detalles" )?></div>
			<?
			$keys = array_keys( $cuentas );
			$list = explode(",", "RP,créditos,impuestos,otros,derechos,erogaciones,devoluciones,honorarios,honorarios_iva,ISR,ISR X ADQ,terceros");
			for ($x = 0 ; $x < count($keys) ; $x++) {
				if( !in_array( $keys[$x], $list ) ){
					?><div><?=$this->v_detalle_3( $keys[$x], $cuentas[$keys[$x]], "detalles", "80%" )?></div><?
				}
			} 
			?>
		</div>
		<div style="border-top: 1px dashed black; margin-top: 4px;">
			<table width="99%" border="0">
				<tr>
					<td class="t-rig t_18ari" valign="top" width="70%"><b>Gran-Total:</b></td>
					<td class="t-rig t_18ari" valign="top" width="*">
						<b><?=number_format($cuentas['honorarios']['total']+$cuentas['honorarios_iva']['total']-$ret_isr-$ret_iva+$IDE,2)?></b>
					</td>
				</tr>
			</table>
		</div>
		<?
		$keys = array_keys( $cuentas );
		$list = explode(",", "ISR,ISR X ADQ,terceros");
		for ($x = 0 ; $x < count($keys) ; $x++) {
			if( in_array( $keys[$x], $list ) ){
				?><div><?=$this->v_detalle_3( $keys[$x], $cuentas[$keys[$x]], "detalles", "80%" )?></div><?
			}
		} 
		?>
		<div class="no_print t-rig b_bot b_top ui-widget ui-widget-estats-alert">
				<?if( $row_c_tarjeta['estatus'] == "nuevo" && $this->f_o_up()->obj_soy( 'caja' ) ){?>
					<button class="mi-boton" onclick="js_ajax_html('c_tarjetas','c_aceptar','id=<?=$c_tarjeta_id?>','#tarjeta_ver');">aceptar</button>
					<button class="mi-boton">cancelar</button>
				<?}else if( $row_c_tarjeta['estatus'] == "aceptado" && $this->f_o_up()->obj_soy( 'caja' ) ){?>
					<button class="mi-boton" style='color:tomato;' onclick="js_ajax_html('c_tarjetas','c_des_aceptar','id=<?=$c_tarjeta_id?>','#tarjeta_ver');">desbloquear</button>
				<?}?>
				<b>ESTATUS: <?=$row_c_tarjeta['estatus']?></b>
				<button class="mi-boton" onclick="window.print()">imprimir</button>
		</div>
	</div>
</center>
