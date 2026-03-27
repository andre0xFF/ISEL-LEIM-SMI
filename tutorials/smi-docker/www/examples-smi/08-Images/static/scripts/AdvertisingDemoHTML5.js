// Get the Video Object
var theVideo;

var endedHTML5;
    
var addStartTimeHTML5 = 3;
var addEndTimeHTML5 = 12;

// Show the Adv Box i.e. the DIV
function showAdvertingHTML5() {
  document.getElementById( "ad_area" ).style.visibility="visible";
}

// Hide the Adv Box i.e. the DIV
function hideAdvertingHTML5() {
  document.getElementById( "ad_area" ).style.visibility="hidden";
}

function showTimeHTML5(currentTime) {
  var message;
  message = "Current Time: " + currentTime + " seconds";
  document.getElementById( "seek_status" ).innerHTML = message;
}

function hideSeekTimeHTML5() {
  document.getElementById( "seek_status" ).innerHTML = "";
}

// Execute this for each second when playing the Video
function catchTheFrameHTML5() {
  
  if ( endedHTML5 === true ) {
    return;
  }
  var currentVideoTime;
  // CurrentTime is float
  // Make it whole number to check
  currentVideoTime = Math.round( theVideo.currentTime ); 

  // Show the current playing time in seconds
  showTimeHTML5( currentVideoTime );

  // Target Second when we want to show the message/ad
  if ( 
          (currentVideoTime >= addStartTimeHTML5) && 
          (currentVideoTime <= addEndTimeHTML5) ) {
    // Show the message/ad
    showAdvertingHTML5();
  }
  else {
    // Show the message/ad
    hideAdvertingHTML5();
  }	
}

function evtPlayingHTML5() {
  setInterval( catchTheFrameHTML5, 500 );
}

function evtEndedHTML5() {
  endedHTML5 = true;
  
  theVideo.removeEventListener( 'playing', evtPlayingHTML5);
  
  hideSeekTimeHTML5();
}

function initializeHTML5() {
  // Hide adverting when page loaded
  hideAdvertingHTML5();
  
  // Advertising not ended
  endedHTML5 = false;
  
  // Handle the event playing 
  theVideo.addEventListener( 'playing', evtPlayingHTML5, false);
  
  // Handle the event event
  theVideo.addEventListener( 'ended', evtEndedHTML5, false);
}









