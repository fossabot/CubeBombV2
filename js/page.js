$(document).ready(function(){
    $("#sidebar .block > .button").mouseenter(function(){
        $(this).find(".rightArrow").css({opacity: 1});
        $(this).find(".sprite").removeClass("sprite").addClass("sprite-white");
    }).mouseleave(function(){
        $(this).find(".rightArrow").css({opacity: 0});
        $(this).find(".sprite-white").removeClass("sprite-white").addClass("sprite");
    });
    
    $("[title]").tipsy();
    //$("#nav .time").tipsy({gravity: "s", delayIn: 1000});
});


String.prototype.startsWith = function(prefix) {
    return this.indexOf(prefix) === 0;
}

String.prototype.endsWith = function(suffix) {
    return this.match(suffix+"$") == suffix;
};


/* http://www.quirksmode.org/js/cookies.html */
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}



/* Merged into this file since forms are on every page */

// Form handler script copyright 2013/14
// Author: Taylor Swanson
// Custom modifications for CubeBomb

// Document structure
//   Form method=post, id=something-unique, action=handler_url
//    -Input name="title"                                                   // Name is minimum required tag
//    -Input name="emailaddr" class="required" validate="email"             // Validate tag identifies type (email, phone, all-or-none)
//    -Input name="message" class="required"
//    -Submit

// Ajax server responses:
// x: General error (usually unknown/strange error)
// y: Form submitted, success.
//    Any other response is assumed to be an error message (E.g. "email address invalid.")

$(document).ready(loadForms);

function loadForms(){
    // Cycle through all forms on the document and add trigger events for form submit
    $(document).find("form").each(function(){
        // Error flag for this form
        errorOccurred = false;
        
        var form = $(this);
        
        // Find all text inputs in this field with a label tag
        $(this).find("input[label], textarea[label]").each(function(){
            if ($.trim($(this).val()) == "" && !$(this).hasClass("hint")){
                // This field doesn't have a value yet
                $(this).val($(this).attr("label"));
                $(this).addClass("hint");
            }
            
            // Attach neccesary triggers
            $(this).focus(function(){
                // Test to see if the content is the hint content
                if ($.trim($(this).val()) == $(this).attr("label")){
                    // Remove hint style and clear content, ready for user input.
                    $(this).removeClass("hint");
                    $(this).val("");
                }
            });
            
            $(this).blur(function(){
                // Test to see if there is valuable content
                if ($.trim($(this).val()) == ""){
                    // If not, apply the hint class and reset to the hinting content
                    $(this).val($(this).attr("label"));
                    $(this).addClass("hint");
                }
            });
            
            // Capture enter key here
            if ($(this).hasClass("form-enter")){
                $(this).keypress(function(ev) {
                    var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                    if (keycode == "13") {
                        form.find(".submit").click();
                    }
                });
            }
        });
        
        form.find(".submit").click(function(e){
            // Prevent the click from triggering any other events.
            // Don't allow form to be submitted prematurely
            e.preventDefault();
            
            if ($(this).hasClass("disabled")){
                return;
            }
            
            // Check required fields
            errorOccurred = false;
            flagFields(form);

            if (!errorOccurred){
                // No errors caused by empty fields.
                
                // Disable button and attach disabled class
                $(this).addClass("disabled");
                $(this).attr("disabled");
                
                form.find(".error").hide();
                
                // Convert the inputs into postable data
                formData = form.serialize();
                
                // Post data to handler given in form action  field.
                // Response body sent to "response" field of function when request finishes
                $.post(form.attr("action"), formData, function(response){
                    switch(response){
                        case "x":
                            error("Unknown error.", form);
                            
                            $(this).removeClass("disabled");
                            $(this).attr("disabled", false);
                            break;
                        case "y":
                            // Success -- Redirect to url in "success" tag of form
                            if (form.attr("success") != undefined){
                                window.location = form.attr("success");
                            }
                            
                            $(this).removeClass("disabled");
                            $(this).removeAttr("disabled");
                            
                            break;
                        default:
                            if (response.startsWith("@setcookie! ")){
                                finalString = response.substr(12);
                                
                                createCookie("login", finalString, 7);
                                window.location.reload();
                            }else{
                                // Got text as response. Assume it is an error.
                                error(response, form);

                                $(this).removeClass("disabled");
                                $(this).removeAttr("disabled");
                            }
                            
                            break;
                    }
                });
            }
        });
    });
};

// Validates email address using regex.
// Should have good accurracy. Regex is used server-side as well.
// Returns FALSE when regex doesn't match
function validateEmail(email){
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validatePhone(phone){
    // ###-###-####
    // #-###-###-####
    // ##########
    // +### ##-###-####
    // ###.###.####
    // (###)### ####
    var regex = /([\+(]?(\d){2,}[)]?[- \.]?(\d){2,}[- \.]?(\d){2,}[- \.]?(\d){2,}[- \.]?(\d){2,})|([\+(]?(\d){2,}[)]?[- \.]?(\d){2,}[- \.]?(\d){2,}[- \.]?(\d){2,})|([\+(]?(\d){2,}[)]?[- \.]?(\d){2,}[- \.]?(\d){2,})/;
    return regex.test(phone);
}

// Trigger error element on specified form element.
function error(string, form){

    var error = form.find(".error");          // Error is expected to be direct ancestor of form.
	error.html(string);
	error.show();
	
    // Throw flag
	errorOccurred = true;
	
	form.find(".submit").removeProp("disabled");
	form.find(".submit").removeClass("disabled");
}

// Flags provides feedback to the user that a field is incorrect.
function flag(formElement){
    formElement.addClass("flagged");
}

// Reflag fields and trigger errors
function flagFields(form){
    errorOccurred = false;                  // Whether or not to throw an error.
    incompleteErrorOccurred = false;        // Prevent duplicate "please fill out all required fields" error.
    errorString = "";                       // List of errors that have occurred.
    
    form.find("input, select, textarea").each(function(){
        // Unflag previous fields if any.
        $(this).removeClass("flagged");
        
        // Validate specialized fields
        if ($(this).attr("validate") == "email"){
            if (validateEmail($.trim($(this).val())) == false){
                $(this).addClass("flagged");
                
                errorOccurred = true;
                errorString += "<li> " + "Email address is invalid." + "</li>";
            }
        }else if ($(this).attr("validate") == "phone"){
            if (validatePhone($.trim($(this).val())) == false){
                $(this).addClass("flagged");
                
                errorOccurred = true;
                errorString += "<li>" + "Phone is invalid." + "</li>";
            }
        }else if ($(this).attr("validate") == "all-or-none"){
            // Parent is defined using the assumption that this is a table.
            parent = $(this).parent().parent();
            
            // Flag used to determine whether or not there are other inputs in the same parent that have been filled out.
            // The nature of all-or-none means that if this field is not filled out while others are, then there is an issue.
            hasFilledField = false;
            
            // Find all text inputs with all-or-none validation tags
            parent.find("input[validate=\"all-or-none\"], textarea[validate=\"all-or-none\"]").each(function(){
                // Test to see if the field was left blank
                if ($.trim($(this).val()) != "" && $.trim($(this).val()) != $(this).attr("label")){
                    // Field was not blank, therfore there is a field filled out in this group.
                    // Raise the flag indicating that all fields must now be filled out.
                    hasFilledField = true;   
                }
            });
            
            // Test self against rules
            // Determine if field has been modified
            if ($.trim($(this).val()) == "" || $.trim($(this).val()) == $(this).attr("label")){
                // It is in its default state
                if (hasFilledField){
                    // Other fields are filled out but this one is not. 
                    // This is a problem.
                    $(this).addClass("flagged");
                    // Test to see if this sort of error has occurred before
                    if (!incompleteErrorOccurred){
                        errorOccurred = true;
                        errorString += "<li>" + "You missed something." + "</li>";
                        incompleteErrorOccurred = true;
                    }
                }
            }
        }else if ($(this).prop("required") && ($.trim($(this).val()) == "" || $.trim($(this).val()) == $(this).attr("label"))){
            // Flag empty field
            $(this).addClass("flagged");
            
            // Test to see if this sort of error has occurred before
            if (!incompleteErrorOccurred){
                errorOccurred = true;
                errorString += "<li>" + "You missed something." + "</li>";
                incompleteErrorOccurred = true;
            }
        }
        
        // Test to see if there have been any flags.
        // If there are, post generated error message.
        if (errorOccurred){
            error("<ul>" + errorString + "</ul>", form);
        }
    });
}
