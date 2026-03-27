var pathStaticVFF = "./VTT/Thumbs/BigBuckBunny-thumbs.vtt";
var pathGeneratedVTT = "./VTT/Thumbs/BigBuckBunny-thumbs-sprite.vtt";

var thumbnails = [];

var baseLeft = -320;

function updatePreviewPosition(event, videoThumbPreviewID) {
    let bounds = event.target.getBoundingClientRect();
    let pos = baseLeft + Math.floor( event.clientX-bounds.left );

    document.getElementById( videoThumbPreviewID ).style.left = pos+"px";
}

// Convert a time string (HH:MM:SS) into seconds
function timeStringToSeconds(timeString) {
    let parts = timeString.split(':');
    return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + parseFloat(parts[2]);
}

// Load and parses the VTT file
function loadStaticVTT() {
    fetch( pathStaticVFF )
        .then( response => response.text() )
        .then( data => {
            var lines = data.trim().split('\n');

            // Ignora a primeira linha (cabeçalho WEBVTT)
            for (let i = 1; i < lines.length; ++i) {
                if ( lines[i].trim().length===0) {
                    continue;
                }
                let partsTime = lines[i].split(' --> ');

                let startTime = partsTime[0];
                let endTime = partsTime[1];
                ++i;
                let url = lines[i];                            
                let entry = {
                    startTime: timeStringToSeconds( startTime ), 
                    endTime: timeStringToSeconds( endTime ), 
                    url: url
                };
                thumbnails.push( entry );
            }                        
        } );
}

// Load and parses the VTT file
function loadGeneratedVTT() {
    fetch( pathGeneratedVTT )
        .then( response => response.text() )
        .then( data => {
            var lines = data.trim().split('\n');

            // Igniore the VTT file header (header WEBVTT)
            for (let i = 1; i < lines.length; ++i) {
                // Ignore all blank lines
                if ( lines[i].trim().length===0) {
                    continue;
                }

                // Parse the times (start and end)
                let partsTime = lines[i].split(' --> ');

                let startTime = partsTime[0];
                let endTime = partsTime[1];
                ++i;

                // Parse the URL
                let rawURL = lines[i];

                let partsURL = rawURL.split('#')[1].split('=')[1].split(',');
                let x = parseFloat( partsURL[0] );
                let y = parseFloat( partsURL[1] );
                let width = parseFloat( partsURL[2] );
                let height = parseFloat( partsURL[3] );

                // Extract the URL
                var url = rawURL.split('#')[0].trim();

                let entry = {
                    startTime: timeStringToSeconds( startTime ), 
                    endTime: timeStringToSeconds( endTime ), 
                    url: url,
                    x: x,
                    y: y,
                    width: width,
                    height: height
                };
                thumbnails.push( entry );
            }                        
        } );
}

function displayThumbnailsStaticVTT(event, videoID, videoThumbPreviewID) {
    let video = document.getElementById( videoID );
    let thumbnailsContainer = document.getElementById( videoThumbPreviewID );

    let currentTime = (event.offsetX / event.target.clientWidth) * video.duration;

    // Shearch for the thumbnail that corresponds to the current time
    let currentThumbnail = null;
    for (let i = 0; i < thumbnails.length; i++) {
        if ( thumbnails[i].startTime <= currentTime && thumbnails[i].endTime >= currentTime ) {
            currentThumbnail = thumbnails[i];
            break;
        }
    }

    if ( currentThumbnail ) {
        // Show current thumbnail
        thumbnailsContainer.innerHTML = '';
        let thumbnail = new Image();
        thumbnail.src = currentThumbnail.url;

        // Avoid image distortion
        thumbnail.style.objectFit = 'none';

        thumbnailsContainer.appendChild( thumbnail );
        thumbnailsContainer.style.display = 'block';

        updatePreviewPosition( event, videoThumbPreviewID );
    }
    else {
        // Hide the thumbnail display area
        thumbnailsContainer.style.display = 'none';
    }
}

// Display a thumbnail
function displayThumbnailsGeneratedVTT(event, videoID, videoThumbPreviewID) {
    let video = document.getElementById( videoID );
    let thumbnailsContainer = document.getElementById( videoThumbPreviewID );

    let currentTime = (event.offsetX / event.target.clientWidth) * video.duration;

    // Shearch for the thumbnail that corresponds to the current time
    let currentThumbnail = null;
    for (let i = 0; i < thumbnails.length; i++) {
        if ( thumbnails[i].startTime <= currentTime && thumbnails[i].endTime >= currentTime ) {
            currentThumbnail = thumbnails[i];
            break;
        }
    }

    if ( currentThumbnail ) {
        // Show current thumbnail
        thumbnailsContainer.innerHTML = '';
        let thumbnail = new Image();
        thumbnail.src = currentThumbnail.url;

        // Set width and height for the current thumbnail
        thumbnail.style.width = currentThumbnail.width + 'px';
        thumbnail.style.height = currentThumbnail.height + 'px';

        // Avoid image distortion
        thumbnail.style.objectFit = 'none';

        // Set the cliping area
        thumbnail.style.objectPosition = '-' + currentThumbnail.x + 'px -' + currentThumbnail.y + 'px';

        thumbnailsContainer.appendChild( thumbnail );
        thumbnailsContainer.style.display = 'block';
        
        updatePreviewPosition( event, videoThumbPreviewID );
    }
    else {
        // Hide the thumbnail display area
        thumbnailsContainer.style.display = 'none';
    }
}

function initEventsStaticVTT( videoID, videoThumbPreviewID ) {
    let video = document.getElementById( videoID );

    // Add an event listener to the progess bar
    video.addEventListener( 
        'mousemove', 
        function(event) {
            displayThumbnailsStaticVTT(event, videoID, videoThumbPreviewID);
        } 
    );

    // Hide the thumbnail preview area when the mouse leave the progress bar
    video.addEventListener(
        'mouseout', 
        function(event) {
            document.getElementById( videoThumbPreviewID ).style.display = 'none';
        }
    );
}

function initEventsGeneratedVTT( videoID, videoThumbPreviewID ) {
    // Add an event listener to the progess bar
    document.getElementById( videoID ).addEventListener( 
        'mousemove', 
        function(event) {
            displayThumbnailsGeneratedVTT(event, videoID, videoThumbPreviewID);
        } 
    );

    // Hide the thumbnail preview area when the mouse leave the progress bar
    document.getElementById( videoID ).addEventListener(
        'mouseout', 
        function(event) {
            document.getElementById( videoThumbPreviewID ).style.display = 'none';
        }
    );
}

// Init JavaScript code
function onLoadStaticVTT() {
    loadStaticVTT();                
    initEventsStaticVTT( 'TheVideo', 'TheVideoThumbPreview' );
}

// Init JavaScript code
function onLoadGeneratedVTT() {
    loadGeneratedVTT();                
    initEventsGeneratedVTT( 'TheVideo', 'TheVideoThumbPreview' );
}
