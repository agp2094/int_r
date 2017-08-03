<?php 
//print"<pre>";print_r($row);print"</pre>";


function  _i( $l, $w = 100 ){
	?><input type="text" value="<?=$l?>" style="width:<?=$w?>px; text-align: inherit; font-size: inherit;"><?
}


$referencia = $row['escritura'] > 0 ? $row['escritura'] : $row['expediente'];
$referencia .= " / ".$row['folio'];
?>
<div class="salto">&nbsp;</div>
<style type="text/css">
	.abs { position: absolute; }
	input{ border:1px solid white; padding:0; marign:0 }
</style>
<div style="position:relative;">
	<div style="position:absolute; top:1px; left:1px;" id="div_retencion">
		<div class="no_print" style="position:absolute;">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td></td>
					<td><button class="mi-llenado" onclick="tmp_pos = (parseFloat($('#div_retencion').css('top') ) - 1) + 'px'; $('#div_retencion').css('top' ,tmp_pos); $('#div_top').html( tmp_pos );"><img src="../_img/icons_fam/arrow_up.png"></button></td>
					<td></td>
					<td>
						<div>top:<span id="div_top">1px</span></div>
						<div>left:<span id="div_left">1px</span></div>
					</td>
				</tr>
				<tr>
					<td><button class="mi-llenado" onclick="tmp_pos = (parseFloat($('#div_retencion').css('left')) - 1) + 'px'; $('#div_retencion').css('left', tmp_pos); $('#div_left').html( tmp_pos );"><img src="../_img/icons_fam/arrow_left.png"></button></td>
					<td></td>
					<td><button class="mi-llenado" onclick="tmp_pos = (parseFloat($('#div_retencion').css('left')) + 1) + 'px'; $('#div_retencion').css('left', tmp_pos); $('#div_left').html( tmp_pos );"><img src="../_img/icons_fam/arrow_right.png"></button></td>
				</tr>
				<tr>
					<td></td>
					<td><button class="mi-llenado" onclick="tmp_pos = (parseFloat($('#div_retencion').css('top') ) + 1) + 'px'; $('#div_retencion').css('top' , tmp_pos ); $('#div_top').html( tmp_pos );"><img src="../_img/icons_fam/arrow_down.png"></button></td>
					<td></td>
				</tr>
			</table>
		</div>
		<div class="abs" style="left:545px; top:140px; "><?_i(substr( $row['fecha_recibo'], 5,2), "50")?> </div>
		<div class="abs" style="left:605px; top:140px; "><?_i(substr( $row['fecha_recibo'], 5,2), "50")?> </div>
		<div class="abs" style="left:655px; top:140px; "><?_i(substr( $row['fecha_recibo'], 0,4), "50")?> </div>
	
		<div class="abs" style="left:540px; top:172px; "><?_i($referencia, 200)?></div>
		
		<div class="abs" style="left:180px; top:195px; "><?=$row['notario']['rfc']?></div>
		<div class="abs" style="left:180px; top:215px; "><?=$row['notario']['curp']?></div>
		<div class="abs" style="left:180px; top:235px; width:400px; text-transform: uppercase;"><?=$row['notario']['nombre_sat']?></div>
		
		<div class="abs" style="left:185px; top:323px; width: 510px">
			<?=$row['notario']['direccion']['calle']?>
			<?=$row['notario']['direccion']['numero']?>
			<?=$row['notario']['direccion']['manzana']?>
			<?=$row['notario']['direccion']['lote']?>
			<?=$row['notario']['direccion']['interior']?>,
			Col. <?=$row['notario']['direccion']['colonia']?>
			<?=$row['notario']['direccion']['delegacion']?>,
			C.P.<?=$row['notario']['direccion']['cp']?>
			<?=$row['notario']['direccion']['ent']?>
		</div>
	
		<div class="abs" style="left:255px; top:435px;">A1</div>
	
	
		<div class="abs" style="left:200px; top:515px; width: 150px; text-align: right;"><?=$row['honorarios']?></div>
		<div class="abs" style="left:200px; top:567px; width: 150px; text-align: right;"><?_i( $row['retISR'],150 )?></div>
	
		<div class="abs" style="left:360px; top:515px; width: 150px; text-align: right;"><?=$row['honorarios']?></div>
		<div class="abs" style="left:360px; top:567px; width: 150px; text-align: right;"><?_i( $row['retIVA'],150 )?></div>
	
		<div class="abs" style="left:200px; top:608px; "><?_i( $row['rfc'],150 )?></div>
		<div class="abs" style="left:198px; top:625px; width: 510px;"><?_i( $row['nombre'],500 )?></div>
		<div class="abs" style="left:200px; top:642px; width: 510px;"><?=_i(".","500")?></div>
		<div class="abs" style="left:200px; top:663px;"><?=_i(".","180")?></div>
		<div class="abs" style="left:500px; top:660px;"><?=_i(".","180")?></div>
	</div>
</div>