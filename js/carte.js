viewedPict = null;
    
function viewInfo(id) {

	if (document.getElementById(id+'Infos') !== viewedPict) {
		if (viewedPict != null) {viewedPict.style.visibility = 'hidden';}
		document.getElementById(id+'Infos').style.visibility = 'visible';
	}
	else if(document.getElementById(id+'Infos') == viewedPict) {
		if (viewedPict.style.visibility == 'visible'){
		viewedPict.style.visibility = 'hidden';
		}
		else {
		viewedPict.style.visibility = 'visible';
		}
	}
    
	viewedPict = document.getElementById(id+'Infos');

}

function getPointInfos(pPointId, pMapId) {

	var xhr = getXMLHttpRequest(); //nécessite functions.js
	
	var sP = encodeURIComponent(pPointId);
	var sM = encodeURIComponent(pMapId);
	
	xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                document.getElementById(pMapId).appendChild(xhr.responseXML);
        }
	};
	
	xhr.open("GET", "ajax/getPointInfos.php?mId=" + sM + "&pID=" + sP, true);
	
	xhr.send(null);
	
}

function showPointInfos() {

	
	
}
