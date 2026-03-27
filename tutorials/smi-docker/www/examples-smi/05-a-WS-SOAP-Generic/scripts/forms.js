function selectChanged(selectID, inputID) {
  var selectElement = document.getElementById( selectID );
  var selectValue = selectElement.options[ selectElement.selectedIndex ].value;
  var inputElement = document.getElementById( inputID );
  
  inputElement.value = selectValue;
}

function init() {
  selectChanged('wsdls', 'wsdl');
}

var xmlHttp;
var xmlHttpImages;

function GetXmlHttpObject() {
  try {
    return new ActiveXObject( "Msxml2.XMLHTTP" );
  } catch(e) {} // Internet Explorer
  try {
    return new ActiveXObject( "Microsoft.XMLHTTP" );
  } catch(e) {} // Internet Explorer
  try {
    return new XMLHttpRequest();
  } catch(e) {} // Firefox, Opera 8.0+, Safari
  alert("XMLHttpRequest not supported");
  return null;
}

function BookSelected(theSelect) {
  var wsdl = document.getElementsByName("wsdl")[0].value;
  
  var bookName = theSelect.value;
  
  var args = "wsdl=" + wsdl + "&bookName=" + bookName;
 
  xmlHttp = GetXmlHttpObject();
  xmlHttp.open( "GET", "getBookDetails.php?"+args, true);
  xmlHttp.onreadystatechange = BookSelectedHandleReply;
  xmlHttp.send( null );
}

function BookSelectedHandleReply() {
  
  if( xmlHttp.readyState === 4 ) {
    var book = JSON.parse( xmlHttp.responseText );

    document.getElementById( "isbn" ).innerHTML = book.isbn;
    document.getElementById( "price" ).innerHTML = book.price;
    document.getElementById( "quantity" ).innerHTML = book.quantity;
    
    DownloadBookCover( document.getElementsByName("wsdl")[0].value, book.isbn );
  }
}

function DownloadBookCover(wsdl, bookISBN) {
  var args = "wsdl=" + wsdl + "&bookISBN=" + bookISBN;
 
  xmlHttpImages = GetXmlHttpObject();
  xmlHttpImages.open( "GET", "getBookCover.php?"+args, true);
  xmlHttpImages.onreadystatechange = DownloadBookCoverHandleReply;
  xmlHttpImages.send( null );
}

function DownloadBookCoverHandleReply() {
  if( xmlHttpImages.readyState === 4 ) {
    document.getElementById( "image").src = "data:image/jpg;base64," + xmlHttpImages.responseText;
  }
}