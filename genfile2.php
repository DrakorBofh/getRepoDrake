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

function ReacomodarArreglo($array) { 
     $tmp = stripslashes($array); 
     $tmp = urldecode($tmp); 
     $tmp = unserialize($tmp); 
     return $tmp; 
}

//$Dist = $_POST['distro'];
//$Ver = $_POST['version'];
//$Arq = $_POST['arch'];
//$ListaRepos = array();
//$ListaRepos = ReacomodarArreglo($_POST['Repositorios']);
//$nombre = "GetRepoDrake.urpmi-media" ; // Nombre del archivo
if (empty ($_POST))
{
	exit("<h2 class=\"error\">".
	"Ha ocurrido un problema interno. Contactese con el administrador".
	"</h2>\n"."<a href=\"http://ftp.blogdrake.net/GetRepoDrake\">Pruebe la versi&oacute;n externa</a>");
}
if (empty ($_POST['Sel']))
{
		exit("<h2 class=\"error\">".
		"Debe elegir almenos un repositorio".
		"</h2>");
}
$ListaComandos=ReacomodarArreglo ($_POST['Comandos']);
unset($Comandos);
$Comandos=array();
if ($_POST['modo']=='script')
{
	$Comandos[]='#!/bin/bash';
	$Comandos[]='if [ "$UID" != "0" ]; then';
	$Comandos[]='su -c "bash $0"';
	$Comandos[]='exit';
	$Comandos[]='fi';
	foreach ($_POST['Sel'] as $index)
		$Comandos[]=$ListaComandos[$index];		
}
else
{
	foreach ($_POST['Sel'] as $index)
	{
		 $ListaComandos[$index]=str_replace (array ('urpmi.addmedia ',
			'--wget '),'',$ListaComandos[$index]);
		 $NComandos=explode (" ",$ListaComandos[$index]);
		 /*Agregar un nombre de repositorio 
		  *en conjunto con --distrib, no es necesario
		  * para no usar este codigo se corrigio los
		  * archivos Repositorios-*.xml
		 if (($dindex=array_search ('--distrib',$NComandos))!==false)
		 {
			 while (substr ($NComandos[$dindex],0,2)=='--')
				++$dindex;
			array_splice ($NComandos,$dindex,1,array ());
		 }*/
		 $Comandos=array_merge ($Comandos,$NComandos);
	}
}
if (count($Comandos)>0)
{//Si  tiene algo el arreglo
	$nombre = "GetRepoDrake.".(($_POST['modo']=='script')?
	'bash':'urpmi-media') ; // Nombre del archivo
	header( "Content-Type: ".(($_POST['modo']=='script')?
	"application/octet-stream":"application/x-urpmi-media"));
	header( "Content-Disposition: attachment; filename=".$nombre."");	
	foreach ($Comandos as $Comando)
		echo "$Comando\n";
}
else
{
	exit("<h2 class=\"error\">".
	"Ha ocurrido un problema interno. Contactese con el administrador".
	"</h2>\n"."<a href=\"http://ftp.blogdrake.net/GetRepoDrake\">Pruebe la versi&oacute;n externa</a>");
}
?>
