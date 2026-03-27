var xmlHttp;

function GetXmlHttpObject() {
  try {
    return new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
  } // Internet Explorer
  try {
    return new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e) {
  } // Internet Explorer
  try {
    return new XMLHttpRequest();
  } catch (e) {
  } // Firefox, Opera 8.0+, Safari
  alert("XMLHttpRequest not supported");
  return null;
}

function getContent(scriptName) {
  xmlHttp = GetXmlHttpObject();
  xmlHttp.open("GET", scriptName, true);
  xmlHttp.onreadystatechange = getContentHandleReply;
  xmlHttp.send(null);
}

function getContentHandleReply() {
  if (xmlHttp.readyState === 4) {
    document.getElementById( "contentDiv" ).innerHTML = xmlHttp.responseText;
  }
}