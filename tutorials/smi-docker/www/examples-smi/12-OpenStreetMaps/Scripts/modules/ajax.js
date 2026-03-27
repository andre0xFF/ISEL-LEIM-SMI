
export function getXmlHttpObject() {
    console.log( "ajax#getXmlHttpObject() called" );
    
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
