	<style>
		h1, h2 { padding: 0; margin: 0;}
		div.principal{
			font: 12px monospace;
			position: relative;
			width: 750px;
			height:450px;
			text-transform: uppercase;
		}
		div.principal div.contenido{
			font: 12px monospace;
			position: absolute;
			width: 700px;
			left: 50px;
			top: 200px;
			
		}
		.t_rig { text-align: right; }
	</style>
	<div class="principal">
		<div class="">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td valign="top">
					<?
						$plantilla = '../__config/caja/datos_notaria';
						$plantilla_personal = $plantilla.'_'.$_SESSION['limites']['notaria'];
						if(	is_file( $plantilla_personal.'.php' ) )
							include( $plantilla_personal.'.php' );
						?>
					</td>
					<td valign="top">
						<h1 class="t_rig"><?=$arr['nombre_recibo']?></h1>
						<h2 class="t_rig">no. <?=$no_largo?> <?=$arr['serie']?></h2>
					</td>
				</tr>
			</table>
		</div>
		<div class="contenido">
			<div>recibí de: <b><?=$arr['nombre']?></b></div>
			<div>la cantidad de: <b>$<?=number_format( $arr['monto'], 2 )?></b></div>
			<div><i><?="(".$this->f_tx()->DoubleToLetra( $this->f_mt()->StrToDouble( $arr['monto'], 2 ), 0, " pesos" )." M.N.)"?></i></div>
			<div>Por concepto de <b><?=$arr['concepto']?></b> para el trámite del expediente No.
				<b><?=$arr_exp['expediente']?></b>
			</div>
			<div>Operación: <b><?=$arr_exp['operacion']?></b> </div>
			<div>
				Escritura no.: <b><?=$arr_exp['escritura']?></b> 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RD:____________
			</div>
			<div>Si la operación que ampara este recibo, no se concluye por razones ajenas a nosotros,  
			el importe del mismo se utilizará para cubrir los gastos que la operación hubiera devengado.
			</div>
			<div>Este recibo no surtirá efectos fiscales.</div>
			<table width="100%">
				<tr>
					<td width="30%">
						<div>folio:<?=$no_largo?> <?=$arr['serie']?></div>
						<div>exp:<?=$arr_exp['expediente']?></div>
						<div>(<?=$arr['usuario']?>)</div>
						<?=$arr['partidas']?>
					</td>
					<td width="70%" align="right">
						<nobr>
						<?
							if( $arr['notario']['direccion']['entidade_id'] == 9 )
								echo "México, D.F. ";
							else
								echo strtoupper( substr( $arr['notario']['direccion']['delegacion'],0,1 ) ).substr($arr['notario']['direccion']['delegacion'],1).", ".$arr['notario']['direccion']['ent'];
						?>, a  <b><?=$this->f_tx()->fecha_mes($arr['fecha'])?></b>
						</nobr>
						<br/>
						<br/>
						<br/>
						<br/>
						<div>___________________________________________________</div>
						<center>R  E  C  I  B  I</center>
					</td>
				</tr>
			</table>
			<div>
			</div>
		</div>
	</div>
