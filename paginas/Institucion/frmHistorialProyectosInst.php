<?php
//Historial de proyectos presentado por Instituciones
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==5)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */

$query="select idproyecto, pi.idpropuesta, nomproyecto, descripcionpropuesta,estadoprop, comentarioprop 
from 
(select idpropuesta, nomproyecto, descripcionpropuesta,estadoprop, comentarioprop 
from propuesta_proyecto pp 
join institucion i on pp.idinstitucion=i.idinstitucion 
where i.idinstitucion=".$_SESSION['IDUSER']." 
EXCEPT
select pp.idpropuesta, nomproyecto, descripcionpropuesta,estadoprop, comentarioprop 
from propuesta_proyecto pp join hace h on pp.idpropuesta=h.idpropuesta) pi
left join se_convierte sc on (pi.idpropuesta=sc.idpropuesta); "; 
$resul=pg_query($query); 
?>

<script type="text/javascript" 	 src="../../js/funciones.js"></script>
<style>.tinytable{width: 90%;}</style>
<form  action="" method="post" accept-charset="LATIN1" name="frmc_institucion" id="frmc_institucion">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td align="center"><h2>HISTORIAL PROPUESTAS DE PROYECTOS</h2>
			  	</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>
			<tr>
				<td>
					<?php					
					
					if(pg_num_rows($resul)>0){
					?>
					<h3 align="center">Click en los datos de un proyecto aprobado, para ver sus detalles.</h3>
					<table align="center" class="marco" width="90%">
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<tr>
							<td>
								<span class="subtitulo2">Buscar</span>
								<select id="columns" onchange="sorter.search('query')"></select>
								<input type="text" id="query" onkeyup="sorter.search('query')"/>
							</td>
							<td>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<td align="right" class="subtitulo2">
								Registros
								<span id="startrecord"></span>-<span id="endrecord"></span> de <span id="totalrecords"></span>
							</td>
						</tr>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<tr>
							<td height="119" colspan="3" align="center">
								<table cellpadding="0" cellspacing="0" id="table" class="tinytable">
									<thead class="titulo1">
										<tr>
											<th onMouseOver="toolTip('Ordenar por Proyecto',this)" width="25%"><h3>Proyecto</h3></th>
											<th onMouseOver="toolTip('Ordenar por Descripcion',this)" width="40%"><h3>Descripcion</h3></th>
											<th onMouseOver="toolTip('Ordenar por Estado',this)" width="10%"><h3>Estado</h3></th>
											<th onMouseOver="toolTip('Ordenar por Comentarios',this)" width="25%"><h3>Comentarios</h3></th>
										</tr>
									</thead>
									<tbody class="subtitulo2">
										<?php
										while ($row = pg_fetch_array($resul)){
										if($row['estadoprop']=="A"){
										?>
										<tr align="center">
										
											<td><a title='Ver detalles del proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmDetallesProyectosInst.php?id=<?php echo $row[0];?>'"><?php echo $row['nomproyecto'];?></a></td>
											<td><a title='Ver detalles del proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmDetallesProyectosInst.php?id=<?php echo $row[0];?>'"><?php echo $row['descripcionpropuesta'];?></a></td>
											<td><a title='Ver detalles del proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmDetallesProyectosInst.php?id=<?php echo $row[0];?>'">
											<?php
											if($row['estadoprop']=="P")
											echo "Pendiente Aprobaci&oacute;n";
											
											if($row['estadoprop']=="A")
											echo "Aprobado";
											
											if($row['estadoprop']=="R")
											echo "Rechazado";
											
											echo "</a>";?></td>
											<td><a title='Ver detalles del proyecto' style='color: black;' href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='frmDetallesProyectosInst.php?id=<?php echo $row[0];?>'"><?php echo $row['comentarioprop'];?></a></td>
										
										</tr>
										<?php
										}//if
										if($row['estadoprop']=="P"||$row['estadoprop']=="R"){
										?>
										<tr align="center">
										
											<td><?php echo "<p title='No hay detalles del proyecto' style='color: black;' >".$row['nomproyecto']."</a>";?></td>
											<td><?php echo "<p title='No hay detalles del proyecto' style='color: black;' >".$row['descripcionpropuesta']."</a>";?></td>
											<td><?php echo "<p title='No hay detalles del proyecto' style='color: black;' >";
											
											if($row['estadoprop']=="P")
											echo "Pendiente Aprobaci&oacute;n";
											
											if($row['estadoprop']=="A")
											echo "Aprobado";
											
											if($row['estadoprop']=="R")
											echo "Rechazado";
											
											echo "</a>";?></td>
											<td><?php echo "<p title='No hay detalles del proyecto' style='color: black;' >".$row['comentarioprop']."</a>";?></td>
										
										</tr>
										<?php
										}//if
										
										}//while
										?>
									</tbody>
								</table>
							</td>
						</tr>
						<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
						<tr>
							<td>
								<span id="tablenav">
									<img src="../../imagenes/mostrar_primero.png"  alt="Primera Pagina" onMouseOver="toolTip('Ir a la primera pagina',this)" onClick="sorter.move(-1,true)" class="manita">
									<img src="../../imagenes/mostrar_anterior.png"  alt="Anterior Pagina" onMouseOver="toolTip('Ir a la pagina anterior',this)" onClick="sorter.move(-1)" class="manita">
									<img src="../../imagenes/mostrar_siguiente.png"  alt="Siguiente Pagina" onMouseOver="toolTip('Ir a la pagina siguiente',this)" onClick="sorter.move(1)" class="manita">
									<img src="../../imagenes/mostrar_ultimo.png"  align="top" alt="Ultima Pagina" onMouseOver="toolTip('Ir a la ultima pagina',this)" onClick="sorter.move(1,true)" class="manita">								
									<select id="pagedropdown" onMouseOver="toolTip('Seleccionar pagina',this)"></select>
									<span class="subtitulo2"><a href="javascript:sorter.showall()" onMouseOver="toolTip('Ver todos los registros',this)">Ver todos</a></span>
								</span>
							</td>
							<td>
								
								<img src="../../imagenes/icono_recargar.png" align="top" onClick="redireccionar('frmHistorialProyectosInst.php');" onMouseOver="toolTip('Actualizar',this)" class="manita">
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al Inicio',this)" class="manita">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<td id="tablelocation">
								<span class="subtitulo2">Entradas por pagina</span>
								<select onchange="sorter.size(this.value)" onMouseOver="toolTip('Cantidad de registros a mostrar',this)">
									<option value="5">5</option>
									<option value="10" selected="selected">10</option>
									<option value="20">20</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
								<span class="subtitulo2">
									Pagina <span id="currentpage"></span> de <span id="totalpages"></span>
								</span>
							</td>
						</tr>
					</table>
					<?php } else{ ?>
					<h2 align="center" class="encabezado2"><img src="../../imagenes/exit.png"><br>NO SE PUDO GENERAR LA LISTA DE PROYECTOS!!</h2>
					<table align="center" class="alerta error centro">
						<tr>
							<td align="center" colspan="3">
									Aun no envia propuestas de proyectos.<br><br>					
								<img src="../../imagenes/icono_cancelar.png" align="top" onClick="redireccionar('../Inicio/plantilla_pagina.php')" onMouseOver="toolTip('Cancelar, volver al Inicio',this)" class="manita">
							</td>
						</tr>
					</table>
					<?php } ?>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<script type="text/javascript" src="../../js/tinytable.js"></script>
		                        <script type="text/javascript" src="../../js/tinytable.options.js"></script>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<span id="toolTipBox"></span>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
				</td>
			</tr>
<!------------------------------------------------------------------------------------------------------------------------>				
		</table>
                </form>
                <br><br>







<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>