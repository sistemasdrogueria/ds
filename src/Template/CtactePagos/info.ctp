
<div class="col-md-9">
    <div class="product-item-3"> 
		<div class="product-content3">
		<h3 id="titulo_oferta" align="center">DATOS    DE CUENTAS BANCARIAS - DROGUERIA SUR</h3>
			<div class="row" align="center">
			<table border="1" cellpadding="0" cellspacing="0">
  <col width="107">
  <col width="162">
  <col width="100">
  <col width="161">
  <col width="232">
  <tr style ="font-weight:bold; background-color: #2a80b9;
color: #fff;">
    <td width="107" align="center" valign="middle">BANCO</td>
    <td width="153" align="center" valign="middle">TIPO DE CTA</td>
    <td width="100" align="center" valign="middle">SUCURSAL</td>
    <td width="170" align="center" valign="middle">Nº CTA</td>
    <td width="197" align="center" valign="middle">CBU</td>

  </tr>
  <tr>
    <td align="center" valign="middle">MACRO</td>
    <td align="center" valign="middle">CTA CTE ESPECIAL</td>
    <td align="center" valign="middle">593</td>
    <td align="center" valign="middle">4-593-0940408490-6</td>
    <td align="center" valign="middle">2850593040094040849068</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">CREDICOOP</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">127</td>
    <td align="center" valign="middle">067474/2</td>
    <td align="center" valign="middle">1910127155012706747428</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">PATAGONIA</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">53</td>
    <td align="center" valign="middle">539996460</td>
    <td align="center" valign="middle">0340053100539996460009</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">PROVINCIA</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">6229</td>
    <td align="center" valign="middle">27746/0</td>
    <td align="center" valign="middle">0140305101622902774600</td>
  
  </tr>
  <tr>
    <td align="center" valign="middle">NACION</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">1130</td>
    <td align="center" valign="middle">13000524/87</td>
    <td align="center" valign="middle">0110130620013000524874</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">GALICIA</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle"></td>
    <td align="center" valign="middle">11859-0 082-1</td>
    <td align="center" valign="middle">0070082520000011859011</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">CHUBUT</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">30</td>
    <td align="center" valign="middle">030-20714300101</td>
    <td align="center" valign="middle">0830030001002071430013</td>
    
  </tr>
  <tr>
    <td align="center" valign="middle">CHUBUT</td>
    <td align="center" valign="middle">CTA CTE</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">0830030011001090007881</td>
    
  </tr>

 

  <tr style ="font-weight:bold; background-color: #2a80b9;color: #fff;">
    <td colspan="5" align="center" valign="middle">RAZON SOCIAL: DROGUERIA SUR S.A.</td>
  </tr>
  <tr style ="font-weight:bold; background-color: #2a80b9;color: #fff;">
    <td colspan="5" align="center" valign="middle">CUIT Nº:    30-70952251-1</td>
  </tr>
</table>



			</div>
			  
			
		</div>
	</div>	

    <div class="product-item-3"> 
		<div class="product-content3">
    <?php
    echo $this->Html->link(
    $this->Html->image('banner_hacete_pyme.jpg', ["alt" => "BANCO GALICIA"]),
    "https://hacetegalicia.bancogalicia.com.ar/negociosypymes/?t=pymes&utm_content=hacetenyp&utm_source=drogueriasur&utm_medium=landingdrogueria&utm_campaign=banner",
    ['escape' => false,'target' => '_blank']
);
 //echo $this->Html->image('banner_hacete_pyme.jpg',['title' => 'BANCO GALICIA','url'=>['https://hacetegalicia.bancogalicia.com.ar/negociosypymes/?t=pymes&utm_content=hacetenyp&utm_source=drogueriasur&utm_medium=landingdrogueria&utm_campaign=banner']]); ?>		

</div>
	</div>	
</div>

<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content3">	
			<h4><?php echo 'TARJETAS DE DEPOSITOS';?></h4>
     
			<div class="row">	
      Para solicitar tarjeta de depósito haga clic.
        <br><br>
        <?php echo $this->Html->image('logos/logo_b_credicoop.png',['title' => 'BANCO CREDICOOP','url'=>['controller' => 'CtactePagos','action' => 'enviarsolicitud',1 ]]); ?>		
        <br><br>
        <?php echo $this->Html->image('logos/logo_b_nacion.png',['title' => 'BANCO NACIÓN','url'=>['controller' => 'CtactePagos','action' => 'enviarsolicitud',2 ]]); ?>
      </div>	
      <h4><?php echo 'TARJETA PACTAR DE BANCO PROVINCIA';?></h4>
     
			<div class="row">	
      Para solicitar tarjeta Pactar de Banco Provincia haga clic.
        <br><br>
        <?php echo $this->Html->image('logos/logo_b_pactar.png',['title' => 'TARJETA PACTAR BANCO PROVINCIA','url'=>['controller' => 'CtactePagos','action' => 'enviarsolicitud',4 ]]); ?>		
      </div>	
    <!-- /div>	
    <div class="product-content3" -->	
			<h4><?php echo 'TARJETA PATAGONIA DISTRIBUTION';?></h4>
     
			<div class="row">	
      Para solicitar tarjeta de crédito Patagonia Distribution haga clic.
        <br><br>
        <?php echo $this->Html->image('logos/logo_b_patagonia.png',['title' => 'BANCO PATAGONIA DISTRIBUTION','url'=>['controller' => 'CtactePagos','action' => 'enviarsolicitud',3 ]]); ?>		
        <br><br>
        </div>
        <h4><?php echo 'TALONARIO DE INTERDEPÓSITOS COBINPRO';?></h4>
        <div class="row">	
      Para solicitar talorario de interdepositos Cobinpro haga clic.
        <br><br>
        <?php echo $this->Html->image('logos/logo_b_provincia.png',['title' => 'BANCO PROVINCIA - COBINPRO','url'=>['controller' => 'CtactePagos','action' => 'enviarsolicitud',5 ]]); ?>		
        <br><br>
        </div>

      	
		</div>			
  </div>		
</div>	