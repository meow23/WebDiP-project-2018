
$(window).on('load',function () {

    /*function postaviCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "istice=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        alert("Ova stranica sprema kolačiće!!");
    }

    function dohvatiCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function provjeriCookie() {
        var cookie = dohvatiCookie("prvi_dolazak");

        if (cookie == "") {

            postaviCookie("prvi_dolazak", 1, 1);

        }
    }*/
})
    //LOGIN CHECK
    var userCheck;
    $("#user-login").on('blur', function () {
        var user = $("#user-login").val();
        var pass = $("#pass-login").val();
        if (user != '' && pass != '') {
            $.ajax({
                url: 'database/loginUser.php',
                type: 'GET',
                data: {
                    'user-login': user,
                    'pass-login': pass},
                dataType: 'xml',
                success: function (xml) {
                    $(xml).find('user').each(function () {
                        userCheck = $(this).find('validUser').text();
                    });
                    if (userCheck == 0) {
                        alert("Korisnicko ime ili lozinka nisu valjani!");
                        $("#user-login").addClass("error-input");
                        event.preventDefault();

                    } else {
                        alert("Prijava uspješna!");



                    }

                },
                error: function () {

                }
            });


        }
    })
