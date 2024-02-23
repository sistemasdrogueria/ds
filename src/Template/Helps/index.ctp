<div class="col-md-7">
    <div class="product-item-3"> 
		<div class="product-content3">
			<div class="row">
			<h3 align="center">Descarga de archivos</h3>
			<h5>Archivo de productos</h5>
			<p>Para descargar el archivo de producto <a href="/ds/webroot/file/articulos.zip"><b>haga click aqu&iacute;</b></a></p>
			<TABLE WIDTH="100%" >
                <TR> 
                    <TD WIDTH="250px" align="left" valign="top" ><div id="descripcion-campo"><B>FECHA Y HORA DEL ARCHIVO</B></div></TD>
                    <TD align="left" valign="top" class="texto">
                        <!--#config timefmt="%e del %m de %Y - %T" -->
                        &nbsp;&nbsp; &nbsp;
                        <?php
						$filename = 'file/articulos.zip';
							if (file_exists($filename)) {
								echo ''.date("d/m/Y H:i:s.", filemtime($filename));
							}
						?>  
						<!--#flastmod virtual="/ds/webroot/file/articulos.zip" -->
						&nbsp;</TD>
                </TR>
                <TR> 
                    <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>TAMA&Ntilde;O</B></div></TD>
                    <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;&nbsp;
                        <!--#fsize virtual="/ds/webroot/file/articulos.zip" -->
                        <?php
						if (file_exists($filename)) {
								echo ''. round(filesize($filename)/1024, 0)  .' KB';
							}
							?>  
						&nbsp;</TD>
                </TR>
            </TABLE><br>
		
		</div>

		<div class="row">
			<h5>Archivo de actualizaciones de precio</h5>
			<p><a href="/ds/webroot/file/aumentos.txt"><b>Haga clic aquí</b></a> con el botón derecho del mouse y elija la opción "Guardar enlace como" para bajar un archivo únicamente con las actualizaciones de precio.</p>
			<TABLE WIDTH="100%" >
                <TR> 
                    <TD WIDTH="250px" align="left" valign="top" ><div id="descripcion-campo"><B>FECHA Y HORA DEL ARCHIVO</B></div></TD>
                    <TD align="left" valign="top"class="texto" >
                        <!--#config timefmt="%e del %m de %Y - %T" -->
                        &nbsp; &nbsp;&nbsp; 
						<?php
						$filename = 'file/aumentos.txt';
							if (file_exists($filename)) {
								echo ''.date("d/m/Y H:i:s.", filemtime($filename));
							}
						?>  
						
                        <!--#flastmod virtual="/ds/webroot/file/aumentos.txt" --></TD>
                </TR>
                <TR> 
                    <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>TAMA&Ntilde;O</B></div></TD>
                    <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;&nbsp;<!--#fsize virtual="/ds/webroot/file/aumentos.txt" -->
                        <?php
						if (file_exists($filename)) {
								echo ''. round(filesize($filename)/1024, 0)  .' KB';
							}
							?> 
						&nbsp;</TD>
                </TR>
            </TABLE><br>
		</div>

    <div class="row">
	<h5>Archivo de descuentos Patagonia Med</h5>	
    <p><a href="/ds/webroot/file/descuentosptm.txt"><b>Haga clic aquí</b></a> con el botón derecho del mouse para descargar el archivo de descuentos de Patagonia Med.</p>
        <TABLE WIDTH="100%" >
                          <TR> 
                            <TD WIDTH="250px" align="left" valign="top" ><div id="descripcion-campo"><B>FECHA Y HORA DEL ARCHIVO</B></div></TD>
                            <TD align="left" valign="top" class="texto">  <!--#config timefmt="%e del %m de %Y - %T" -->
                              &nbsp;&nbsp;&nbsp;
							   <?php
							$filename = 'file/descuentosptm.txt';
							if (file_exists($filename)) {
								echo ''.date("d/m/Y H:i:s.", filemtime($filename));
							}
							?>  
                              <!--#flastmod virtual="/ds/webroot/file/descuentosptm.txt" -->
                              &nbsp;</TD>
                          </TR>
                          <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>TAMA&Ntilde;O</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp; 
                              <!--#fsize virtual="/ds/webroot/file/descuentosptm.txt" -->
                              <?php
						if (file_exists($filename)) {
								echo ''. round(filesize($filename)/1024, 0)  .' KB';
							}
							?> 
							  &nbsp;</TD>
                          </TR>
                        </TABLE>
		
	</div>
</div>
</div>	
	</div>
<div class="col-md-5">
    <div class="product-item-3"> 
		<div class="product-content3">	

	<div class="row">
	<h3 align="center">Descarga del Sistema de Pedidos</h3>
	<h5>Actualización del Sistema de Pedidos</h5>	
    <p><a href="/ds/webroot/soft/drosur-setup.exe"><b>Haga clic aquí</b></a> para bajar el archivo con la actualización. Si desea ver las instrucciones para ejecutar la actualización, <a href="#"><b>haga clic aquí</b></a></p>
        <TABLE WIDTH="100%" >
                          <TR> 
                            <TD WIDTH="250px" align="left" valign="top" ><div id="descripcion-campo"><B>FECHA Y HORA DEL ARCHIVO</B></div></TD>
                            <TD align="left" valign="top"class="texto" > <!--#config timefmt="%e del %m de %Y - %T" -->
                              &nbsp;&nbsp;&nbsp;
                              <!--#flastmod virtual="/ds/webroot/soft/drosur-setup.exe" -->
                              <?php
							$filename = 'soft/drosur-setup.exe';
							if (file_exists($filename)) {
								echo ''.date("d/m/Y H:i:s.", filemtime($filename));
							}
							?>    
							  &nbsp;</TD>
                          </TR>
                          <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>TAMA&Ntilde;O</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp; 
                              <!--#fsize virtual="/ds/webroot/soft/drosur-setup.exe" -->
                              <?php
						if (file_exists($filename)) {
								echo ''. round(filesize($filename)/1024, 0)  .' KB';
							}
							?> 
							  &nbsp;</TD>
                          </TR>
                           <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>VERSION DEL UPGRADE</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp; 
                              2.7</TD>
                          </TR>
                           <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>VERSION ACTUALIZABLE</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;&nbsp;2.1 a 2.6</TD>
                          </TR>
                        </TABLE><br>
		
	</div>

	<div class="row">
	
	<h5>Sistema de Pedidos</h5>	
    <p><a href="/ds/webroot/soft/SPedidos2_7.exe"><b>Haga clic aquí</b></a> con el botón derecho del mouse y elija la opción "Guardar destino como" para bajar el archivo.</p>
        <TABLE WIDTH="100%" >
                          <TR> 
                            <TD WIDTH="250px" align="left" valign="top" ><div id="descripcion-campo"><B>FECHA Y HORA DEL ARCHIVO</B></div></TD>
                            <TD align="left" valign="top"class="texto" >
							&nbsp;&nbsp; &nbsp;
							<?php
							$filename = 'soft/SPedidos2_7.exe';
							if (file_exists($filename)) {
								echo ''.date("d/m/Y H:i:s.", filemtime($filename));
							}
							?>

                                <!--#config timefmt="%e del %m de %Y - %T" -->
                              <!--#flastmod virtual="/ds/webroot/soft/SPedidos2_7.exe" -->
                              &nbsp;</TD>
                          </TR>
                          <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>TAMA&Ntilde;O</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;<!--#fsize virtual="/ds/webroot/soft/SPedidos2_7.exe" -->
						                         
							 &nbsp;</TD>
                          </TR>
          <TR> 
          <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>VERSION DEL UPGRADE</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;&nbsp;2.7</TD>
          </TR>
                           <TR> 
                            <TD WIDTH="200px" align="left" valign="top" ><div id="descripcion-campo"><B>VERSION ACTUALIZABLE</B></div></TD>
                            <TD align="left" valign="top" class="texto">&nbsp;&nbsp;&nbsp;&nbsp;2.1 a 2.6</TD>
                          </TR>
                          </TR>
        </TABLE><br>
		
		</div>
	</div>


  </div>		

</div>		
<div class="col-md-7">
    <div class="product-item-3"> 
		<div class="product-content3">
			<div class="row">
			<h3 align="center">Otras descargas</h3>		
			<h5>Archivos de Cuentas Corrientes</h5>	
		    <br>
			   <div id="descripcion-campo"><a href="/ds/webroot/file/macro%20servicio%20electronico%20cobranzas.jpg" target="_blank"><B>Descargar ejemplo de boleta de depósito del Banco Macro</B></a></div>
			   <div id="descripcion-campo"><a href="/ds/webroot/file/Ticket%20de%20recaudacion.xls" target="_blank"><B>Descargar ticket de recaudación del Banco Patagonia</B></a></div>
		</div>

	</div>


  </div>		

</div>

<div class="col-md-5">
    <div class="product-item-3"> 
		<div class="product-content3">
			<div class="row">
			<h3 align="center">Descargas de Formatos</h3>		
			<h5>Formatos de Archivos</h5>	
		    <br>
			   <div id="descripcion-campo"><a href="/ds/webroot/file/" target="_blank"><B>Descargar </B></a></div>
			   <div id="descripcion-campo"><a href="/ds/webroot/file/" target="_blank"><B>Descargar </B></a></div>
		</div>

	</div>


  </div>		

</div>