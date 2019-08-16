<?php
global $version,$arch,$distro,$SupDistro;
require ('../recursos/def-comunes.php');
if (!strstr($_SERVER["HTTP_USER_AGENT"], "MSIE"))
{ 
 $extra=""; 
}
else 
{ 
 $extra="window."; 
}

//Formulario de selección de distribución
function parte1 ()
{
 global $SupDistro,$locale;
 $url=explode ('?',$_SERVER['REQUEST_URI']);
 $ulr=$url[0];
 print '<div id="Block">
 <form id="F2" action="'.$url.'"  method="post" >';
 print _T ("Distribución").' <select id="distro" name="distro">
  <option>'._T ("Seleccione Distribución").'</option>
  ';
  foreach ($SupDistro as $Distro)
  {
    print "<option value=\"".$Distro["sufijo"].'" >'.$Distro["completo"].
    "</option>
    ";
  }
  print '</select>';
  //Enviar la información del idioma
  print "<input type=\"hidden\" name=\"lang\" value=\"".$locale."\" />
    ";
  print "<input type=\"button\" value=\""._T("Siguiente")."\" onclick=\"distCheck();\"/>
  </form>
  </div>";
}

//Formulario que combina la selección de distribución,
//versión de la distribución y arquitectura
function fIntegrado ()
{
  global $SupDistro,$locale;
  $url=explode ('?',$_SERVER['REQUEST_URI']);
  $url=$url[0];
  print '<div id="Block"> 
 <form id="F2" action="'.$url.'"  method="post" >';
?>
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
<?php
  print _T ("Seleccione Distribución").': ';
  foreach ($SupDistro as $Distro)
  {
    print "<input type=\"radio\" name=\"distro\" value=\"".
    $Distro["sufijo"]."\" onclick=\"setVer ();\" />".$Distro["completo"]."\n";
  }
  print "<br />"._T("Arquitectura").': <select id="arch" name="arch" onclick="distSel();">
 <option value="i586">32 bits</option>
 <option value="x86_64">64 bits</option>
 </select>'.' '._T ("Versión").': <span id="version"> </span>';
  //Enviar la información del idioma
  print "<input type=\"hidden\" name=\"lang\" value=\"".$locale."\" />
    ";
  print "<br /><br /><input type=\"button\" value=\""._T("Siguiente")."\" onclick=\"distCheck();\"/>".'  
  </form>
  </div>';
}


//Formulario de selección de versión/arquitectua
function parte2 ()
{
 global $distro,$SupDistro,$locale;
 $url=explode ('?',$_SERVER['REQUEST_URI']);
 $url=$url[0];
  $distro=$_POST['distro'];
  print '<div id="Block">'.
   _T ("Distribución").": ".$SupDistro[$distro][completo]."
   ".'<form id="F2" action="'.url.'" method="post">
   '._T ("Versión").':<select id="version" name="version">';
  for ($i=0; $i<sizeof($SupDistro[$distro]["versiones"]); $i++)
  {
     print "<option value=\"".$SupDistro[$distro]["versiones"][$i]."\">
	".$SupDistro[$distro]["versiones"][$i]."</option>";
  }
 print '</select>';
 print '
 '._T("Arquitectura").': <select id="arch" name="arch">
 <option value="i586">32 bits</option>
 <option value="x86_64">64 bits</option>
 </select>
 <input type="hidden" name="distro" value="'.$distro.'" />';
  if (isset ($_POST['lang']))//Enviar la información del idioma
   print "<input type=\"hidden\" name=\"lang\" value=\"".$_POST['lang']."\" />";
  print "<input type=\"submit\" value=\""._T("Siguiente")."\" />  
  ".'</form>
  </div>
 <br /><br />';

}

?>
