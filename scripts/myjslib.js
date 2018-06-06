function isNumeric(sval,elid){
   var intChars = "0123456789.";
   var curChar;
   var accVal="";
   for(var i=0; i<sval.length; i++){ 
      	curChar = sval.charAt(i); 
      	if(intChars.indexOf(curChar) >=0){
        	accVal+=""+curChar;
		}else{
			document.getElementById(elid).value=accVal;
			return false;
			break;
		}
   }
   document.getElementById(elid).value=accVal;
   return true;

}
function isString(sval,elid){
	var invalidChars = "1234567890";
    var curChar;
    for(var i=0; i<sval.length; i++){ 
      	curChar = sval.charAt(i); 
      	if(invalidChars.indexOf(curChar)>-1){
        	 alert("Please enter a string value");
        	 document.getElementById(elid).value="";
        	 return false;
        	 break;
         }
   }
   return true;
}
function isAllNumbers(sval){
   var intChars = "0123456789.";
   var curChar;
   var val_ok=true;
   for(var i=0; i<sval.length; i++){ 
      	curChar = sval.charAt(i); 
      	if(intChars.indexOf(curChar) == -1){
            val_ok = false;
        	break;
         }
   }
   return val_ok;
}



function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
			  var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
			  return parseFloat(newnumber).toFixed(rlength); // Output the result to the form field (change for your purposes)
}
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

