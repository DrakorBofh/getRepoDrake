<?php
/*
*    GetRepoDrake: 
*------------------------------------------------------------------------------------------------------------------
*    Herramienta que permite obtener los repositorios provistos por las diferentes 
*     comunidades  de usuarios de Mandriva Linux, de una forma sencilla y rápida, 
*     para agregarlos a nuestro sistema.
*----------------------------------------------------------------------------------------------------------------
*    Copyright (C)  2010  Fernando Anthony Ristaño ( Drakor ), blogdrake.net
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
//Seleccion del idioma
//require('../translate.php');
require ('../../recursos/translate.php');/*Manejo del idioma*/
$s_locales=array('en'=>'English', 'es'=>'Español','br'=>'Português do Brasil','fr'=>'French');
Inicializa_Idioma_folder ('../lang/');
require('../piepagina.php');
//Muestro el form de seleccion de distribución
if (!isset($_GET['distro']) || !isset ($_GET['arch']))
{
	require ('../../recursos/def-comunes.php');
	require ('../../recursos/manejo-formulario.php');
	require('DistSel.php');
	if (!isset($_GET['distro']))
	{
		if ($_GET['fml']=='s')
			parte1 ();//Solo selección de distribución
		else
		 fIntegrado ();//Selección de distribución,arquitectura y versión
	}
	else
	{
		if (!isset($_GET['arch'])) 
			parte2 ();//Seleccion de arquitectura / versión
    }
}
else
{
 //Muestro la pagina de resolucion de los repositorios seleccionados
  require('getRepo.php');
}
//Pie de pagina
echo "<br/><br/>".'*'._T ("Si desea que se añada o quite algun repositorio").
' <a href="http://blogdrake.net/foros">'._T ("Pidalo en los foros de BlogDrake").
"</a><br />\n"._T ("Si quiere añadir o corregir una traducción").' '.
_T ("Lea").' <a href="http://blogdrake.net/node/25955">'._T ("Esto").'</a>'.
'<br />'.
_T("Si no sabes qué es urpmi / rpmdrake o qué es un repositorio, revisa estos enlaces:")."<br/>
<ul><li><a href=\"http://blogdrake.net/node/4422\">".
_T ("Todo lo que siempre quisiste saber sobre urpmi pero nunca te atreviste a preguntar.").
"</a></li>
<li><a href=\"http://blogdrake.net/node/5701\">"._T ("¿Qué es un repositorio?.")."</a></li>
</ul><br/>
$strColaboracion.$strInfo <br />".
_T("Version externa").
":</strong> <a href=\"http://ftp.blogdrake.net/GetRepoDrake\">http://ftp.blogdrake.net/GetRepoDrake</a>";


?>
