<!DOCTYPE html>
<html>
    <head>
        <script>
            var _baseEndPoint = "${pageContext.request.contextPath}/rest/books";

            var host = "<%=request.getServerName() %>";
            var port = "<%=request.getServerPort() %>";

            function init() {
                document.getElementById("endpoint").value = "http://" + host + ":" + port + _baseEndPoint;
            }

            function getBaseEndPoint() {
                return document.getElementById("endpoint").value;
            }

            function getXmlHttpObject() {
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

            function listBooks() {
                var endPoint = getBaseEndPoint();

                document.getElementById( "method" ).innerHTML = "Method: GET";
                document.getElementById( "URL" ).innerHTML = "URL: " + endPoint;

                let xmlObj = new getXmlHttpObject();
                xmlObj.open( "GET", endPoint, true );
                xmlObj.onreadystatechange = () => {
                    if ( xmlObj.readyState===XMLHttpRequest.DONE ) {
                        var bookSelect = document.getElementById( "bookList" );

                        bookSelect.options.length = 0;

                        var books = JSON.parse( xmlObj.responseText);

                        for (i = 0; i < books.length; i++) {
                            var currentBook = books[i];

                            var value = currentBook.title;
                            var option = currentBook.title;

                            try {
                                bookSelect.add(new Option("", value), null);
                            } catch (e) {
                                bookSelect.add(new Option("", value));
                            }

                            bookSelect.options[i].innerHTML = option;
                        }
                    }
                };
                xmlObj.send(null);
            }

            function bookSelected(theSelect) {
                var bookName = theSelect.value;
                var endPoint = encodeURI( getBaseEndPoint() + "/book/by/title/" + bookName );

                document.getElementById( "method" ).innerHTML = "Method: GET";
                document.getElementById( "URL" ).innerHTML = "URL: " + endPoint;

                let xmlObj = new getXmlHttpObject();
                xmlObj.open( "GET", endPoint, true );
                xmlObj.onreadystatechange = () => {
                    if ( xmlObj.readyState===XMLHttpRequest.DONE ) {
                        var book = JSON.parse( xmlObj.responseText );

                        document.getElementById("isbn").innerHTML = book.isbn;
                        document.getElementById("price").innerHTML = book.price;
                        document.getElementById("quantity").innerHTML = book.quantity;

                        DownloadBookCover(bookName, book.isbn);
                    }
                    
                };
                xmlObj.send(null);
            }
            
            function DownloadBookCover(bookName, bookISBN) {
                let img = document.getElementById( "image" );

                img.src = "https://covers.openlibrary.org/b/ISBN/" + bookISBN + "-M.jpg";
                img.title = bookName;
            }
        </script>

        <style>
            textarea {
                resize:			none;
            }

            .outputStyle {
                margin:                 auto;
                border-style:		double;
                display:                flex;
                justify-content:        left;
                width:                  50%;
                height:                 200px;
                overflow-y:             auto;
            }

            .boldStyle {
                font-weight:		bold;
            }
        </style>
    </head>

    <body onload="init()" >
        <h2>BookStore REST Example!</h2>

        <p><a target="_blank" href="${pageContext.request.contextPath}/rest/application.wadl?detail=true">Service Description</a></p>

        <p>Service endpoint: <input type="text" name="endpoint" id="endpoint" size="80"></p>

        <br>

        <button onclick="listBooks()">List all Books (GET)</button>&nbsp;&nbsp;

        <div class="boldStyle" id="method">Method: </div>

        <div class="boldStyle" id="URL">URL: </div>		

        <table align="center" border ="0">

            <tr>
                <td>
                    <select name="bookList" id="bookList" size="10" onchange="bookSelected(this)" >
                    </select>
                </td>

                <td></td>

                <td>
                    <table align="center" border ="1">
                        <tr>
                            <td>
                                <p>ISBN:</p>
                                <div id="isbn"></div>

                                <p>Price:</p>
                                <div id="price"></div>

                                <p>Quantity:</p>
                                <div id="quantity"></div>          
                            </td>
                            <td>
                                <img id="image" alt="Book cover" height="250"> 
                            </td>
                        </tr>
                    </table>          
                </td>
            </tr>

        </table>


    </body>
</html>
