function selectChanged(selectID, inputID) {
    var selectElement = document.getElementById(selectID);
    var selectValue = selectElement.options[selectElement.selectedIndex].value;
    var inputElement = document.getElementById(inputID);

    inputElement.value = selectValue;
}

function init() {
    selectChanged('uris', 'uri');
}

function GetXmlHttpObject() {
    try {
        return new XMLHttpRequest();
    } catch (e) {}
    alert("XMLHttpRequest not supported");
    return null;
}

function BookSelected(theSelect) {
    var uri = document.getElementsByName("uri")[0].value;
    var bookName = theSelect.value;
    var args = "uri=" + encodeURIComponent(uri) + "&bookName=" + encodeURIComponent(bookName);

    var xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "getBookDetails.php?" + args, true);
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === XMLHttpRequest.DONE) {
            if (xmlHttp.status === 200) {
                var book = JSON.parse(xmlHttp.responseText);

                document.getElementById("isbn").innerHTML = book.isbn;
                document.getElementById("price").innerHTML = book.price;
                document.getElementById("quantity").innerHTML = book.quantity;

                DownloadBookCover(bookName, book.isbn);
            } else {
                alert("Error fetching book details (HTTP " + xmlHttp.status + ")");
            }
        }
    };
    xmlHttp.send(null);
}

function DownloadBookCover(bookName, bookISBN) {
    var img = document.getElementById("image");

    img.src = "https://covers.openlibrary.org/b/ISBN/" + bookISBN + "-M.jpg";
    img.title = bookName;
}
