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
global $version,$arch,$distro,$SupDistro;
require ('../../recursos/def-comunes.php');
$distro = $_GET['distro'];
$version = $_GET['version'];
$arch = $_GET['arch'];

echo "<h2> "._T ("Selección de repositorios No-oficiales para")." ".$SupDistro[$distro]['completo']." $version ".
_T ("para la arquitectura")." $arch ".(($arch=='i586')?"- i686":"")." : </h2>\n";

//Abro el archivo de repositorios
if (file_exists('../Repositorios-'.$distro.'.xml')) {
    $xml = simplexml_load_file('../Repositorios-'.$distro.'.xml');
} else {
    exit("<h2 class=\"error\">".
_T ("Ha ocurrido un problema interno. Contactese con el administrador.")."</h2>");
}

$Comandos=array();
$ListaComandos=array(); //Se usara para crear el script que agregara los repositorios de forma automatica ;)
$i=0;//   variable aux para la seleccion de comandos
$Repos_Vacios=array ();
$url_prod="http://ftp.blogdrake.net/GetRepoDrake";
$url_dev="http://localhost/katnatek/GetRepoDrake";
$url=$url_prod;
echo "<div style='border:1px solid;padding: 6px;'>\n";
echo "<form id=\"Fg\" action=\"$url/genfile2.php\" method=\"post\" enctype=\"multipart/form-data\" >\n";
?>
<script type="text/javascript">
	var actions=0;
	function Cuenta (divID)
	{
	 var item = document.getElementById(divID);
	 if (item.checked)
	  actions++;
	 else
	  actions--; 
	}
	function RevAc ()
	{
		 if (actions==0)
		  <?php printf ("alert(\"%s\");\n",_T ("Debe seleccionar al menos un repositorio."));?>
		 else
		 {
		   document.forms.Fg.submit();
		 }
	}
	function Reset ()
	{
		actions=0;
		document.getElementById ('Fg').reset ();
		document.getElementsByName ('modo')[0].value='script';
	}
	function RepSend (rep)
	{
		actions=1;
		document.getElementById ('Fg').reset ();
		document.getElementById (rep).checked=true;
		document.getElementsByName ('modo')[0].value='gui';
		document.getElementById ('Fg').submit ();
		Reset ();
	}
</script>
<?php
foreach ($xml->xpath('//Repositorio') as $Repositorio)
{
 unset($Comandos);
 $Comandos = array(); 
 foreach ($Repositorio->Rama as $Rama)
 {
	if (($Rama->Version == $version)&&(($Rama->Arquitectura == $arch)||
		($Rama->Arquitectura == 'i686' && ($arch=='i586'))))
	{
		foreach ($Rama->Comando as $Comando)
			array_push($Comandos,$Comando);
    }
 }
 if (count($Comandos)>0)
 {//Si  tiene algo el arreglo
	echo '<dl>'."\n";
	echo '<dt><strong>'.$Repositorio->NCompleto.
	' ('.$Repositorio->Nombre.')</strong></dt>'."\n";
	 echo "<dd><ul>\n";
     foreach ($Repositorio->Rama as $Rama)
     {
		if (($Rama->Version == $version)&&
			(($Rama->Arquitectura == $arch)||
			   ($Rama->Arquitectura == 'i686' && ($arch=='i586'))))
		{
			echo "<li>\n";
			echo $Rama->Categoria;/*echo " - ";echo $Rama->Protocolo;*/ 
			if($Rama->Arquitectura == 'i686')
			{
				echo " - "; 
				echo $Rama->Arquitectura;
			}
			echo "<input id=\"Sel$i\" type=\"checkbox\" value=\"$i\" name=\"Sel[]\" onclick=\"Cuenta ('Sel$i');\" />\n";	       
			foreach ($Rama->Comando as $Comando)
	        {
				$ListaComandos[]="$Comando";
			    echo "<div style='overflow: auto;'>\n<pre> $Comando </pre>\n</div>\n"; 
	         }
	         echo "</li>\n";
	         echo "<input type=\"button\" value=\"".
	         _T("Agregame mediante gui")."\" onclick=\"RepSend ('Sel$i');\" />\n";
			 echo ' *'._T ('Elija').' <strong>'._T ('Abrir con').'</strong> '.
			 _T ('y presione').' <strong>'._T ('Aceptar').'</strong>'."\n";
	         $i++;
	     }
      }
      echo "</ul></dd>\n";
      echo "</dl>\n";
  }
  else
  {
	$Repos_Vacios[]=$Repositorio->NCompleto.' ('.$Repositorio->Nombre.')';
  }
}
if (count ($Repos_Vacios)>0)
{
  echo '<dl><dt><strong>'.
	_T ("No contiene ningún repositorio para las opciones escogidas.").
  '</strong></dt>';
  echo '<dd><ul>'."\n";
  foreach ($Repos_Vacios as $Repo)
  {
    echo '<li>'.$Repo.'</li>'."\n";
  }
  echo '</ul></dd>
</dl>
';
}

//Serializo el array para enviarlo
function PrepararParaEnviar($array) { 
     $tmp = serialize($array); 
     $tmp = urlencode($tmp); 
     return $tmp; 
}//PrepararParaEnviar
	$ListaComandos = PrepararParaEnviar($ListaComandos);
	echo '<input type="hidden" name="modo" value="script" />'."\n";
    echo "<input type=\"hidden\" name=\"distro\" value=\"$distro\" />\n";
	echo "<input type=\"hidden\" name=\"version\" value=\"$version\" />\n";
    echo "<input type=\"hidden\" name=\"arch\" value=\"$arch\" />\n";
    echo "<input type=\"hidden\" name=\"Comandos\" value=\"$ListaComandos\" />\n";
?>
<script type="text/javascript">
	Reset ();
</script>
<?php    
    echo "<center><input type=\"button\" value=\"".
		_T ("Añadir seleccionados mediante script")."\" onclick=\"RevAc ();\" /></center>\n</form>\n</div>\n";
?>
