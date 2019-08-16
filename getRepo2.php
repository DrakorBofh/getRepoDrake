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
//Serializo el array para enviarlo
function PrepararParaEnviar($array) { 
     $tmp = serialize($array); 
     $tmp = urlencode($tmp); 
     return $tmp; 
}//PrepararParaEnviar
echo '<a href="index.php"><div id="title"></div></a>';
global $version,$arch,$distro,$SupDistro;
require ('../recursos/def-comunes.php');
require ('../recursos/manejo-clases.php');
$distro = $_POST['distro'];
$version = $_POST['version'];
$arch = $_POST['arch'];

echo "<h2> "._T ("Selección de repositorios No-oficiales para")." ".$SupDistro[$distro]['completo']." $version ".
_T ("para la arquitectura")." $arch ".(($arch=='i586')?"- i686":"")." : </h2>";

//Abro el archivo de repositorios
$xml = simplexml_load_file("Repositorios-".$distro.".xml");
if ($xml === false ) 
{
  exit(("<h2 class=\"error\">"._T ("Ha ocurrido un problema interno. Contactese con el administrador.")."</h2>"));
}

$Comandos=array();
unset ($ListaComandos); //Se usara para crear el script que agregara los repositorios de forma automatica ;)
$i=0;//   variable aux para la seleccion de comandos
echo "<form id=\"Fg\" action=\"genfile2.php\" method=\"post\"  >";
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
	  <?php printf ("alert(\"%s\");",_T ("Debe seleccionar al menos un repositorio."));?>
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
unset ($Repos_Vacios);
$Repos_Vacios=array ();
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
    echo '<fieldset tittle="'.$Repositorio->Nombre.'"><legend>'.$Repositorio->NCompleto.
	   ' ('.$Repositorio->Nombre.')</legend>'; 
  
    echo "<ul>";
    foreach ($Repositorio->Rama as $Rama)
    {
      if (($Rama->Version == $version)&&(($Rama->Arquitectura == $arch)||
		 ($Rama->Arquitectura == 'i686' && ($arch=='i586'))))
	 {
	    echo "<li>";echo $Rama->Categoria;/*echo " - ";echo $Rama->Protocolo;*/ 
	    if($Rama->Arquitectura == 'i686')
		{
		  echo " - "; echo $Rama->Arquitectura;
		}
		echo "<input id=\"Sel$i\" type=\"checkbox\" value=\"$i\" name=\"Sel[]\"  onclick=\"Cuenta('Sel$i');\" />";
		foreach ($Rama->Comando as $Comando)
		{
		  $ListaComandos[]="$Comando";		  
          echo "<pre> $Comando </pre>"; 
		}
		echo "</li>";
		echo "<input type=\"button\" value=\"".
	         _T("Agregame mediante gui")."\" onclick=\"RepSend ('Sel$i');\" />";
	    echo ' *'._T ('Elija').' <strong>'._T ('Abrir con').'</strong> '.
	    _T ('y presione').' <strong>'._T ('Aceptar').'</strong>';
		$i++;
	  }
	}
	echo "</ul>";
    echo "</fieldset><br>";
  }
  else
  {
    $Repos_Vacios[]=$Repositorio->NCompleto.' ('.$Repositorio->Nombre.')'; 
  }
}
if (count ($Repos_Vacios)>0)
{
  echo '<fieldset tittle="'._T ("No contiene ningún repositorio para las opciones escogidas.").
  '"><legend>'._T ("No contiene ningún repositorio para las opciones escogidas.").'</legend>';
  echo "<ul>
";
  foreach ($Repos_Vacios as $Repo)
  {
    echo '<li>'.$Repo.'</li>
';
    
  }
  echo "</ul>
</fieldset><br />
";
}
?>
<script type="text/javascript">
	Reset ();
</script>
<?
$ListaComandos = PrepararParaEnviar($ListaComandos);
echo '<input type="hidden" name="modo" value="script" />';
echo "<input type=\"hidden\" name=\"distro\" value=\"$distro\" />";
echo "<input type=\"hidden\" name=\"version\" value=\"$version\">";
echo "<input type=\"hidden\" name=\"arch\" value=\"$arch\">";
echo "<input type=\"hidden\" name=\"Comandos\" value=\"$ListaComandos\">";
echo "<div style='text-align:center'>".
"<input type=\"button\" value=\""._T ("Añadir seleccionados mediante script")."\" onclick=\"RevAc();\"/></div></form>";
//Nota de pie y fin de pagina

echo "<br/><br/>"._T ("Si no sabes qué es urpmi / rpmdrake o qué es un repositorio, revisa estos enlaces:")."<br/>
<ul><li><a href=\"http://blogdrake.net/node/4422\">"._T ("Todo lo que siempre quisiste saber sobre urpmi pero nunca te atreviste a preguntar.")."</a></li>
<li><a href=\"http://blogdrake.net/node/5701\">"._T ("¿Qué es un repositorio?.")."</a></li>
</ul>";

?>
