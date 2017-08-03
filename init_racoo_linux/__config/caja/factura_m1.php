<?
include_once "../apps/MPDF54/mpdf.php" ;
include_once "../__config/_limites.php";
include_once "../_include/ftxt.php";
include_once "../_include/mixml.php";

class factura_m1 {
	
	var $xml;
	var $o_tx;
	var $file;
	var $link;
	
	function v_hacer( $file, $ver = "no", $estatus = "" ){
		$this->link = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".str_replace('./','',dirname(dirname($_SERVER['SERVER_PORT'])));
		$this->link = "http://".$_SERVER['SERVER_ADDR'].":80/".str_replace('./','',dirname(dirname($_SERVER['SERVER_PORT'])));
		
		ob_start();
		$this->file = $file;
		$this->o_tx = new ftxt();
		$this->xml = new mixml();
		$this->xml->xml2Array($file);
		$this->v_style();
		//echo "<pre>",print_r($this->xml->assoc)."</pre>";
		
		
		$this->v_comprobante( );
		$this->v_emisor( );
		$this->v_receptor( );
		$this->v_expedicion( );
		$this->v_totales( );
		$this->v_addenda( );
		$this->v_conceptos(  );
		/**/
		?><div class="-carta">_</div>
		<?
		$html = ob_get_clean();
		$html = $this->o_tx->limpia_acentos( $html );
		$html = utf8_encode( $html);
		
		$mpdf=new mPDF('c','Letter'); 
		$mpdf->SetDisplayMode('fullpage');
		$Comprobante = $this->xml->find_tags("cfdi:Comprobante");
		$TimbreFiscalDigital = $this->xml->find_tags("cfdi:Comprobante->cfdi:Complemento->tfd:TimbreFiscalDigital");
		if( is_array($Comprobante) && $TimbreFiscalDigital['attr']['selloSAT'] == ""){	
			$mpdf->SetWatermarkText("PreFactura");
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
		}else if( $estatus == "cancelada" ){
			$mpdf->SetWatermarkText("cancelada");
			$mpdf->watermark_font = 'DejaVuSansCondensed';
			$mpdf->showWatermarkText = true;
		}
		$mpdf->WriteHTML($html);
		
		
		$file_pdf = substr($file,0,-3)."pdf";
		if( $ver == "no")
			$mpdf->Output( $file_pdf, "F" );
		else{
			$mpdf->Output();
		}
	}
	
	
	function v_style(){
		?>
	<style>
		td { padding: 0; margin: 0; }
		.marco {
			border-radius: .5em;
			border:0.1mm solid gray; 
			margin: 0;
			padding: 2px;
			padding-left: 5px;
		}
		.fondo_gris {
			background: #dfdfdf;
		}
		.fondo_blanco{
			background-color: white;
		}
		.sombra {
			box-shadow: 0.2em 0.2em #888888;
		}
		
		.pos_abs{
			position: absolute;
		}
		
		div, table {
			font-family:arial;
		}

		.rotado90 { position: fixed; 
			overflow: auto; 
			right: 0;
			bottom: 0mm; 
			width: 50mm;
			top: 0;
			right:0;
			width:50mm;
			height:50mm; 
			border: 1px solid #880000; 
			background-color: #FFEEDD; 
			background-gradient: linear #dec7cd #fff0f2 0 1 0 0.5;  
			padding: 0.5em; 
			font-family:sans; 
			margin: 0;
			rotate: 90;
		}
		.carta {
			position: absolute;
			top: 10mm;
			left: 10mm;
			bottom: 10mm;
			width: 740px;
			border: 1px dotted black;
			padding: 0;
			margin: 0;
		}
		
		.f1{
			font-size: 14px;
		}
		.f2{
			font-size: 12px;
		}
		.f3{
			font-size: 10px;
		}
		
		.f10a{
			font:10px arial;
		}
		
		.t_lef { text-align: left; }
		.t_rig { text-align: right; }
		.t_cen { text-align: center; }
	</style>		
	<?
		
	}
	function v_comprobante( ){
		$prefijo = "";
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$Comprobante = $this->xml->find_tags( "Comprobante" );
			$Retenciones = $this->xml->find_tags( "Comprobante->Impuestos->Retenciones" );
		} else {
			$Comprobante = $this->xml->find_tags( "cfdi:Comprobante" );
			$Retenciones = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Impuestos->cfdi:Retenciones" );
			$TimbreFiscalDigital = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Complemento->tfd:TimbreFiscalDigital" );
		}
		$Receptor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Receptor" );
		?>
	<div class="marco fondo_white pos_abs sombra" style="top:10mm; left: 11mm; width: 127mm; height: 40mm">
	<br>
		<?if( $Comprobante['attr']['version'] == "3.2"){?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td><nobr>Serie-Folio:</nobr></td>
				<td class="t_lef"><h2><u><?=$Comprobante['attr']['serie']?>-<?=$Comprobante['attr']['folio']?></u></h2></td>
				<td>
					Fecha: <b><?=$Comprobante['attr']['fecha']?></b>
					<br> FechaTimbrado: <b><?=$TimbreFiscalDigital['attr']['FechaTimbrado']?></b>
					<br>Lugar de Expedición: <b><?=$Comprobante['attr']['LugarExpedicion']?></b>
					
				</td>
			</tr>
			<tr>
				<td>Folio Fiscal:</td>
				<td colspan="2"><h2><u><?=$TimbreFiscalDigital['attr']['UUID']?></u></h2></td>
			</tr>
			</table>
		<table class="t_cen" style=" padding:0; margin:0" align="center" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td style="border-right:1px solid black; border-bottom:1px solid black;">TIPO</td>
				<td style="border-right:1px solid black; border-bottom:1px solid black;">Certificado EMISOR</td>
				<td style="border-bottom:1px solid black;">Certifacdo SAT</td>
			</tr>
			<tr>
				<td style="border-right:1px solid black;"><b><?=$Comprobante['attr']['tipoDeComprobante']?></b></td>
				<td style="border-right:1px solid black;"><b><?=$Comprobante['attr']['noCertificado']?></b></td>
				<td><b><?=$TimbreFiscalDigital['attr']['noCertificadoSAT']?></b></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm">Forma de pago:</td>
				<td><b><?=$Comprobante['attr']['formaDePago']?></b></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm">Método de pago:</td>
				<td width="45mm"><b><?=$this->o_tx->cfdi_metodoDePago_ver( $Comprobante['attr']['metodoDePago'] )?></b></td>
				<td width="38mm">Cuenta de pago:</td>
				<td width="30mm"><b><?=$Comprobante['attr']['NumCtaPago']?></b></td>
			</tr>
		</table>
		Efectos fiscales al pago.
		
		<?}?>
		<?if( $Comprobante['attr']['version'] == "2.2"){?>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm"><b>Certificado:</b></td>
				<td><?=$Comprobante['attr']['noCertificado']?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm"><b>aprobación:</b></td>
				<td> <b>No.</b> <?=$Comprobante['attr']['noAprobacion']?> <b>Año.</b> <?=$Comprobante['attr']['anoAprobacion']?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm"><b>Forma de pago:</b></td>
				<td> <?=$Comprobante['attr']['formaDePago']?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm"><b>Método de pago:</b></td>
				<td width="30mm"><?=$Comprobante['attr']['metodoDePago']?></td>
				<td width="38mm"><b>Cuenta de pago:</b></td>
				<td width="30mm"><?=$Comprobante['attr']['NumCtaPago']?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="t_rig">
			<tr>
				<td width="38mm"><b>TipoDeComprobante:</b></td>
				<td width="15mm"><?=$Comprobante['attr']['tipoDeComprobante']?></td>
				<td width="70mm"><b>Fecha:</b> <u><?=substr($Comprobante['attr']['fecha'],0,10)?> <span class="f3"><?=substr($Comprobante['attr']['fecha'],10)?></span></u></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="38mm">Serie y Folio:</td>
				<td class="t_lef"><h2><u><?=$Comprobante['attr']['serie']?>-<?=$Comprobante['attr']['folio']?></u></h2></td>
			</tr>
		</table>
		Efectos fiscales al pago.
		<?}else{?>
		
		<?}?>
	</div>
	<div class="marco fondo_gris pos_abs" style="top:8mm; left: 10mm; width: 125mm; ">Comprobante Fiscal Digital por Internet( 
	<?if( $Receptor['attr']['rfc'] == "SCT051121GMA" ){?>
		<b>FACTURA</b>
	<?}else{?>
		<b>RECIBO DE HONORARIOS</b>
	<?}?>
	 )</div>
	<?if( $Comprobante['attr']['version'] == "2.2"){?>
		<div class="marco fondo_blanco pos_abs" style="top:154mm; left: 11mm; width: 140mm; height:8mm; padding-top: 6mm;">
		<?=$Comprobante['attr']['sello']?>
		</div>
		<div class="marco fondo_gris pos_abs" style="top:153mm; left: 10mm; width: 140mm;">
		sello
		</div>
		<div class="marco fondo_blanco pos_abs" style="top:171mm; left: 11mm; width: 193mm; height:13mm; padding-top: 6mm;">
		<?
			exec("xsltproc ../_linux/cadenaoriginal_2_2.xslt ".$this->file."",$arr_result);
			echo utf8_decode($arr_result['0']);
		?>
		</div>
		<div class="marco fondo_gris pos_abs" style="top:170mm; left: 10mm; width: 193mm;">
		cadena original
		</div>
	<?}else{?>
		<div class="marco fondo_blanco pos_abs" style="top:154mm; left: 11mm; width: 68mm; height:8mm; padding-top: 6mm;">
		<?=$Comprobante['attr']['sello']?>
		</div>
		<div class="marco fondo_gris pos_abs" style="top:153mm; left: 10mm; width: 68mm;">
		sello EMISOR
		</div>
		<div class="marco fondo_blanco pos_abs" style="top:154mm; left: 83mm; width: 68mm; height:8mm; padding-top: 6mm;">
		<?=$TimbreFiscalDigital['attr']['selloSAT']?>
		</div>
		
		<div class="marco fondo_gris pos_abs" style="top:153mm; left: 82mm; width: 68mm;">
		sello SAT
		</div>
		<div class="marco fondo_blanco pos_abs" style="top:171mm; left: 11mm; width: 140mm; height:13mm; padding-top: 6mm;">
		<?
			exec("xsltproc ../_linux/cadenaoriginal_2_2.xslt ".$this->file."",$arr_result);
			echo "||".$TimbreFiscalDigital['attr']['version']."|".$TimbreFiscalDigital['attr']['UUID'].'|'.$TimbreFiscalDigital['attr']['FechaTimbrado'].'|'.$TimbreFiscalDigital['attr']['selloCFD'].'|'.$TimbreFiscalDigital['attr']['noCertificadoSAT']."||";
		?>
		</div>
		<div class="marco fondo_gris pos_abs" style="top:170mm; left: 10mm; width: 140mm;">
		cadena original
		</div>
	<?}?>
	<div class="pos_abs f2" style="top:191mm; left: 11mm; width: 140mm; height: 10mm;">
		<? if( count($Retenciones['childs']) > 0 ){?>
		<b>Impuesto Retenido de conformidad a la Ley del IVA.</b>
	<?}?> Este documento es una representación Impresa de un CFDI, debe ser almacenado en forma digital, no es necesaria su impresión.
	
	</div>
	
	<?
	}
	function v_emisor(  ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$Emisor = $this->xml->find_tags( "Comprobante->Emisor" );
			$DomicilioFiscal = $this->xml->find_tags( "DomicilioFiscal", $Emisor );
			$RegimenFiscal = $this->xml->find_tags( "RegimenFiscal", $Emisor );
		}else{
			$Comprobante = $this->xml->find_tags( "cfdi:Comprobante" );
			$Emisor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Emisor" );
			$Receptor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Receptor" );
			$DomicilioFiscal = $this->xml->find_tags( "cfdi:DomicilioFiscal", $Emisor );
			$RegimenFiscal = $this->xml->find_tags( "cfdi:RegimenFiscal", $Emisor );
		}
		
	?>
		<div class="marco fondo_white pos_abs sombra" style="top:8mm; right: 11mm; width: 60mm; height: 50mm">
			<div style="text-align:center">
				<img src="<?=$this->link?>/__config/logo.png" height="15mm"/>
			</div>
			<div class="f1"><b><?=$Emisor['attr']['nombre']?></b></div>
			<div class="f2" style="height: 20mm">
				<?$this->v_domiclio( $DomicilioFiscal )?>
			</div>
			<div>RFC: <b><?=$Emisor['attr']['rfc']?></b></div>
			<div class="f2"><b>Régimen Fiscal:</b><?=$RegimenFiscal['attr']['Regimen']?></div>
		</div>
	<!-- 
	<div class="marco fondo_gris pos_abs" style="top:8mm; right: 12mm; width: 45mm;">Emisor</div>
	 -->
	<?
	}
	
	
	function v_domiclio( $Domicilio ){
		?>
			<b>Calle</b> <?=$Domicilio['attr']['calle']?> <b>Exterior</b> <?=$Domicilio['attr']['noExterior']?> 
			<?if( $Domicilio['attr']['noInterior'] != "" && $Domicilio['attr']['noInterior'] != "." ){ echo ", <b>Interior</b> ".$Domicilio['attr']['noInterior'];}?>
			<?if( $Domicilio['attr']['colonia'] != "" ){ echo ", <b>Col.</b> ".$Domicilio['attr']['colonia'];}?>
			<?if( $Domicilio['attr']['municipio'] != "" ){ echo ", <b>Municipio</b> ".$Domicilio['attr']['municipio'];}?>
			<?if( $Domicilio['attr']['codigoPostal'] != "" ){ echo ", <b>C.P.</b> ".$Domicilio['attr']['codigoPostal'];}?>
			<?if( $Domicilio['attr']['localidad'] != "" && $Domicilio['attr']['noInterior'] != "." ){ echo ", <b>localidad</b> ".$Domicilio['attr']['localidad'];}?>
			,<b>Entidad</b> <?=$Domicilio['attr']['estado']?>
			, <b>País</b> <?=$Domicilio['attr']['pais']?>.
		<?
	}
	
	function v_receptor( ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$Receptor = $this->xml->find_tags( "Comprobante->Receptor" );
			$Domicilio = $this->xml->find_tags( "Domicilio", $Receptor );
		}else{
			$Receptor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Receptor" );
			$Domicilio = $this->xml->find_tags( "cfdi:Domicilio", $Receptor );
		}
	?>
	<div class="marco fondo_white pos_abs sombra f2" style="top:54mm; left: 11mm; width: 127mm; height: 27mm; ">
	</div>
	<div class="pos_abs f2" style="position: absolute; top:59mm; left: 12mm; width: 127mm; height: 22mm;">
		<b><?=$Receptor['attr']['nombre']?></b>
		<br>R.F.C:<b><?=$Receptor['attr']['rfc']?></b>
		<br><? $this->v_domiclio( $Domicilio )?>
	</div>
	<div class="marco fondo_gris pos_abs" style="top:53mm; left: 10mm; width: 127mm;">Facturado a: (Receptor)</div>
	<?
	}
	function v_expedicion( ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$ExpedidoEn = $this->xml->find_tags( "Comprobante->Emisor->ExpedidoEn" );
			$Domicilio = $this->xml->find_tags( "Domicilio", $Receptor );
			$pago = $this->xml->find_tags( "Comprobante->Addenda->pago" );
		}else{
			$ExpedidoEn = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Emisor->cfdi:ExpedidoEn" );
			$Domicilio = $this->xml->find_tags( "cfdi:Domicilio", $Receptor );
			$pago = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:pago" );
			
		}
		
		if( $ExpedidoEn['attr']['calle'] != "" || $_SESSION['limites']['notaria'] == "103df" ){
	?>
	<div class="marco fondo_white pos_abs sombra f2" style="top:61mm; right: 11mm; width: 60mm; height: 10mm; padding-top:0;">
		<b>Lugar de expedición:</b>
		<?if( $ExpedidoEn['attr']['calle'] != "" ){?>
			<? $this->v_domiclio( $ExpedidoEn )?>
		<?}else{
			$DomicilioFiscal = $this->xml->find_tags( "cfdi:DomicilioFiscal", $Emisor );
			$this->v_domiclio( $DomicilioFiscal );
		}?>
	</div>
	<? }?>
	
	<div class="marco fondo_white pos_abs sombra t_rig" style="padding:0; top:73mm; right: 11mm; width: 60mm; height: 8mm; padding-top:1mm; font:22px arial">
			<b>TOTAL:<u><i>$<?=number_format( floatval($pago['attr']['gtotal'] ),2)?></i></u></b>
	</div>
	<?
	}
	function v_totales( ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$Comprobante = $this->xml->find_tags( "Comprobante" );
			$Retenciones = $this->xml->find_tags( "Comprobante->Impuestos->Retenciones" );
			$Traslados = $this->xml->find_tags( "Comprobante->Impuestos->Traslados" );
			$pago = $this->xml->find_tags( "Comprobante->Addenda->minotaria->pago" );
			$Conceptos = $this->xml->find_tags( "Comprobante->Addenda->minotaria->Conceptos" );
		}else{
			$Comprobante = $this->xml->find_tags( "cfdi:Comprobante" );
			$Emisor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Emisor" );
			$Receptor = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Receptor" );
			$DomicilioFiscal = $this->xml->find_tags( "cfdi:DomicilioFiscal", $Emisor );
			$RegimenFiscal = $this->xml->find_tags( "cfdi:RegimenFiscal", $Emisor );
			$Retenciones = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Impuestos->cfdi:Retenciones" );
			$Traslados = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Impuestos->cfdi:Traslados" );
			$TimbreFiscalDigital = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Complemento->tfd:TimbreFiscalDigital" );
			$pago = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:pago" );
			$Conceptos = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:Conceptos" );
		}
	//calculamos la altura el cuadro de retenciones he impuestos
	$lineas = 8;
	$lineas += ($Comprobante['attr']['descuento'] > 0 ) ? 1 : 0;
	$lineas += count($Retenciones['childs']);
	$lineas += count($Traslados['childs']);
	$lineas = ($lineas > 5 ) ? 5 : $lineas;
	
	if( count($Traslados['childs']) == 0 ){
		$Traslados['childs'][0]['attr']['importe'] = 0 ;
		$Traslados['childs'][0]['attr']['impuesto'] = "IVA" ;
		$Traslados['childs'][0]['attr']['tasa'] = 16 ;
	}
	?>
	<div class="marco fondo_blanco pos_abs" style="top:135mm; right: 10mm; width: 30mm; height: <?=5*5.3?>mm">
	<table>	
		<tr>
			<td class="t_rig" style="width: 30mm">$<?=number_format( floatval($Comprobante['attr']['subTotal'] ),2)?></td> 
		</tr>
		<?
		/*Descuento*/
		if( $Comprobante['attr']['descuento'] > 0 ){
			?>
			<tr>
				<td class="t_rig">$<?=number_format( floatval($Comprobante['attr']['descuento'] ),2)?></td> 
			</tr>
			<?
		}
		/*Impuestos->Traslados*/
		for ($x = 0 ; $x < count($Traslados['childs']) ; $x++) {
			$tag = $Traslados['childs'][$x];
			?>
			<tr>
				<td class="t_rig">$<?=number_format( floatval($tag['attr']['importe'] ),2)?></td> 
			</tr>
			<?
		}
		/*Impuestos->Retenciones*/
		for ($x = 0 ; $x < count($Retenciones['childs']) ; $x++) {
			$tag = $Retenciones['childs'][$x];
			?>
			<tr>
				<td class="t_rig" style="color:tomato">-$<?=number_format( floatval($tag['attr']['importe'] ),2)?></td> 
			</tr>
			<?
		}
		?>
		<tr>
			<td class="t_rig"><u>$<?=number_format( floatval($Comprobante['attr']['total'] ),2)?></u></td> 
		</tr>
		<tr>
			<td class="t_rig">$<?=number_format( floatval($Conceptos['attr']['importe'] ),2)?></td> 
		</tr>
		<tr>
			<td class="t_rig"><b>$<?=number_format( floatval($pago['attr']['gtotal'] ),2)?></b></td> 
		</tr>
	</table>
	</div>
	<div class="marco fondo_gris pos_abs" style="top:135mm; right: 40mm; width: 20mm; height: <?=5*5.3?>mm">
	<table>	
		<tr>
			<td class="t_rig" style="width: w20mm">sub-total:</td> 
		</tr>
		<?
		/*Descuento*/
		if( $Comprobante['attr']['descuento'] > 0 ){
			?>
			<tr>
				<td class="t_rig">Descuento:</td> 
			</tr>
			<?
		}
		/*Impuestos->Traslados*/
		for ($x = 0 ; $x < count($Traslados['childs']) ; $x++) {
			$tag = $Traslados['childs'][$x];
			?>
			<tr>
				<td class="t_rig"><nobr><?=$tag['attr']['impuesto']?>_%<?=number_format($tag['attr']['tasa'],0)?>:</nobr></td> 
			</tr>
			<?
		}
		/*Impuestos->Retenciones*/
		for ($x = 0 ; $x < count($Retenciones['childs']) ; $x++) {
			$tag = $Retenciones['childs'][$x];
			?>
			<tr>
				<td class="t_rig" style="color:tomato">-Ret. <?=$tag['attr']['impuesto']?>:</td> 
			</tr>
			<?
		}
		?>
		<tr>
			<td class="t_rig">total:</td> 
		</tr>
		<tr>
			<td class="t_rig">Cta.Ter.:</td> 
		</tr>
		<tr>
			<td class="t_rig">G.TOT:</td> 
		</tr>
	</table>
	</div>
	<?if( $TimbreFiscalDigital['attr']['UUID'] != "" ){?>
	<div class="marco pos_abs t_cen" style="top:163mm; right: 10mm; width: 50mm;">
		<img src="<?=$this->link?>/apps/phpqrcode/miqr.php?data=re=<?=$Emisor['attr']['rfc']?>|rr=<?=$Receptor['attr']['rfc']?>|tt=<?=$Comprobante['attr']['total']?>|id=<?=$TimbreFiscalDigital['attr']['UUID']?>" height="35mm" width="35mm"/>
		<? 
		/*
		<?=$_SESSION['limites']['archivos']['direccion_web']?>
		 */
		?>
	</div>
	<?}?>
	<div class="marco fondo_blanco pos_abs" style="top:136mm; left: 11mm; width: 140mm; height:10mm; padding-top: 5mm;">
		( <?=$this->o_tx->DoubleToLetra( round((float)$Comprobante['attr']['total'],2), "", " pesos" )?> M.N. )
	</div>
	<div class="marco fondo_gris pos_abs" style="top:135mm; left: 10mm; width: 140mm;">
	Cantidad con letra:		
	</div>
	<?
	}
	function v_conceptos( ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$Conceptos = $this->xml->find_tags( "Comprobante->Conceptos" );
		}else{
			$Conceptos = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Conceptos" );
			
		}
	?>
	<div class="marco fondo_white pos_abs sombra f2" style="top:101mm; left: 11mm; width: 192mm; height: 25mm; padding-top: 6mm">
		<table>
		<?
		for ($x = 0 ; $x < count($Conceptos['childs']) ; $x++) {
			$tag = $Conceptos['childs'][$x];
		?>
			<tr>
				<td class="t_lef f10a" style="width: 23mm;"><?=$tag['attr']['unidad']?></td>
				<td class="t_lef f10a" style="width: 93mm;"><?=$tag['attr']['descripcion']?></td>
				<td class="t_rig f10a" style="width: 15mm;"><?=$tag['attr']['cantidad']?></td>
				<td class="t_rig f10a" style="width: 30mm;"><?=number_format( floatval($tag['attr']['valorUnitario'] ),2)?></td>
				<td class="t_rig f10a" style="width: 30mm;"><?=number_format( floatval($tag['attr']['importe'] ),2)?></td>
			</tr>
		<?
		}?>
		</table>
	</div>
	<div class="marco fondo_gris pos_abs f1" style="top:100mm; left: 10mm; width: 192mm;">
		<table>
			<tr>
				<td class="t_cen" style="width: 23mm;">U. Medida</td>
				<td class="t_cen" style="width: 93mm;">Descripción</td>
				<td class="t_cen" style="width: 15mm;">Cantidad</td>
				<td class="t_cen" style="width: 30mm;">Precio</td>
				<td class="t_cen" style="width: 30mm;">Importe</td>
			</tr>
		</table>
	</div>
	<?
	}
	function v_addenda(  $top = 0 ){
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$minotaria = $this->xml->find_tags( "Comprobante->Addenda->minotaria" );
			$Conceptos = $this->xml->find_tags( "Conceptos", $minotaria );
			$pago = $this->xml->find_tags( "pago", $minotaria );
			$rps = $this->xml->find_tags( "rps", $minotaria );
		}else{
			$minotaria = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria" );
			$Conceptos = $this->xml->find_tags( "racooAdd:Conceptos", $minotaria );
			$pago = $this->xml->find_tags( "racooAdd:pago", $minotaria );
			$rps = $this->xml->find_tags( "racooAdd:rps", $minotaria );
		}
		$this->v_addenda_referencia( );
		$top= ( $top*1 <= 0 )? 220: $top;
		if( (float)$Conceptos['attr']['importe'] > 0 ){
		?>
		<div class="pos_abs t_cen" style="top:<?=$top-12?>mm; left: 11mm; width: 738px; border-top: 1px solid #dfdfdf; font-size: 18px">
			<b>- - - PAGOS POR CUENTA DE TERCEROS (Cta.Ter.) - - -</b> 
		</div>
		<div class="marco fondo_white pos_abs sombra f2" style="top:<?=$top-4?>mm; left: 11mm; width: 192mm; height: 20mm; padding-top: 6mm">
			<table>
			<?
			for ($x = 0 ; $x < count($Conceptos['childs']) ; $x++) {
				$tag = $Conceptos['childs'][$x];
			?>
				<tr>
					<td class="t_lef f10a" style="width: 23mm;"><?=$tag['attr']['unidad']?></td>
					<td class="t_lef f10a" style="width: 88mm;"><?=$tag['attr']['descripcion']?></td>
					<td class="t_rig f10a"  style="width: 15mm;"><?=$tag['attr']['cantidad']?></td>
					<td class="t_rig f10a"  style="width: 30mm;"><?=number_format( floatval($tag['attr']['valorUnitario'] ),2)?></td>
					<td class="t_rig f10a"  style="width: 30mm;"><?=number_format( floatval($tag['attr']['importe'] ),2)?></td>
				</tr>
			<?
			}?>
			</table>
		</div>
		<div class="marco fondo_gris pos_abs f1" style="top:<?=$top-5?>mm; left: 10mm; width: 192mm;">
			<table>
				<tr>
					<td class="t_cen" style="width: 23mm;">U. Medida</td>
					<td class="t_cen" style="width: 88mm;">Descripción</td>
					<td class="t_cen" style="width: 15mm;">Cantidad</td>
					<td class="t_cen" style="width: 30mm;">Precio</td>
					<td class="t_cen" style="width: 30mm;">Importe</td>
				</tr>
			</table>
		</div>
		<div class="marco fondo_blanco pos_abs f2" style="top:<?=$top+24?>mm; left: 56mm; width: 87mm; height: 5mm">
			( <?=$this->o_tx->DoubleToLetra( number_format( floatval($Conceptos['attr']['importe'] ),2), "", " pesos" )?> M.N. )
		</div>
		<div class="marco fondo_gris pos_abs f2" style="top:<?=$top+24?>mm; left: 10mm; width: 43mm;">
		Cantidad con letra Cta.Ter.:		
		</div>
		<div class="marco fondo_blanco pos_abs t_rig" style="top:<?=$top+24?>mm; right: 10mm; width: 32mm;">
			<?=number_format( floatval($Conceptos['attr']['importe'] ),2)?>
		</div>
		<div class="marco fondo_gris pos_abs t_rig" style="top:<?=$top+24?>mm; right: 42mm; width: 25mm;">
			Total Cta.Ter.:
		</div>
		
		<?}
		if( isset($pago) && $_SESSION['limites']['notaria'] != "4df" ){
		?>
		<div class="marco fondo_blanco pos_abs t_rig" style="top:<?=$top+32?>mm; left: 37mm; width: 32mm;">
			$<?=number_format( floatval($pago['attr']['gtotal'] ),2)?>
		</div>
		<div class="marco fondo_gris pos_abs t_rig" style="top:<?=$top+32?>mm; left: 10mm; width: 26mm;">
			GRAN TOTAL:
		</div>
		<div class="marco fondo_blanco pos_abs t_rig" style="top:<?=$top+32?>mm; left: 96mm; width: 32mm; color: tomato;">
			-$<?=number_format( floatval($rps['attr']['importe'] ),2)?>
		</div>
		<div class="marco fondo_gris pos_abs t_rig" style="top:<?=$top+32?>mm; left: 72mm; width: 23mm; color: tomato;">
			ANTICIPOS:
		</div>
		<div class="marco fondo_blanco pos_abs t_rig" style="top:<?=$top+32?>mm; left: 161mm; width: 43mm; font-size: 18px">
			<b>$<?=number_format( floatval($pago['attr']['neto'] ),2)?></b>
		</div>
		<div class="marco fondo_gris pos_abs t_rig" style="top:<?=$top+32?>mm; left: 131mm; width: 30mm; font-size: 18px">
			Neto a Pagar:
		</div>
		
		<?
		}
		?>
		<div class="marco fondo_blanco pos_abs f2" style=" top:<?=$top+41?>mm; right: 65mm; width: 140mm; height: 12mm">
			<?if( $_SESSION['limites']['notaria'] != "4df" ){?>
			Neto a pagar: (<?=$this->o_tx->DoubleToLetra( mifloatval($pago['attr']['neto'],2), "", " pesos" )?> M.N. )
			<?}?>
			<div style='color:blue'>
				<b>NOTA: Usted cuenta con 15 días naturales a partir de la fecha de expedición de esta factura para solicitar algún cambio en los datos fiscales de la misma.</b>
			</div>			
		</div>
		<div class="marco fondo_blanco pos_abs f3 t_cen" style="top:<?=$top+41?>mm; right: 10mm; width: 50mm; height: 12mm">
		<br>
		<div style="border-bottom: 1px solid black;">.</div>
		FIRMA RECEPTOR
		</div>
		<?
	}
	
	function v_addenda_referencia(  $top = 0 ){
		$top = ( $top == 0 )? 84: $top;
		if( $this->xml->assoc[0]['tag'] == "Comprobante" ){
			$minotaria = $this->xml->find_tags( "Comprobante->Addenda->minotaria->notaria" );
			$expedientes = $this->xml->find_tags( "Comprobante->Addenda->minotaria->expedientes" );
		} else {
			$minotaria = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:notaria" );
			$expedientes = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:expedientes" );
			$recibos = $this->xml->find_tags( "cfdi:Comprobante->cfdi:Addenda->racooAdd:minotaria->racooAdd:c_recibos" );
		}
	?>
		<div class="marco fondo_white pos_abs f2" style="top:<?=$top?>mm; left: 23mm; width: 180mm; height: 13mm;">
			<div class="f3"><b><?=$minotaria['attr']['referencia']?></b></div>
			<?
				for ($x = 0 ; $x < count($expedientes['childs']) ; $x++) {
			        $tag = $expedientes['childs'][$x];
			        $let_exp = "Exp.";
			        $let_esc = "Esc.";
			        if( $_SESSION['limites']['notaria'] == "99df" ){
				        $let_exp = "";
				        $let_esc = "";
				        $tag['attr']['abogado'] = "";
			        }
			        ?>
			        <span class="f2">
			        	<nobr>
			        		<?=$tag['attr']['abogado']?> <?=$let_exp?> <b><?=$tag['attr']['nombre']?></b>   
			        		<?=($tag['attr']['escritura'] > 0 )? $let_esc." <b>".$tag['attr']['escritura']."</b>": ""?> 
			        		(<?=$tag['attr']['operacion']?>)
			        	</nobr>
			        </span>
			        <?
				}?>
				<?
				if( $_SESSION['limites']['notaria'] != "99df" ){
					for ($x = 0 ; $x < count($recibos['childs']) ; $x++) {
				        $tag = $recibos['childs'][$x];
				        ?><span class="f3"><nobr><?=$tag['attr']['folio']?></nobr></span><?
					}
				}
			?>
		</div>
		<div class="marco fondo_gris pos_abs" style="top:<?=$top?>mm; left: 10mm; width: 10mm; height: 13mm">obs</div>
	<?
	}
}
?>