/*
 * 
 * get From http://www.cocoapp.eu/2011/02/16/proteger-son-formulaire-de-login-avec-javascript-et-php/
 * 
 * */

function loginValidation(pPass, pBuff, pCon){
    //Récupération du mot de passe
    var pass = pPass.value;
    //Remise a zéro du mot de passe
    pPass.value = "";
    //Cryptage du mot de passe en MD5 à l'aide de la fonction MD5()
    //présente dans le fichier cryptMD5.js
    var buf = MD5(pass); //nécessite le fichier cryptMD5.js
    //Ecriture du mot de passe dans le champ md5
    pBuff.value = buf;
    //Envoi du formulaire
    //document.Connexion.submit();
    pCon.submit();
}

/*
 * 
 * Picked from sdz
 * 
 */

function getXMLHttpRequest() {
    var xhr = null;
     
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
     
    return xhr;
}
