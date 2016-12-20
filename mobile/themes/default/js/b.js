
function setCookie(name, value, expire) 
{   
	window.document.cookie = name + "=" + escape(value) + ((expire == null) ? "" : ("; expires=" + expire.toGMTString()));
}
function getCookie(Name) 
	{   
   var search = Name + "=";
  
   if (window.document.cookie.length > 0) 
	{ // if there are any cookies
	
     offset = window.document.cookie.indexOf(search);
    
  if (offset != -1) 
	{ // if cookie exists
	
       offset += search.length;         
// set index of beginning of value
    end = window.document.cookie.indexOf(";", offset)   

// set index of end of cookie value
    if (end == -1){
      end = window.document.cookie.length;
    }
    return unescape(window.document.cookie.substring(offset, end));
     }
   }
   return null;
}
function register(name) {
  var today = new Date();
  var expires = new Date();
  expires.setTime(today.getTime() + 1000*60*60*24);
  setCookie("ttt", name, expires);
}

function openWin() {

 var c = getCookie("ttt");
  if (c != null) {
    return;
  }
  $(".hongbao").on("click",function(){
    register("ttt");
  })
  
  hongba();
}
openWin();








function hongba(){
  $('.hbbox').addClass("hbanme")
}




