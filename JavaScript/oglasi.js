$(window).on('load',function () {



})
$("#categoryAd").on('blur',function () {
    var cat = $("#categoryAd").val();
    if(cat != ''){
        $.ajax({
            url: 'database/categoryAd.php',
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