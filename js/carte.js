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

function changeVisibility(id) {
	
	var node = document.getElementById(id);
	
	if (document.getElementById(id).style.visibility == 'visible'){
		document.getElementById(id).style.visibility = 'hidden';
	}
	else {
		document.getElementById(id).style.visibility = 'visible';
	}
	
}

var draggable = null;

var originalXPos = null;
var originalYPos = null;

var originalMouseXPos = null;
var originalMouseYPos = null;

function setDragable(id, e){
	
	draggable = document.getElementById(id);
	
	originalXPos = parseInt(draggable.getAttribute("x"), 10);
	originalYPos = parseInt(draggable.getAttribute("y"), 10);
	
	originalMouseXPos = parseInt(e.pageX, 10);
	originalMouseYPos = parseInt(e.pageY, 10);
	
}

function move(id, e) {

	if(draggable != null){
		if(draggable.getAttribute("id") == id + "img"){
			
			x = originalXPos + (parseInt(e.pageX, 10) - originalMouseXPos);
			y = originalYPos + (parseInt(e.pageY, 10) - originalMouseYPos);
			
			draggable.setAttribute("x", x) ;
			draggable.setAttribute("y", y);
			
			var foreign = document.getElementById(id + 'fo');
			
			foreign.setAttribute("x", x) ;
			foreign.setAttribute("y", y);
			
			xx = x + parseInt(draggable.getAttribute("width"))/2 - 50;
			yy = y + parseInt(draggable.getAttribute("width")) + 5;
			
			document.getElementById(id + '_editP').setAttribute("transform", 'translate(' + xx + ', ' + yy + ')');
			
		}
	}
	
}

function moveToken(id, e) {

	if(draggable != null){
		if(draggable.getAttribute("id") == id){
			
			x = originalXPos + (parseInt(e.pageX, 10) - originalMouseXPos);
			y = originalYPos + (parseInt(e.pageY, 10) - originalMouseYPos);
			
			draggable.setAttribute("x", x) ;
			draggable.setAttribute("y", y);
			
		}
		
	}
	
}

function unsetDragableToken(id){
	
	draggable = null;
	
}

imageAttr = null;

function unsetDragable(id){
	
	xhr = getXMLHttpRequest();
	
	var index = encodeURIComponent(id);
	var x = encodeURIComponent(draggable.getAttribute("x"));
	var y = encodeURIComponent(draggable.getAttribute("y"));
	
	xhr.onreadystatechange = function() {
					
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				
			if(xhr.responseText != "0") {
			
				foreign.setAttribute("x", originalXPos) ;
				foreign.setAttribute("y", originalYPos);
					
				alert("une erreur semble être survenue durant le déplacement du point, contactez l'administrateur si elle persiste.");
					
			}
	
		}
	};
		
	xhr.open("GET", "ajax/updatePoint.php?id=" + id + "&x=" + x + "&y=" + y, true);
	xhr.send(null);
	
	draggable = null;
	
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
