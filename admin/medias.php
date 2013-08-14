<?php 

	function drawMedia ($pName, $pMediaURL) {

	echo"<table class =\"pageView\">
	<tr>
	<td><img width=\"80\" heigth=\"80\" src=\"";

		if(preg_match("#.jpg$|.jpeg$|.JPG$|.JPEG$|.png$|.gif$|.GIF#", $pName)){
				echo $pMediaURL;
		} elseif(preg_match("#.pdf$#", $pName)){
				echo "images/ico_pdf.png";
		}else{
				echo "images/ico_file.png";
		}

	echo "\"/></td>
	<td><table>

	<tr><td><a class=\"pageName\" href=\"".$pMediaURL."\">";

	echo $pName;

	echo "</a></td></tr>
	<tr class = \"pageUse\"><td></td></tr>

	</table></td>
	</tr>
	</table>";

	}

	function drawCat ($CatName, $pURL) {

	echo("<table class =\"catView\">
	<tr>
	<td valign=\"top\"><img  width=\"100\" heigth=\"150\"  src=\"./images/cat.jpg\"/></td>
	<td><table>

	<tr><td><a class=\"pageName\" href=\"admin.php?tool=medias&cat=".$pURL."\">".$CatName."</a></td></tr>
	<tr class = \"catContent\"><td><hr><br>");
	
	ParcourirDossier ($pURL);

	echo("</td></tr>

	</table></td>
	</tr>
	</table><br><br>");

	}

	function ParcourirDossier ($folder) {

	if($dossier = opendir($folder)) {

			while(false !== ($fichier = readdir($dossier)))
			{
				if($fichier != "." AND $fichier != ".."){

					if(is_dir ($folder."/".$fichier))
					{		
						drawCat($fichier, $folder."/".$fichier);
					} elseif (is_file($folder."/".$fichier)){
					
						drawMedia($fichier, $folder."/".$fichier);
						
					}
				
				}

			}

		}

	}

	$DELFAUT_FOLDER = "medias";

	if (isset($_SESSION["log"]) AND $_SESSION["log"]->hasUserAdminRights()) {//si l'utilisateur à le droit de voir les médias.

		if (isset($_GET['cat'])) {

			ParcourirDossier($_GET['cat']);

		}else {

			ParcourirDossier($DELFAUT_FOLDER);

		}

	}

?>
