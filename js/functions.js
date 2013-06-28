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
