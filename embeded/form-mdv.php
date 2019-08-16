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
$Dist = $_GET['distro'];

echo $url;

echo "<h2>"._T ("Obtenga la lista de repositorios Comunitarios de Mandriva Linux.")."</h2>
<div style='border:1px solid;padding: 6px;'>";
echo "<form action=\"http://blogdrake.net/blog/drakor/obtener-repositorios-de-las-comunidades\" method=\"get\"  >
<div style='text-align:center'>
<p> "._T ("Versión")." <select name=\"Version\">
<option value=\"2011.0\">2011.0</option>
<option value=\"2010.1\">2010.1</option>
<option value=\"2010.0\">2010.0</option>
<option value=\"2009.1\">2009.1</option>
<option value=\"2009.0\">2009.0</option>
</select>
 "._T("Arquitectura")."<select name=\"Arquitectura\">
<option value=\"i586\">i586-i686</option>
<option value=\"x86_64\">x86_64</option>
</select></p></div>

<fieldset title=\"Repos\" ><legend>"._T ("Selección de repositorios No-oficiales")."</legend>";

//Abro el archivo de repositorios
if (file_exists('../Repositorios-'.$Dist.'.xml')) {
    $xml = simplexml_load_file('../Repositorios-'.$Dist.'.xml');
} else {
    exit("<h2 class=\"error\">"._T ("Ha ocurrido un problema interno. Contactese con el administrador.")."</h2>");
}
foreach ($xml->xpath('//Repositorio') as $Repositorio){
  echo '<input type="checkbox" value="'.$Repositorio->Nombre.'" name="Repositorios[]" />'. $Repositorio->Nombre.' ('.$Repositorio->NCompleto.')<br/>';
}
echo "</fieldset><p></p>";
echo "<input type=\"hidden\" name=\"distro\" value=\"$Dist\" />";
echo "<div style='text-align:center'><input type=\"submit\" value=\""._T ("Siguiente")."\"/></div></form></div>";
echo "<img src=\"http://ftp.blogdrake.net/GetRepoDrake/imagenes/LogoBilo.png\" alt=\"Logo\"style='border:0;width:215px;height:103px' align=\"right\">";

?>