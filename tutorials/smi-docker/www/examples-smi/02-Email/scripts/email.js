function viewPassword() {
    var passwordInput = document.getElementById( "passwordID" );
    var passStatus = document.getElementById( "passwordStatusID" );
 
    if ( passwordInput.type === "password" ){
        passwordInput.type = "text";
        passStatus.className = "fa fa-eye-slash";
    }
    else{
        passwordInput.type = "password";
        passStatus.className= "fa fa-eye";
    }
}



