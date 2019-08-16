<?php
/*
*    GetRepoDrake: 
*------------------------------------------------------------------------------------------------------------------
*    Herramienta que permite obtener los repositorios provistos por las diferentes 
*     comunidades  de usuarios de Mandriva Linux, de una forma sencilla y rápida, 
*     para agregarlos a nuestro sistema.
*----------------------------------------------------------------------------------------------------------------
*    Copyright (C)  2012  José Alberto Valle Cid ( katnatek ), blogdrake.net
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License as
*    published by the Free Software Foundation, either version 3 of the
*    License, or (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*
*/
//Creo la fila de idiomas disponibles
echo '<table class="banderas" ><tbody><tr>';

foreach ($s_locales as $cod => $tit)
{
  echo '<td class="banderas"><a href="?lang='.$cod.'"><img src="lang/'.$cod.
'.png" style=\'border:0;\' alt="'.$tit.'" title="'.$tit.'"/></a></td>';
}
echo '</tr></tbody></table><a href="index.php"><div id="title"></div></a>';
require ('../recursos/manejo-clases.php');
require ('../recursos/manejo-formulario.php');
?>

<h2><?php echo _T ("Obtenga la lista de repositorios Comunitarios de OpenMandriva y Mageia Linux."); ?></h2>
<?php
require ("formularios.php");
if (!isset ($_POST['distro']))
 {
   /* Se presenta el formulario integrado a navegadores que lo
    * soporten*/
   if (stripos ($_SERVER["HTTP_USER_AGENT"],"chrome")=== FALSE &&
	   stripos ($_SERVER["HTTP_USER_AGENT"],"firefox")=== FALSE &&
       stripos ($_SERVER["HTTP_USER_AGENT"],"opera")=== FALSE &&
       stripos ($_SERVER["HTTP_USER_AGENT"],"midori")=== FALSE)
	 parte1 ();
   else
     fIntegrado ();
 }
else if (!isset ($_POST['arch']))
 parte2 ();
?>
