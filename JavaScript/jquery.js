var valid_email = false;
var valid_name = false;
var valid_surname = false;
var valid_username_length = false;
var valid_pass_length = false;
var valid_captcha = false;
var valid = false;

$(window).on('load', loadPage)

function loadPage(){
    $("#registration-button").attr('disabled',true);

    if($("#name").val().length>1 || $("#surname").val().length>1 || $("#username").val().length>1 || $("#pass").val().length>1 || $("#pass-valid").val().length>1 || $("#email").val().length>1) {

    }else event.preventDefault();

    //CHECK EMAIL FORMAT
    $("#email").focusout(function () {
        var regMail = new RegExp(/^[a-zA-Z0-9]{1,}\.{0,1}[a-zA-Z0-9]{1,}@{1}[a-zA-Z0-9]{1,}\.{1}[a-zA-Z]{2,}$/);
        var mail = $("#email").val();
        if (regMail.test(mail)) {
            valid_email = true;
            alert (valid_email);
            $('#email').removeClass("error-input");

        } else {
            valid_email = false;
            $('#email').addClass("error-input");


        }
    });
    //CHECK IF NAME HAS MIN OF 3 CHARS AND STARTS WITH CAPITAL LETTER
    $("#name").on("blur", function () {
        var name = $("#name").val();
        $('#name').removeClass("error-input");
        if (name.length < 3 || name[0] != name[0].toUpperCase()) {
            valid_name = false;
            $('#name').addClass("error-input");
            event.preventDefault();
        }
        else {
            valid_name = true;
            $('#name').removeClass("error-input");
        }
    });

    //CHECK IF SURNAME HAS MINIMUM OF 3 CHARS AND STARTS WITH CAPITAL LETTER
    $("#surname").on("blur", function () {
        var surrname = $("#surname").val();
        $('#surname').removeClass("error-input");
        if (surrname.length < 3 || surrname[0] != surrname[0].toUpperCase()) {
            $('#surname').addClass("error-input");
            valid_surname = false;
            event.preventDefault();
        }
        else {
            valid_surname = true;
            $('#surname').removeClass("error-input");
        }

    });

    //CHECK USERNAME LENGTH
    $("#username").on("blur", function () {
        var username = $('#username').val();
        $('#username').removeClass("error-input");
        if (username.length < 5 || username.length > 25) {
            $('#username').addClass("error-input");
            valid_username_length = false;
            event.preventDefault();
        }

        else {
            $('#username').removeClass("error-input");
            valid_username_length = true;
        }
    });

    //CHECK PASSWORD LENGTH
    $("#pass").on("blur", function () {
        var pass = $("#pass").val();
        $('#pass').removeClass("error-input");
        if (pass.length < 5 || pass.length > 25) {
            $('#pass').addClass("error-input");
            valid_pass_length = false;
            event.preventDefault();
        }
        else {
            $('#pass').removeClass("error-input");
            valid_pass_length = true;
        }


    });


//CHECK CAPTCHA
    var captcha;
    function generateCaptcha(){
        var a = Math.floor((Math.random() * 10));
        var b = Math.floor((Math.random() * 10));
        var c = Math.floor((Math.random() * 10));


        captcha=a.toString()+b.toString()+c.toString();

        document.getElementById("captcha").innerHTML = captcha;
        document.getElementById("captcha").value = captcha;

    }

    generateCaptcha();

    $("#generateCap").on('click',generateCaptcha);

    $("#inputText").on('blur',function () {
        var input=document.getElementById("inputText").value;
        if(input==captcha){
            $("#registration-button").removeAttr('disabled',true);
            valid_captcha=true;
        }
        else{
            valid_captcha=false;
        }
    });
    if (valid_pass_length && valid_username_length && valid_surname && valid_name && valid_email && valid_captcha) {
        $("#registration-button").attr("action","../database/insertNewUser.php")
        $("#registration-button").removeAttr('disabled',true);
        return valid = true;
    }
}

var userCheck;
$("#username").on('blur',function () {
    var user = $("#username").val();
    if(user != ''){
        $.ajax({
            url: 'database/UserCheck.php',
            type: 'GET',
            data: {'username': user,
                'idUser': "ajaxCheckUsername"},
            dataType:'xml',
            success: function(xml){
                $(xml).find('users').each(function () {
                    userCheck = $(this).find('unavailable').text();
                });
                if (userCheck == 0) {
                    alert("Ne postoji");
                    valid=true;
                } else {
                    alert("Postoji u bazi!");
                    $("#username").addClass("error-input");
                    valid=false;
                }

            },
            error: function () {

            }
        });


    }
});


//unction validate(event) {


  //

//}



