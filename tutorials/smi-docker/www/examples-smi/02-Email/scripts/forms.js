// The Contact Select has change
function SelectContactChange(theSelect) {
    var currentOption = theSelect.options[theSelect.selectedIndex];
    var email = currentOption.value;
    var name = currentOption.text;
    
    document.getElementById("ToEmailID").value = email;
    document.getElementById("ToNameID").value = name;
}

//Fill in the counties for the new district
function SelectDistrictHandleReply() {
  
  //alert( xmlHttp.readyState );
  
  if( xmlHttp.readyState === 4 ) {
    var countySelect=

    countySelect.options.length = 0;

    //alert( xmlHttp.responseText );
    
    var counties = JSON.parse( xmlHttp.responseText );
    
    //alert( counties );

    for (i=0; i<counties.length; i++) {
      var currentCounty = counties[i];
      
      var value  = currentCounty.idCounty;
      var option = currentCounty.nameCounty;
	  
      try{
        countySelect.add( new Option("", value), null);
      }
      catch(e) {
        countySelect.add( new Option("", value) );
      }
      
      countySelect.options[i].innerHTML = option;
    }
  }
}

//The County Select has change
function SelectCountyChange(theSelect) {
  // The new option
  var selectedCounty = theSelect.value;
  
  var selectedDistrict = document.getElementById( "district" ).value;
  
  // Preparing the arguments to request the zip codes
  var args = "county=" + selectedCounty + "&district=" + selectedDistrict;
  
  xmlHttp = GetXmlHttpObject();
  
  // Using HTTP GET method
  xmlHttp.open("GET", "getZips.php?"+args, true);
  xmlHttp.onreadystatechange=SelectCountyHandleReply;
  xmlHttp.send( null );
  
  // Using HTTP POST method
  //xmlHttp.open("POST", "getZips.php", true);
  //xmlHttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded");
  //xmlHttp.onreadystatechange=SelectCountyHandleReply;
  // ensure args is encoded!
  //xmlHttp.send( args ); 
}

//Fill in the Zips for the new county
function SelectCountyHandleReply() {
  
  if( xmlHttp.readyState === 4 ) {
    var zipSelect=document.getElementById("zip");

    for(var count = zipSelect.options.length - 1; count >= 0; count--) {
      zipSelect.options[count] = null;
    }

    var zips = JSON.parse( xmlHttp.responseText );
    
    for (i=0; i<zips.length; i++) {

      var currentZip = zips[i];
      
      var value  = currentZip.id;
      var option = currentZip.value;

      try{
        zipSelect.add( new Option(option, value), null);
      }
      catch(e) {
        zipSelect.add( new Option(option, value) );
      }
    }
  }
}
