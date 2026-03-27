function selectChanged(selectID, inputID) {
    var selectElement = document.getElementById(selectID);
    var selectValue = selectElement.options[ selectElement.selectedIndex ].value;
    var inputElement = document.getElementById(inputID);

    inputElement.value = selectValue;
}

function init() {
    selectChanged('uris', 'uri');
}

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

function BookSelected(theSelect) {
    var wsdl = document.getElementsByName("uri")[0].value;

    var bookName = theSelect.value;

    var args = "uri=" + wsdl + "&bookName=" + bookName;

    let xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "getBookDetails.php?" + args, true);
    xmlHttp.onreadystatechange = () => {
        if (xmlHttp.readyState === XMLHttpRequest.DONE) {
            var book = JSON.parse(xmlHttp.responseText);

            document.getElementById("isbn").innerHTML = book.isbn;
            document.getElementById("price").innerHTML = book.price;
            document.getElementById("quantity").innerHTML = book.quantity;

            DownloadBookCover(bookName, book.isbn);
        }
    };
    xmlHttp.send(null);
}

function DownloadBookCover(bookName, bookISBN) {
    let img = document.getElementById("image");

    img.src = "https://covers.openlibrary.org/b/ISBN/" + bookISBN + "-M.jpg";
    img.title = bookName;
}
