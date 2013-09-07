

function del(index){
	
	if(confirm("Voulez vous vraiment supprimer cette carte?")){

		xhr = getXMLHttpRequest();
		
		var id = encodeURIComponent(index); 
				
		var child = document.getElementById(index+"tableEdit");
		var parent = child.parentNode;
		
		xhr.onreadystatechange = function() {
					
			child.innerHTML = "<tr><td><img alt=\"wait\" src=\"images/ajax-loader.gif\"/></td></tr>";
					
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				
				if(xhr.responseText == "0") {
					
					parent.removeChild(child);
					
					alert("La carte a été supprimée!");
					
				} else {
					alert("une erreur semble être survenue, contactez l'administrateur.");
				}
			}
		};
		
		xhr.open("GET", "ajax/deleteMap.php?toDelete=" + id, true);
		xhr.send(null);
		
	}
	
}
