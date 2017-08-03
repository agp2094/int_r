<? 
//print"<pre>";print_r($row);print"</pre>";
?>
<style>
	.logo { width: 95px; position: relative; float: left; }
	.limpia{ clear: both; }
	.emisor{ position: relative;  float: left; width: 49% ; }
	.rd_datos { position: relative;  float: right; width: 49%; border-left: 1px solid black; padding-left: 5px; }
	.rd { position: relative;  width: 700px; margin-left: auto; margin-right: auto; font:14px arial; }
	.barcode { position: relative; float:left; }
	h4 { margin: 0; padding: 0; }
	h3 { margin: 0; padding: 0; padding-top:10px; }
	.cuadro { position: relative; width: 100%; border: 1px solid black; margin-bottom: 10px; }
</style>
<div class="rd">
	<div class="emisor">
		<img class="logo" src="../__config/logo.png">
		<div><b><?=$row['notario']['nombre']?></b></div>
		<div><?=$row['notario']['rfc']?></div>
		<div><?=$row['notario']['curp']?></div>
		<div>
			<?=$row['notario']['direccion']['calle']?>
			<?=$row['notario']['direccion']['numero']?>
			<?=$row['notario']['direccion']['manzana']?>
			<?=$row['notario']['direccion']['lote']?>
			<?=$row['notario']['direccion']['interior']?>
			<?=$row['notario']['direccion']['colonia']?>
			<?=$row['notario']['direccion']['delegacion']?>
			CP.<?=$row['notario']['direccion']['cp']?>
			<?=$row['notario']['direccion']['ent']?>
		</div>
		<div class='t-cen'>{ <?=implode(',',$row['arr_abogados'])?> / <?=implode(',',$row['arr_notarios'])?> }</div>
	</div>
	<div class="rd_datos">
		<img class="barcode"
			src="../apps/barcode/barcode.php?bdata=F002<?=$row['c_recibo_id']?>F">
		<h1>RD<?=$row['serie'].$row['folio']?></h1>
		<br><br>
		<div class="t-rig">fecha <?=$row['fecha']?></div>
		<div>
			<b>metodoDePago:</b>
			<?=$row['metodoDePago']?>
		</div>
	</div>
	<div class="limpia"></div>
	<div class="cuadro">
		<h3>?CLIENTE: <?=(is_array($row['arr_abogados']))?implode(',',$row['arr_abogados']):""?></h3>
		<b>RFC:</b> <?=$row['rfc']?> <b>Nombre:</b> <?=$row['nombre']?>
		<div><b>DIRECCION:</b><?=$row['direccion']?></div>
		<div>		
	</div>
	<div class="limpia"></div>
	<div class="cuadro">
	<h3>?OBSERVACIONES:</h3>
		<div>
			<?=$row['observaciones']?>
		</div>
	
		<?=( strstr( $row['operacion'], "COTEJO" ) )? "<b>".$row['expediente']."</b>": "ESC.<u>".$row['escritura']."</u>"?>
		EXP. <u><?=$row['expediente']?></u> {<?=$row['usuario']?>}
	
		
	</div>
	<div class="limpia"></div>
	<div class="cuadro">
		<h3>?HONORARIOS:</h3>
		<table width="100%">
			<tr>
				<th class="b_bot">U. Medida</th>
				<th class="b_bot">Descripción</th>
				<th class="b_bot">Cantidad</th>
				<th class="b_bot">Precio</th>
				<th class="b_bot">Importe</th>
			</tr>
			<tr>
				<td class="b_bot">servicios</td>
				<td class="b_bot">HONORARIOS</td>
				<td class="b_bot t-rig">1</td>
				<td class="b_bot t-rig"><?=$row['honorarios']?></td>
				<td class="b_bot t-rig"><?=$row['honorarios']?></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="t-rig"><h3>HONORARIOS:</h3></td>
				<td class="t-rig" width="150px"><h3><?=$row['honorarios']?></h3></td>
			</tr>
		</table>	
	</div>
	<?if( $row['ide'] != "0.00" && $row['ide'] != "" ){?>
	<div class="cuadro">
	<? 
	//print"<pre>";print_r($row);print"</pre>aaa";
	?>
		<h3>?PAGOS REALIZADOS POR CUENTA DEL CLIENTE:</h3>
		<table width="100%">
			<tr>
				<th class="b_bot">U. Medida</th>
				<th class="b_bot">Descripción</th>
				<th class="b_bot">Cantidad</th>
				<th class="b_bot">Precio</th>
				<th class="b_bot">Importe</th>
			</tr>
		<? 
		if( $_SESSION['limites']['caja']['desgloce_gastos'] == "si" ){
			$arr_campos = explode( ",", "impuestos,derechos,erogaciones" );
			for ($x = 0 ; $x < count($arr_campos) ; $x++) {
				for ($y = 0 ; $y < count($row["arr_".$arr_campos[$x]]) ; $y++) {
					$arr = $row["arr_".$arr_campos[$x]][$y];
			?>
			<tr>
				<td class="b_bot">servicios</td>
				<td class="b_bot"><?=$arr_campos[$x]?>: <?=$arr['nombre']?></td>
				<td class="b_bot t-rig">1</td>
				<td class="b_bot t-rig"><?=$arr['monto']?></td>
				<td class="b_bot t-rig"><?=$arr['monto']?></td>
			</tr>
			<?
				}
			} 
			
		}else{
			
			$arr_campos = explode( ",", "impuestos,derechos,erogaciones" );
			for ($x = 0 ; $x < count($arr_campos) ; $x++) {
		?>
			<tr>
				<td class="b_bot">servicios</td>
				<td class="b_bot"><?=$arr_campos[$x]?></td>
				<td class="b_bot t-rig">1</td>
				<td class="b_bot t-rig"><?=$row[$arr_campos[$x]]?></td>
				<td class="b_bot t-rig"><?=$row[$arr_campos[$x]]?></td>
			</tr>
		<? 
			}
		}
		?>
		</table>
		<table width="100%">
			<tr>
				<td class="t-rig"><h3>Pag.Cta.Ter.:</h3></td>
				<td class="t-rig" width="150px"><h3><?=$row['ide']?></h3></td>
			</tr>
		</table>	
	</div>
<? 		
	}?>
	<div class="limpia"></div>
	<div class="rd_datos">
		<table width="100%"  class="t-rig">
			<tr>
				<td class="t-rig" ><h4>HONORARIOS:</h4></td>
				<td class="t-rig" width="150px"><h4><?=$row['honorarios']?></h4></td>
			</tr>
			<tr>
				<td class="t-rig" ><h4>IVA:</h4></td>
				<td class="t-rig"><h4><?=$row['honorarios_iva']?></h4></td>
			</tr>
			<?if( $row['retISR'] > 0 ){?>
			<tr>
				<td>retención ISR:</td>
				<td>-<?=$row['retISR']?></td>
			</tr>
			<?}?>
			<?if( $row['retIVA'] > 0 ){?>
			<tr>
				<td>retención IVA:</td>
				<td>-<?=$row['retIVA']?></td>
			</tr>
			<?}?>
			<tr>
				<td class="t-rig" ><h4>SUB-TOTAL:</h4></td>
				<td class="t-rig b_top"><h4><?=$row['honorarios_total']?></h4></td>
			</tr>
			<tr>
				<td class="t-rig" ><h4>Pag.Cta.Ter.:</h4></td>
				<td class="t-rig"><h4><?=$row['ide']?></h4></td>
			</tr>
			<tr>
				<td class="t-rig" ><h2>GRAN TOTAL:</h2></td>
				<td class="t-rig b_top"><h2><?=$row['total']?></h2></td>
			</tr>
			<tr>
				<td class="t-rig" ><h4>RP aplicados:</h4></td>
				<td class="t-rig"><h4><?=$row['RP']?></h4></td>
			</tr>
			<?if( $row['rp_no'] != "----" ){?>
			<tr>
				<td colspan="2" class="t-lef b_top b_bot"><div>R.P. <?=$row['rp_no']?></div></td>
			</tr>
			<?}?>
			<tr>
				<td class="t-rig" ><h2>NETO APAGAR:</h2></td>
				<td class="t-rig"><h2><?=$row['neto']?></h2></td>
			</tr>
		</table>
		<H3>DATOS PARA REALIZAR EL PAGO:</H3>
		<div style="border:3px double black;">
			<div><b>BANCO:</b>____________</div>
			<div><b>CUENTA:</b>__________________</div>
			<div><b>CLABE:</b>_____________________________</div>
			<div><b>NOMBRE:</b>_______________________________</div>
		</div>
	</div>	
	<div class="emisor">
		<H3>TOTAL A PAGAR CON LETRA:</H3>
		<?=$row['total_letra']?>
		<br><br><br><br><br><br><br>
		<div class="b_top t-cen"><h2>FIRMA CLIENTE</h2></div>
	</div>
</div>
	<div class="limpia"></div>
<?
//print"<pre>";print_r($row);print"</pre>";
?>
<?if( $row['retISR'] > 0 ){
	include '../__config/caja/retenciones.php';
}?>