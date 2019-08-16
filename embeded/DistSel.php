<?php
/*
 * *    GetRepoDrake:
 * *------------------------------------------------------------------------------------------------------------------
 * *    Herramienta que permite obtener los repositorios provistos por las diferentes 
 * *     comunidades  de usuarios de Mandriva Linux, de una forma sencilla y rápida,
 * *     para agregarlos a nuestro sistema.
 * *----------------------------------------------------------------------------------------------------------------
 * *    Copyright (C)  2012  José Alberto Valle Cid ( katnatek ), blogdrake.net
 * *    This program is free software: you can redistribute it and/or modify
 * *    it under the terms of the GNU Affero General Public License as
 * *    published by the Free Software Foundation, either version 3 of the
 * *    License, or (at your option) any later version.
 * *
 * *    This program is distributed in the hope that it will be useful,
 * *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 * *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * *    GNU Affero General Public License for more details.
 * *
 * *    You should have received a copy of the GNU Affero General Public License
 * *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * *
 * *
 * */


function fIntegrado ()
{
	global $SupDistro;
	$url_prod="http://blogdrake.net/blog/drakor/obtener-repositorios-de-las-comunidades/";
    $url_dev="http://localhost/katnatek/GetRepoDrake/embeded/";
    $url=$url_prod;
	echo "<h2>"._T ("Obtenga la lista de repositorios Comunitarios de OpenMandriva y Mageia Linux.").
"</h2>\n<div style='border:1px solid;padding: 6px;'> \n";
	echo "<form id=\"F2\" action=\"$url\" method=\"get\"  >\n"; ?>
<script type="text/javascript">
	function setVer ()
	{
		var mgaVer;
		var omdvVer,elemento,distro;
		mgaVer='<select name="version">'+
	   <?php foreach ($SupDistro['mga']['versiones'] as $version)
		print "'<option value=\"$version\">$version</option>'+";?>
		'</select>';
		omdvVer='<select name="version">'+
		<?php foreach ($SupDistro['omdv']['versiones'] as $version)
		print "'<option value=\"$version\">$version</option>'+";?>
		'</select>';
		elemento=document.getElementById('version');
		distro=document.getElementsByName('distro');
		elemento.innerHTML="";
		for (i=0;i<distro.length;i++)
	    {
		  if (distro[i].checked)
		  {
			  if (distro[i].value == "mga")
			  {
		        elemento.innerHTML=mgaVer;
		        break;
			  }
			  if (distro[i].value == "omdv")
			  {
		        elemento.innerHTML=omdvVer;
		        break;
			  }
		 }
	    }
	}
</script>
<div style='text-align:center'>
<?php
//<select id="distro" name="distro">
	print _T ("Seleccione Distribución").": ";
    foreach ($SupDistro as $Distro)
    {
       print "<input type=\"radio\" name=\"distro\" value=\"".
       $Distro["sufijo"].'" onclick="setVer ();" />'.
       $Distro["completo"]."\n";
    }
//  </select>
	print "<br /> \n"._T("Arquitectura").": <select name=\"arch\">
	<option value=\"i586\">i586-i686</option>
	<option value=\"x86_64\">x86_64</option>
	</select> ".
	_T("Versión").': <span id="version"> </span>';
?>
</div>
<div style='text-align:center'>
	<br />
	<input type="button" value="<?php echo _T("Siguiente");?>" onclick="distCheck ();"/>
</div>
</form>
<img src="http://ftp.blogdrake.net/GetRepoDrake/imagenes/LogoBilo.png" alt="Logo" style='border:0;width:215px;height:103px' align="right" />
<?php
}
function parte1 ()
{
	global $SupDistro;
	$url_prod="http://blogdrake.net/blog/drakor/obtener-repositorios-de-las-comunidades/";
    $url_dev="http://localhost/katnatek/GetRepoDrake/embeded/";
    $url=$url_prod;
	echo "<h2>"._T ("Obtenga la lista de repositorios Comunitarios de OpenMandriva y Mageia Linux.").
"</h2>\n<div style='border:1px solid;padding: 6px;'> \n";
	echo "<form action=\"$url\" method=\"get\"  >\n"; ?>
<div style='text-align:center'>
<?php print _T ("Seleccione Distribución").": ";
?>
<select id="distro" name="distro">
<?php	
    foreach ($SupDistro as $Distro)
    {
      print "<option value=\"".$Distro["sufijo"].'">'.
      $Distro["completo"]."</option>\n";
    }
?>
</select>
</div>
<div style='text-align:center'><input type="submit" value="<?php echo _T("Siguiente");?>"/></div>
</form>
<img src="http://ftp.blogdrake.net/GetRepoDrake/imagenes/LogoBilo.png" alt="Logo" style='border:0;width:215px;height:103px' align="right" />
<?php
}
function parte2 ()
{
	global $SupDistro;
	$distro = $_GET['distro'];
	$url_prod="http://blogdrake.net/blog/drakor/obtener-repositorios-de-las-comunidades/";
	$url_dev="http://localhost/katnatek/GetRepoDrake/embeded/";
	$url=$url_prod;
	print "<h2>"._T ("Obtenga la lista de repositorios Comunitarios de Mageia Linux.")."</h2>
	<div style='border:1px solid;padding: 6px;'>";
	echo "<form action=\"$url\" method=\"get\"  >
	<div style='text-align:center'>
	<p> "._T ("Versión")." <select name=\"version\">";
	for ($i=0; $i<sizeof($SupDistro[$distro]["versiones"]); $i++)
	  {
	     print "<option value=\"".$SupDistro[$distro]["versiones"][$i]."\">
		".$SupDistro[$distro]["versiones"][$i]."</option>";
	  }
	print '</select> '._T("Arquitectura")."<select name=\"arch\">
	<option value=\"i586\">i586-i686</option>
	<option value=\"x86_64\">x86_64</option>
	</select></p></div>";
	/*print "
	<fieldset title=\"Repos\" ><legend>"._T ("Selección de repositorios No-oficiales")."</legend>";*/
	
	//Abro el archivo de repositorios
	/*if (file_exists('../Repositorios-'.$distro.'.xml')) {
	    $xml = simplexml_load_file('../Repositorios-'.$distro.'.xml');
	} else {
	    exit("<h2 class=\"error\">"._T ("Ha ocurrido un problema interno. Contactese con el administrador.")."</h2>");
	}
	foreach ($xml->xpath('//Repositorio') as $Repositorio){
	  echo '<input type="checkbox" value="'.$Repositorio->Nombre.'" name="Repositorios[]" />'. $Repositorio->Nombre.' ('.$Repositorio->NCompleto.')<br/>';
	}
	echo "</fieldset><p></p>";*/
	echo "<input type=\"hidden\" name=\"distro\" value=\"$distro\" />";
	echo "<div style='text-align:center'><input type=\"submit\" value=\""._T ("Siguiente")."\"/></div></form></div>";
	echo "<img src=\"http://ftp.blogdrake.net/GetRepoDrake/imagenes/LogoBilo.png\" alt=\"Logo\"style='border:0;width:215px;height:103px' align=\"right\">";
}
?>
