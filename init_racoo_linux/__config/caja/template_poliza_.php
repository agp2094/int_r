	<style>
		hr{ padding: 0; margin: 0;}
	</style>
			<div class="p_fecha p_rotar"><?=$row_c_cheques['fecha']?></div>
			<div class="p_monto p_rotar"><?=$row_c_cheques['monto']?></div>
			<div class="p_beneficiario p_rotar"><?=$row_c_cheques['beneficiario']?></div>
			<div class="p_monto_letra p_rotar"><?=$row_c_cheques['monto_letra']?></div>	
		
			<div class="cuenta"><NOBR>&nbsp;<?=$row_c_cheques['cuenta']?>&nbsp;</nobr></div>
			<div class="beneficiario2">
				<?=$row_c_cheques['beneficiario']?>
				<div style="text-align: center; border-top: 1px solid black; font: 8px arial">FIRMA</div>
			</div>
			<?if( $row_c_cheques['acb'] == 1 && $row_c_cheques['tipo']  == "cheque" ){
				?><div class="abono_cuenta_beneficiario rotar">PARA ABONO EN CUENTA DEL BENEFICIARIO</div><?
			}?>	
			<?if( $_REQUEST['titulo'] == "si" ){?>
			<div class="titulo">notar&iacute;a: <?=$_REQUEST['notaria']?> cuenta: <?=$row_c_cheques['cuenta']?></div>
			<?}?>
		<div class="movs">
			<table align="center" class="movs_table" width="90%">
				<tr>
					<th class="movs_th">CUENTA</th>
					<th class="movs_th">DESCRIPCION</th>
					<th class="movs_th">EXP/ESC</th>
					<th class="movs_th">DEBE</th>
					<th class="movs_th">HABER</th>
				</tr>
			<? 
			for ($x = 0 ; $x < count( $arr_movs['regs'] ) ; $x++) {
				$mov = $arr_movs['regs'][$x];
				if( fmod($x+1,10) == 0 ){
					?></table>
					<table align="center" class="movs_table"  width="90%"><?
				}
				?>
				<tr>
					<td class="movs_td_cuenta" style="width:100px;"><?=$mov['cuenta']?></td>
					<td class="movs_td_descripcion"><?=$mov['nombre']?></td>
					<td class="movs_td_exp_esc" width="80px;"><?=$mov['expediente']?></td>
					<td class="movs_td_debe" width="85px;"> <?=$mov['cargo'] != 0 ? number_format($mov['cargo'],2) : ""?></td>
					<td class="movs_td_haber" width="85px;"><?=$mov['abono'] != 0 ? number_format($mov['abono'],2) : ""?></td>
				</tr>
			<?}?>
				<tr>
					<td class="movs_td_total" colspan="3">TOTAL(<?=count( $arr_movs['regs'] )?>):</td>
					<td class="movs_td_debe_total"><?=number_format($arr_movs['tots']['cargo'],2)?></td>
					<td class="movs_td_haber_total"><?=number_format($arr_movs['tots']['abono'],2)?></td>
				</tr>
			</table>
			<table align="center" class="resumen">
				<tr>
					<td>{<?=$row_usuario['usuario']?>}</td>
					<td><?=$row_c_cheques['tipo']?> No.: <?=$row_c_cheques['no']?> <?=$row_c_cheques['estatus']?></td>
					<td>POLIZA: <?=$row_c_cheques['poliza']?></td>
					<td><?=$row_c_cheques['fecha_ddmmaa']?></td>
				</tr>
				<tr>
					<td colspan="4" style="font:16px monospace;">
						<center>&bull;<?=$row_c_cheques['concepto']?>&bull;</center>
					</td>
				</tr>
			</table>
		</div>
		<br><br>
		<table width="90%" style="text-align: center;" align="center">
			<tr>
				<td class="t-rig"><hr>Revis&oacute;</td>
				<td class="t_rig"><hr>Autoriz&oacute;</td>
				<td class="t_rig"><hr>Recibi&oacute;</td>
			</tr>
		</table>
	