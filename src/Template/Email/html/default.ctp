<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<div class="container">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" >
<?php
$direc='http://www.drogueriasur.com.ar/ds'; 
?>
  <tr>
      <td height="160" colspan="2">
    
	<img src="<?php echo $direc.'/webroot/img/logo.png';?>" alt='Drogueria Sur S.A.' 
	style= "font-family: Georgia, Times New Roman, serif; font-size: 24px; color: #fff;"/>
    
    </td>
  </tr>

    <td>
    <div style="border-width: 2px; border-style: solid; border-color: #666; font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
    <table width="690" border="0" align="center" cellpadding="0" cellspacing="0" >

      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="font-weight:bold;">
        
        <span>Nombre: </span>
        <span style="font-weight:bold; font-size: 18px;">
        <?php
        echo $nombre;
        ?>
        </span>
        <br/>
        <span>Email: </span>
        <span style="font-weight:bold; font-size: 16px;">
        <?php
        
        echo $correo;
        ?>
        </span>
		<br/>
        <span>Telefono: </span>
        <span style="font-weight:bold; font-size: 16px;">
        <?php
        
        echo $telefono;
        ?>
        </span>
		<br/>
        <span>Hora: </span>
        <span style="font-weight:bold; font-size: 16px;">
        <?php
        
        echo date("d-m-Y H:i:s");
        ?>
        </span>
        </td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td width="21" height="44">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td width="21">&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" >
        <span style="font-weight:bold; text-decoration: underline; font-size: 16px;">
        Consulta:<br/>
        </span>
        <br/>
          <?php
        $texto = nl2br($content);
        $lineas = explode  ( '<br/>'  , $texto );

        foreach ($lineas as $k => $v) {
        echo $v;
        echo '<br/>';
        }  
        ?>
      
      </td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>    
        
      </tr>


    </table>
    </div>
    </td>
    
</tr>
 
  <tr>
    <td></td>
  </tr>
  <tr>
    <td align="left">

	</td>
  </tr>


  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  
</table>

<!-- end .container --></div>