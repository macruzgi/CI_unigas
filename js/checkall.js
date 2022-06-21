// JavaScript Document
function checkAll() {
	var nodoCheck = document.getElementsByTagName("input");
	var varCheck = document.getElementById("checkall").checked;
	for (i=0; i<nodoCheck.length; i++){
		if (nodoCheck[i].type == "checkbox" && nodoCheck[i].name != "checkall" && nodoCheck[i].disabled == false) {
			nodoCheck[i].checked = varCheck;
		}
	}
}