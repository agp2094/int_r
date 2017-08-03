<div>
	<center><h3>SOLICITUD DE COPIAS CERTIFICADAS</h3></center>
	<table width="700px" align="center">
		<tr>
			<td style="text-align: right;">ORDEN DE TRABAJO NO.</td>
			<td style="border-bottom: 1px dotted black;"><?=$row['no_registro']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">FECHA DE RECEPCION:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2"><?=$row['fecha_recepcion']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">FECHA DE ENTREGA:</td>
			<td style="border-bottom: 1px dotted black;"><?=$row['fecha_entrega']?></td>
			<td><?=( $row['urgencia'] == "urgente" )?"<span style='background-color:tomato; color:white;'>URGENTE ( x )</span> ORDINARIO ( &nbsp; )":"URGENTE ( &nbsp; ) ORDINARIO ( x )";?></td>
		</tr>
		<tr>
			<td style="text-align: right;">SOLICITANTE:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2"><?=$row['nombre1']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">RECIBO A NOMBRE DE:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2"><?=$row['nombre2']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">DOMICILIO:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2"><?=stristr($row['domicilio'],'sin calle')?"-":$row['domicilio']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">R.F.C.:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2"><?=$row['rfc']?>&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align: right;">NO. DE DOCUMENTOS:</td>
			<td style="border-bottom: 1px dotted black; text-align: right;"><?=$row['no_documentos']?></td>
		</tr>
		<tr>
			<td style="text-align: right;">NO. DE COPIAS CERTIFICADAS:</td>
			<td style="border-bottom: 1px dotted black; text-align: right;"><?=$row['no_copias']?></td>
		</tr>
		<? if( $row['observaciones'] != "" ){ ?>
		<tr>
			<td style="text-align: right; vertical-align: top;"><b>OBSERVACIONES:</b></td>
			<td style="border: 1px dotted black;" colspan="2"><?=str_replace(chr(10),'<br>',$row['observaciones'])?></td>
		</tr>
		<?} ?>
		<tr>
			<td style="text-align: right;">HONORARIOS:</td>
			<td style="border-bottom: 1px dotted black;" colspan="2">
				 <b>$<?=$row['honorarios']?></b>
				<?=$this->obj_calcula_desglose( $row['honorarios'], 0, $row['nombre2'], $row['genero'] )?>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">ABOGADO:</td>
			<td style="border-bottom: 1px dotted black;"><?=$row['abogado']?></td>
		</tr>
		<?
		$sql = "select valor, fecha, usuario from bitacoras B, usuarios U 
				where U.usuario_id = B.usuario_id 
					and tabla ='cotejos' and campo='estatus' and tabla_id = ".$this->http['key']['cotejo_id']." order by fecha";
		$res = $this->sql_query( $sql );
		while ( $row_2 = mysql_fetch_array( $res )  ) {
			?><tr>
				<td style="text-align: right;"><?=strtoupper( $row_2['valor']." por:" )?></td>
				<td style="border-bottom: 1px dotted black;"><?=$row_2['usuario']?> ( <?=$row_2['fecha']?> )</td>
			</tr><?
		}
		include_once "../notaria/abogados_obj.php";
		$abo = new abogados_obj();
		$row_not = $abo->notario();
		?>
	<tr>
		<td colspan="3">
			<div style="font-weight: bold; text-transform: uppercase;">
				<ul>
					<li> FAVOR DE TRAER COPIA DE SU IDENTIFICACION FISCAL: (R.F.C.)</li>
					<?if( $row['genero'] == "persona moral" || strstr( $row['nombre2'], "." ) || strstr( $row['nombre2'], "," ) || strstr( strtolower( $row['nombre2'] ), "sociedad") || strstr( strtolower( $row['nombre2'] ), "grupo" )  ){ 
						if( $row['retencion'] != "no" ){?>
						<li> FAVOR DE TRAER SU RETENCION DEL 10% DEL ISR. A NOMBRE <br>DEL LIC. <?=$row_not['nombre']?></li>
						<li> FAVOR DE TRAER SU RETENCION DE DOS TERCERAS PARTES (2/3) DEL IVA. A NOMBRE DEL LIC. <?=$row_not['nombre']?></li>
						<?}
					}?>
				</ul>
			</div>
		</td>
	</tr>
	</table>
</div>