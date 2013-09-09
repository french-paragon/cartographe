

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

function newPoint(id, mapId){

	var name = prompt("Donnez une description au nouveau point: \n\nLa description d'un point est un court texte apparaissant au passage de la souris sur la carte et dans l'éditeur où ils vous servent à reconnaître les points. \n\n",'nouveau point');
	
	name = encodeURIComponent(name);
	maid = encodeURIComponent(mapId);

	xhr = getXMLHttpRequest();
		
	xhr.onreadystatechange = function() {
					
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				
			if(xhr.responseText == "1") {
					
				alert("une erreur semble être survenue, contactez l'administrateur.");
					
			} else {
				document.getElementById(id).innerHTML += xhr.responseText;
			}
		}
			
	};
		
	xhr.open("GET", "ajax/addPoint.php?mapId=" + maid + "&descr=" + name, true);
	xhr.send(null);
	
}

function delPoint(id){
	
	if(confirm("Voulez vous vraiment supprimer ce point?")){
		
		pId = encodeURIComponent(id);
				
		var child = document.getElementById(id+"beditlink");
		var parent = child.parentNode;

		xhr = getXMLHttpRequest();
		
		xhr.onreadystatechange = function() {
					
			child.innerHTML = "<tr><td><img alt=\"wait\" src=\"images/ajax-loader.gif\"/></td></tr>";
					
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				
				if(xhr.responseText == "0") {
					
					parent.removeChild(child);
					
					alert("Le point a été supprimé!");
					
				} else {
					alert("une erreur semble être survenue, contactez l'administrateur.");
				}
			}
		};
		
		xhr.open("GET", "ajax/deletePoint.php?toDelete=" + id, true);
		xhr.send(null);
		
	}
	
}

function loadModelForm(fromId, toId, ptId){

	var origin = document.getElementById(fromId);
	var target = document.getElementById(toId);
	
	var modelName = encodeURIComponent(origin.value);
	var pointId = encodeURIComponent(ptId);

	xhr = getXMLHttpRequest();
		
	xhr.onreadystatechange = function() {
					
	target.innerHTML = "<tr><td><img alt=\"wait\" src=\"images/ajax-loader.gif\"/></td></tr>";
					
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			target.innerHTML = xhr.responseText;
		}
	};
		
	xhr.open("GET", "ajax/getPointModelForm.php?pt=" + pointId + "&model=" + modelName, true);
	xhr.send(null);
	
}
