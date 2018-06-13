window.onload = function (){

    var valid_email = false;
    var valid_length = false;
    var valid_pass_match = false;
    var valid_name = false;
    var valid_surname = false;
    var valid_username_length = false;
    var valid_pass_length = false;

    //CHECK EMAIL FORMAT
    $("#email").keyup(function () {
        var regMail = new RegExp(/^[a-zA-Z0-9]{1,}\.{0,1}[a-zA-Z0-9]{1,}@{1}[a-zA-Z0-9]{1,}\.{1}[a-zA-Z]{2,}$/);
        var regMailZnak = new RegExp(/.{10,30}/);
        var mail = $("#email").val();
        if (regMail.test(mail) && regMailZnak.test(mail)) {
            valid_email = true;
            $('#email').removeClass("error-input");
        } else {
            valid_email = false;
            $('#email').addClass("error-input");
        }
    });

    //CHECK PASSWORD LENGTH MATCHES REPEAT PASSWORD LENGTH
    $("#pass-valid").focusout(function () {
        if($("#pass-valid").length == $("#pass").length)
            valid_length = false;
        else valid_length = true;
    });

    //CHECK IF PASSWORD VALUE MATCHED PASSWORD REPETITION VALUES
    $("#pass-valid").focusout(function () {
        if($("#pass-valid").val()==$("#pass").val())
            valid_pass_match = false;
        else valid_pass_match = true;
    });

    //CHECK IF NAME HAS MIN OF 3 CHARS AND STARTS WITH CAPITAL LETTER
    $("#name").focusout(function () {
        if($("#name").length < 3 && $("#name")[0]!=$("#name")[0].toUpperCase())
            valid_name = false;
        else valid_name = true;
    });

    //CHECK IF SURNAME HAS MINIMUM OF 3 CHARS AND STARTS WITH CAPITAL LETTER
    $("#surname").focusout(function () {
        if($("#surname").length < 3 && $("#surname")[0]!=$("#surname")[0].toUpperCase())
            valid_surname = false;
        else valid_surname = true;
    });

    //CHECK USERNAME LENGTH
    $("#username").focusout(function () {
        if($("#username").length<5)
            valid_username_length = false;
        else valid_username_length = true;

    })

    //CHECK PASSWORD LENGTH
    $("#pass").focusout(function () {
        if($("#pass").val()<8)
            valid_pass_length = false;
        else valid_pass_length = true;
    });


    //CHECKUP VALIDATION
    if(!valid_email||!valid_length||!valid_pass_match||!valid_name||!valid_surname){
            $("#registration-button").prop('disabled',true);
    }

}

