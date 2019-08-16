<?php 
/*
*    GetRepoDrake: 
*------------------------------------------------------------------------------------------------------------------
*    Herramienta que permite obtener los repositorios provistos por las diferentes 
*     comunidades  de usuarios de Mandriva Linux, de una forma sencilla y rápida, 
*     para agregarlos a nuestro sistema.
*----------------------------------------------------------------------------------------------------------------
*    Copyright (C)  2010  Fernando Anthony Ristaño ( Drakor ), 
*    2012  José Alberto Valle Cid ( katnatek ), blogdrake.net
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

/***
Descargar el archivo browscap.ini para poder identificar y clasificar el browser correctamete
Ademas verificar la configuracon del php.ini para que lo ubique
 ***/ 
//error_reporting(); //Browscap.php genera un error que no presenta problema,

/*require 'inc/Browscap.php'; //Desactivo browscap, por problemas de permisos en los 
$bc = new Browscap('inc/cache'); //directorios :(
$current_browser = $bc->getBrowser();*/
require ('../recursos/translate.php');/*Manejo del idioma*/
$s_locales=array('en'=>'English', 'es'=>'Español','br'=>'Português do Brasil','fr'=>'French');
Inicializa_Idioma_folder ('lang/');
require ('piepagina.php');

//Impresion del encabezado xhtml comun

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"$locale\"><head>
<title>GetRepoDrake</title>
<link rel=\"shortcut icon\" href=\"favicon.ico\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<meta name=\"robots\" content=\"all\" />
<meta name=\"no-email-collection\" content=\"http://www.unspam.com/noemailcollection\" />
<meta name=\"description\" content=\"Get comunity repository.\" />
 <meta content=\"Fernando Anthony Ristaño\" name=\"author\" />";

//Selecciono el css dependiendo del motor del brower. Para los que lo soporten utilizo css3, caso contrario el css2.1 (menos atractivo) ;)

echo "<link rel=\"stylesheet\"  type=\"text/css\" title=\"styleCSS\" href=\"";
//if ($current_browser->CssVersion == 3){echo 'Estilo3.css';} else {echo 'Estilo.css';}
echo 'Estilo3.css';
echo "\" /></head><body> <div id=\"content\">";
//Selecciona Distribución
if (!isset($_POST['distro']) || !isset ($_POST['arch']))
{
  require('DistSel.php');
}
else
{
 //Muestro la pagina de selección de repositorios
  require('getRepo2.php');
 //}
}
//Impresion de pie de pagina y finalizacion xhtml

echo "<br />*"._T ("Si desea que se añada o quite algun repositorio").
' <a href="http://blogdrake.net/foros">'.
_T ("Pidalo en los foros de BlogDrake")."</a><br />\n".
_T ("Si quiere añadir o corregir una traducción").' '.
_T ("Lea").' <a href="http://blogdrake.net/node/25955">'._T ("Esto").'</a>'.
"<br />
$strColaboracion.$strInfo.$strLogos </div></div></body></html>";
