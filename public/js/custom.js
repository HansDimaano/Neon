// Define a variable for the selected button color
var selectedButtonsColor = "#00C292";

// Get the CSRF token from the meta tag
var csrf = document.querySelector('meta[name="csrf-token"]').content;

// Add a click event listener to the element with id "favBtn"
$("#favBtn").on('click', function(event) {
    console.log("Clicked");
    makeFav();
});

// Add a click event listener to the element with id "followBtn"
$("#followBtn").on('click', function(event) {
    console.log("Clicked");
    makeFollow();
});

// Function to handle making a favorite
function makeFav() {
    // Send a POST request to the "favRoute" with the CSRF token
    jQuery.post(
        favRoute, {
            '_token': csrf
        },
        function(data, success) {
            console.log(data);
            console.log(success);
            // Update the button color based on the response data
            if (data == "1") {
                jQuery("#favBtn").css({
                    "color": selectedButtonsColor
                });
            } else if (data == "0") {
                jQuery("#favBtn").css({
                    "color": "white"
                });
            }
        }
    )
    .fail(function(success) {
        console.log("Failed: " + success.status);
    });
}

// Function to handle making a follow
function makeFollow() {
    // Send a POST request to the current URL with the "card" parameter and CSRF token
    jQuery.post(
        window.location.href + '/' + card + "/makefollow", {
            '_token': csrf
        },
        function(data, success) {
            console.log(data);
            console.log(success);
            // Update the follow button icon and text based on the response data
            if (data == "1") {
                jQuery("#followBtni").removeClass('fa-hand-o-right').addClass('fa-hand-o-lefti');
                jQuery("#followBtnt").html("Following");
            } else if (data == "0") {
                jQuery("#followBtni").removeClass('fa-hand-o-left').addClass('fa-hand-o-right');
                jQuery("#followBtnt").html("Follow");
            }
        }
    )
    .fail(function(success) {
        console.log("Failed: " + success.status);
    });
}
