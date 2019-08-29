// Custom JS Functionality

function reRoute(place)
{
    location.replace(place);
}

$(document).ready(function() {
    $("#editProfile").toggle();

    $('#editButton').click(function () {
        $("#editProfile").toggle("slow");
        $("#currentProfile").toggle("slow");
        var button = document.getElementById("editButton");
        if (button.value == "Edit my profile") {
            button.value = "Submit Changes";
            $("#editProfile").load("views/account/editProfile.phtml");
            $("#editButton").attr("form", "");
        } 
        else {
            button.value = "Edit my profile";
            $("#editButton").attr("form", "updateProfile");
        }
    })
})
