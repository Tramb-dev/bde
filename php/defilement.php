<SCRIPT LANGUAGE="JavaScript">
//D'autres scripts sur http://www.multimania.com/jscript
//Si vous utilisez ce script, merci de m'avertir ! 	< jscript@multimania.com >


// Pour utiliser la fonction "setTimeout" avec les anciens navigateurs, on utilise des variables globales
var msg="MESSAGE";
var index=0;
var delay=200

function defil() {
	// Fonction r�cursive pour le d�calage du texte du message
	var nb_char=msg.length;
	index++;
	if (index>nb_char) index=0;
	window.status=msg.substring(index)+msg;
	setTimeout("defil()",delay);
}

function defiler(txt,tps) {
	//Cette fonction est appel�e pour d�clencher le d�filement.
	msg=txt + "   -   " + txt + "   -   " ;
	delay=tps;
	defil();
}

	defiler("BDE Adr�naline, le seul BDE qui d�chire ...",90);
</SCRIPT>