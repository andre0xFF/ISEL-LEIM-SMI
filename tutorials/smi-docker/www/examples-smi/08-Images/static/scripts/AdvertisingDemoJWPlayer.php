var endedJWPlayer;
    
var addStartTimeJWPlayer = 3;
var addEndTimeJWPlayer = 12;

// Execute this for each second when playing the Video
function catchTheFrameJWPlayer() {

  if ( endedJWPlayer === true ) {
    return;
  }
  var currentVideoTime;
  // CurrentTime is float
  // Make it whole number to check
  currentVideoTime = Math.round( jwplayer( "video_area" ).getPosition() ); 

  // Show the current playing time in seconds
  showTimeJWPlayer( currentVideoTime );

  // Target Second when we want to show the message/ad
  if ( 
          (currentVideoTime >= addStartTimeJWPlayer) && 
          (currentVideoTime <= addEndTimeJWPlayer) ) {
    // Show the message/ad
    showAdvertingJWPlayer();
  }
  else {
    // Show the message/ad
    hideAdvertingJWPlayer();
  }	
}

function initializeJWPlayer() {
  // Hide adverting when page loaded
  hideAdvertingJWPlayer();

  // Advertising not ended
  endedJWPlayer = false;

  jwplayer( "video_area" ).setup({
        autostart: "false",
        author: "Carlos Gonçalves",
        date: "<?php echo date('F d Y'); ?>",
        width: 640,
        height: 480,
        playlist: [{
            title: "The video title",
            description: "One video file in mp4 format",
            image: "videoDemo.jpg",
            sources: [{ 
                file: "videoDemo.mp4",
                type: "mp4"
            }],
            tracks: [
              {
                file: "subtitles/vtt/videoDemo-en.vtt",
                label: "English",
                kind: "Subtitles"
              },
              {
                file: "subtitles/vtt/videoDemo-fr.vtt",
                label: "Français",
                kind: "Subtitles"
              },
              {
                file: "subtitles/vtt/videoDemo-de.vtt",
                label: "Deutsch",
                kind: "Subtitles"
              },
              {
                file: "subtitles/vtt/videoDemo-pt.vtt",
                label: "Português",
                kind: "Subtitles",
                "default": true
              },
              {
                file: "subtitles/vtt/videoDemo-thumbnails.vtt",
                kind: "thumbnails"
              }
            ]
        }]          
  });

  jwplayer( "video_area" ).onPlay( evtPlayingJWPlayer );

  jwplayer( "video_area" ).onComplete( evtEndedJWPlayer );
}

// Show the Adv Box i.e. the DIV
function showAdvertingJWPlayer() {
  document.getElementById( "ad_area" ).style.visibility="visible";
}

// Hide the Adv Box i.e. the DIV
function hideAdvertingJWPlayer() {
  document.getElementById( "ad_area" ).style.visibility="hidden";
}

// Show the current video time
function showTimeJWPlayer(currentTime) {
  var message;
  message = "Current Time: " + currentTime + " seconds";
  document.getElementById( "seek_status" ).innerHTML = message;
}

// Hide the current video time
function hideSeekTimeJWPlayer() {
  document.getElementById( "seek_status" ).innerHTML = "";
}

// Show the current video time
function evtPlayingJWPlayer() {
  setInterval( catchTheFrameJWPlayer, 500 );
}

function evtEndedJWPlayer() {
  endedJWPlayer = true;
  
  hideSeekTimeJWPlayer();
}
