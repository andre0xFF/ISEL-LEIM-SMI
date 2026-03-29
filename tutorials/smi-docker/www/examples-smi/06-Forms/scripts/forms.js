// Check to see if e-mail isn't blank and is well formed
// Read more at http://www.marketingtechblog.com/javascript-regex-emailaddress/#ixzz1p1ZDMNZe
var filter;
filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})$/;
//filter = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})$/i;

var nameFilter = /^[a-zA-ZÀ-ÿ\s]{1,50}$/;

//var aliasFilter = /^[a-zA-Z0-9_ ]{3,15}$/;
//var passwordFilter = /^(?=.*[A-Za-z])(?=.*\d).{6,15}$/;

var aliasFilter = new RegExp(window.formPatterns.alias);
var passwordFilter = new RegExp(window.formPatterns.password);

// Validate the login form
function FormLoginValidator(theForm) {
  // Check to see if name isn't blank

  if(!nameFilter.test(theForm.name.value.trim())){

    alert("You must enter a valid name between 1 and 50 chars");
    theForm.name.focus();
    return false;
  }
  
  if ( !filter.test( theForm.email.value.trim() ) ) {
    alert('Please provide a valid e-mail address');
    theForm.email.focus();
    return false;
  }
  
  return true;
}

function FormUpdateProfileValidator(theForm) {


  if(!aliasFilter.test(theForm.alias.value.trim())){
    alert("Alias must have 3 to 15 letters, numbers or underscore.");
    theForm.alias.focus();
    return false;
  }

  if(!passwordFilter.test(theForm.password.value.trim())){

    alert("Password must be between 6 and 15 chars, letters and number.");
    theForm.password.focus();
    return false;
  }

  if(!theForm.age[0].checked &&
      !theForm.age[1].checked &&
      !theForm.age[2].checked &&
      !theForm.age[3].checked){

    alert("You must select an age range.");
    theForm.age[0].focus();
    return false;
  }

  if(theForm.district.value=== ""){
    alert("You must select a district");
    theForm.district.focus();
    return false;
  }

  if(theForm.county.value ===""){
    alert("You must select a county.");
    theForm.county.focus();
    return false;
  }

  if(theForm.zip.value ===""){
    alert("You must select a zip-code.");
    theForm.zip.focus();
    return false
  }

  if(theForm.comments.value.length > 200){
    alert("Comment must be a max of 200 characters.");
    theForm.comments.focus();
    return false;
  }

  return true;
}

var xmlHttp;

function GetXmlHttpObject() {
  try {
    return new ActiveXObject("Msxml2.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new ActiveXObject("Microsoft.XMLHTTP");
  } catch(e) {} // Internet Explorer
  try {
    return new XMLHttpRequest();
  } catch(e) {} // Firefox, Opera 8.0+, Safari
  alert("XMLHttpRequest not supported");
  return null;
}

// The District Select has change
function SelectDistrictChange(theSelect) {
  // The new option
  var selectedDistrict = theSelect.value;
  
  // The new image to display
  var districtImageFile = "images/distritos/" + selectedDistrict + ".gif";
  document.getElementById("imgDistrict").src = districtImageFile;

  // Preparing the arguments to request the counties
  var args = "district="+selectedDistrict;
  
  // With HTTP GET method
  xmlHttp = GetXmlHttpObject();
  xmlHttp.open("GET", "getCounties.php?"+args, true);
  xmlHttp.onreadystatechange=SelectDistrictHandleReply;
  xmlHttp.send(null);
}

//Fill in the counties for the new district
function SelectDistrictHandleReply() {
  
  //alert( xmlHttp.readyState );
  
  if( xmlHttp.readyState === 4 ) {
    var countySelect=document.getElementById("county");

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
