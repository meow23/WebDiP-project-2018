$(window).on('load', initializeAdmin);

var brojRedova;

function initializeAdmin() {
    $.ajax({
        async: false,
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': "SELECT promijenjivaVrijednost FROM KonfiguracijaAplikacije WHERE idKonfiguracijaAplikacije = 4"
        },
        success: function (data) {
            var json = JSON.parse(data);

            brojRedova = json["promijenjivaVrijednost"];

        }
    });

    ucitajKonfiguraciju();
    ucitajKategorije();
    ucitajPopisKorisnika();
    ucitajDnevnikPrijava();
    ucitajDnevnikRada();
    ucitajDnevnikBaze();
}


// Konfiguracija

function urediKonfiguraciju(id) {

    var novo = prompt("Unesi novu vrijednost: ");

    if (novo == null) {
        alert("Nije unesena vrijednost");
        return;
    }

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `UPDATE KonfiguracijaAplikacije SET promijenjivaVrijednost = ${novo} WHERE idKonfiguracijaAplikacije = ${id}`
        },
        success: function (data) {
            if (data !== "[]") {
                initializeAdmin();
            }
            else
                alert("Provjerite unos");
        }
    });
}

function ucitajKonfiguraciju() {
    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': "SELECT * FROM KonfiguracijaAplikacije ORDER BY idKonfiguracijaAplikacije"
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#sveKonfiguracije').html("")
            for (var konf of json) {

                $('#sveKonfiguracije').append('<tr>');
                $('#sveKonfiguracije').append('<td>' + konf['idKonfiguracijaAplikacije'] + '</td>');
                $('#sveKonfiguracije').append('<td>' + konf['naziv'] + '</td>');
                $('#sveKonfiguracije').append('<td>' + konf['promijenjivaVrijednost'] + '</td>');
                $('#sveKonfiguracije').append(`<button class="button button-send" onclick="urediKonfiguraciju(${konf['idKonfiguracijaAplikacije']});">Uredi</button>`);
                $('#sveKonfiguracije').append('</tr>');

            }
        }
    });
}

// Kreiranje i dodjela moderatora

function ucitajKategorije() {
    $('#kategorijeTablica').css('display', 'block');
    $('#kategorijeUredi').css('display', 'none');

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': "SELECT * FROM Kategorija_Proizvoda ORDER BY idKategorije"
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#sveKategorije').html("");
            for (var kat of json) {

                $('#sveKategorije').append('<tr>');
                $('#sveKategorije').append('<td>' + kat['idKategorije'] + '</td>');
                $('#sveKategorije').append('<td>' + kat['naziv'] + '</td>');
                $('#sveKategorije').append(`<button class="button button-send" onclick="urediModeratore(${kat['idKategorije']});">Upravljaj</button>`);
                $('#sveKategorije').append('</tr>');

            }
        }
    });
}

function dodajKategoriju() {
    var novo = prompt("Unesite naziv nove kategorije: ");

    if (novo == null) {
        alert("Niste unijeli ništa!");
        return;
    }

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `INSERT INTO Kategorija_Proizvoda(naziv) VALUES ('${novo}')`
        },
        success: function (data) {
            if (data !== "[]") {
                ucitajKategorije();
            }
            else
                alert("Greška");
        }
    });
}

function urediModeratore(id) {
    $('#noviModeratorSelect').html("");
    $('#sviModeratoriKategorije').html("");

    var sqlNovi = `SELECT idKorisnik, korisnicko_ime FROM Korisnik WHERE Uloge_idUloge = 2 AND idKorisnik NOT IN (SELECT idKorisnik FROM Korisnik JOIN Korisnik_has_Kategorija_Proizvoda ON Korisnik.idKorisnik = Korisnik_has_Kategorija_Proizvoda.Korisnik_idKorisnik WHERE Korisnik_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = ${id})`;
    var sqlPostojeci = `SELECT idKorisnik, korisnicko_ime FROM Korisnik JOIN Korisnik_has_Kategorija_Proizvoda ON Korisnik.idKorisnik = Korisnik_has_Kategorija_Proizvoda.Korisnik_idKorisnik WHERE Korisnik_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = ${id}`;

    // Postojeći moderatori
    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': sqlPostojeci
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#sviModeratoriKategorije').html("");
            for (var mod of json) {
                $('#sviModeratoriKategorije').append(`<tr>`);
                $('#sviModeratoriKategorije').append(`<td>${mod['idKorisnik']}</td>`);
                $('#sviModeratoriKategorije').append(`<td>${mod['korisnicko_ime']}</td>`);
                $('#sviModeratoriKategorije').append(`</tr>`);

            }
        }
    });

    // Novi moderatori
    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': sqlNovi
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#noviModeratorSelect').html("");
            for (var mod of json) {

                $('#noviModeratorSelect').append(`<option value="${mod['idKorisnik']}">${mod['korisnicko_ime']}</option>`);

            }
        }
    });


    $('#kategorijeTablica').css('display', 'none');
    $('#kategorijeUredi').css('display', 'block');

    $('#dodajNovogModeratora').on('click', function () {
        if ($('#noviModeratorSelect').val() != null)
      dodajModeratora(id, $('#noviModeratorSelect').val());
      else
          alert('Niste odabrali moderatora!')
    })

}

function dodajModeratora(idKategorija, idKorisnik) {
    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `INSERT INTO Korisnik_has_Kategorija_Proizvoda(Kategorija_Proizvoda_idKategorije, Korisnik_idKorisnik) VALUES ('${idKategorija}', '${idKorisnik}')`
        },
        success: function (data) {
            if (data !== "[]") {
                alert("Moderator dodan");
                $('#dodajNovogModeratora').unbind('click');
                ucitajKategorije();
            }
            else
                alert("Greška");
        }
    });
}

// Blokirani

function ucitajPopisKorisnika() {

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': "SELECT idKorisnik, korisnicko_ime, blokiran FROM Korisnik"
        },
        success: function (data) {
            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#sviKorisniciBlok').html("");
            for (var kat of json) {

                $('#sviKorisniciBlok').append('<tr>');
                $('#sviKorisniciBlok').append('<td>' + kat['idKorisnik'] + '</td>');
                $('#sviKorisniciBlok').append('<td>' + kat['korisnicko_ime'] + '</td>');
                $('#sviKorisniciBlok').append('<td>' + (kat['blokiran'] == 1 ? 'Da' : 'Ne') + '</td>');
                $('#sviKorisniciBlok').append(`<button class="button button-send" style="border-bottom-right-radius: 0; border-top-right-radius: 0; margin-right: 1px" onclick="otkljucajKorisnika(${kat['idKorisnik']});">Otključaj</button>`);
                $('#sviKorisniciBlok').append(`<button class="button button-send" style="border-bottom-left-radius: 0; border-top-left-radius: 0;" onclick="zakljucajKorisnika(${kat['idKorisnik']});">Zaključaj</button>`);
                $('#sviKorisniciBlok').append('</tr>');

            }
        }
    });
}

function otkljucajKorisnika(id) {
     $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `UPDATE Korisnik SET blokiran = 0 WHERE idKorisnik = '${id}'`
        },
        success: function (data) {
            if (data !== "[]") {
                ucitajPopisKorisnika();
            }
            else
                alert("Greška");
        }
    });
}

function zakljucajKorisnika(id) {
    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `UPDATE Korisnik SET blokiran = 1 WHERE idKorisnik = '${id}'`
        },
        success: function (data) {
            if (data !== "[]") {
                ucitajPopisKorisnika();
            }
            else
                alert("Greška");
        }
    });
}


function ucitajDnevnikPrijava(str = 1) {

    var ukupniBroj;
    $.ajax({
        async: false,
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `SELECT COUNT(*) FROM dnevnikPrijava JOIN Korisnik
                      ON Korisnik.idKorisnik = dnevnikPrijava.Korisnik_idKorisnik`
        },
        success: function (data) {
            ukupniBroj = JSON.parse(data)["COUNT(*)"];

        }
    });


    var sql = `SELECT dnevnikPrijava.iddnevnik_prijava, dnevnikPrijava.prijavljen, dnevnikPrijava.vrijemePrijave, Korisnik.korisnicko_ime  FROM dnevnikPrijava
               JOIN Korisnik
               ON Korisnik.idKorisnik = dnevnikPrijava.Korisnik_idKorisnik
               LIMIT ${brojRedova} OFFSET ${(str - 1) * brojRedova}`;

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': sql
        },
        success: function (data) {

            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#strDnevnikPrijava').html("");

            var brojStranica = 1;
            if (parseInt(ukupniBroj) > parseInt(brojRedova)) brojStranica = Math.ceil(ukupniBroj / brojRedova);

            if (brojStranica > 1) {

                $('#strDnevnikPrijava').append(`<button class="button" onclick="ucitajDnevnikPrijava(1)">Prva</button>`);
                $('#strDnevnikPrijava').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikPrijava(${str - 1 >= 1 ? str - 1 : 1})">Prethodna</button>`);

                for (var i = 0; i < brojStranica; i++)
                    $('#strDnevnikPrijava').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikPrijava(${i + 1})">${i + 1}</button>`);

                $('#strDnevnikPrijava').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikPrijava(${str + 1 <= brojStranica ? str + 1 : brojStranica})">Sljedeća</a>`);
                $('#strDnevnikPrijava').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikPrijava(${brojStranica})">Zadnja</button>`);
            }

            $('#dnevnikPrijava').html("");
            for (var zapis of json) {

                $('#dnevnikPrijava').append('<tr>');
                $('#dnevnikPrijava').append('<td>' + zapis['iddnevnik_prijava'] + '</td>');
                $('#dnevnikPrijava').append('<td>' + (zapis['prijavljen'] == 1 ? 'Da' : 'Ne')+ '</td>');
                $('#dnevnikPrijava').append('<td>' + zapis['vrijemePrijave'] + '</td>');
                $('#dnevnikPrijava').append('<td>' + zapis['korisnicko_ime'] + '</td>');
                $('#dnevnikPrijava').append('</tr>');

            }
        }
    });
}

function ucitajDnevnikRada(str = 1) {
    var ukupniBroj;
    $.ajax({
        async: false,
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `SELECT COUNT(*) FROM dnevnikRada JOIN Korisnik
                      ON Korisnik.idKorisnik = dnevnikRada.Korisnik_idKorisnik`
        },
        success: function (data) {
            ukupniBroj = JSON.parse(data)["COUNT(*)"];

        }
    });

    var sql = `SELECT dnevnikRada.iddnevnik_rada, dnevnikRada.vrijeme, dnevnikRada.radnja, Korisnik.korisnicko_ime
               FROM dnevnikRada
               JOIN Korisnik
               ON Korisnik.idKorisnik = dnevnikRada.Korisnik_idKorisnik
               LIMIT ${brojRedova} OFFSET ${(str - 1) * brojRedova}`;

    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': sql
        },
        success: function (data) {

            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#strDnevnikRada').html("");

            var brojStranica = 1;
            if (parseInt(ukupniBroj) > parseInt(brojRedova)) brojStranica = Math.ceil(ukupniBroj / brojRedova);

            if (brojStranica > 1) {

                $('#strDnevnikRada').append(`<button class="button" onclick="ucitajDnevnikRada(1)">Prva</button>`);
                $('#strDnevnikRada').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikRada(${str - 1 >= 1 ? str - 1 : 1})">Prethodna</button>`);

                for (var i = 0; i < brojStranica; i++)
                    $('#strDnevnikRada').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikRada(${i + 1})">${i + 1}</button>`);

                $('#strDnevnikRada').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikRada(${str + 1 <= brojStranica ? str + 1 : brojStranica})">Sljedeća</a>`);
                $('#strDnevnikRada').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikRada(${brojStranica})">Zadnja</button>`);
            }

            $('#dnevnikRada').html("");
            for (var zapis of json) {

                $('#dnevnikRada').append('<tr>');
                $('#dnevnikRada').append('<td>' + zapis['iddnevnik_rada'] + '</td>');
                $('#dnevnikRada').append('<td>' + zapis['radnja'] + '</td>');
                $('#dnevnikRada').append('<td>' + zapis['vrijeme'] + '</td>');
                $('#dnevnikRada').append('<td>' + zapis['korisnicko_ime'] + '</td>');
                $('#dnevnikRada').append('</tr>');

            }
        }
    });
}

function ucitajDnevnikBaze(str = 1) {
    var ukupniBroj;
    $.ajax({
        async: false,
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': `SELECT COUNT(*) FROM dnevnikBaze JOIN Korisnik
                      ON Korisnik.idKorisnik = dnevnikBaze.Korisnik_idKorisnik`
        },
        success: function (data) {
            ukupniBroj = JSON.parse(data)["COUNT(*)"];

        }
    });


    var sql = `SELECT dnevnikBaze.iddnevnikBaze, dnevnikBaze.upit, Korisnik.korisnicko_ime
               FROM dnevnikBaze
               JOIN Korisnik
               ON Korisnik.idKorisnik = dnevnikBaze.Korisnik_idKorisnik
               LIMIT ${brojRedova} OFFSET ${(str - 1) * brojRedova}`;



    $.ajax({
        url: 'database/getJson.php',
        datatype: 'json',
        method: 'POST',
        data: {
            'query': sql
        },
        success: function (data) {

            var json = JSON.parse(data);
            if(json.length === undefined){
                json = new Array(json);
            }

            $('#strDnevnikBaze').html("");

            var brojStranica = 1;
            if (parseInt(ukupniBroj) > parseInt(brojRedova)) brojStranica = Math.ceil(ukupniBroj / brojRedova);

            if (brojStranica > 1) {
                $('#strDnevnikBaze').append(`<button class="button" onclick="ucitajDnevnikBaze(1)">Prva</button>`);
                $('#strDnevnikBaze').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikBaze(${str - 1 >= 1 ? str - 1 : 1})">Prethodna</button>`);

                for (var i = 0; i < brojStranica; i++)
                    $('#strDnevnikBaze').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikBaze(${i + 1})">${i + 1}</button>`);

                $('#strDnevnikBaze').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikBaze(${str + 1 <= brojStranica ? str + 1 : brojStranica})">Sljedeća</a>`);
                $('#strDnevnikBaze').append(`<button class="button" style="margin: 0 5px" onclick="ucitajDnevnikBaze(${brojStranica})">Zadnja</button>`);
            }

            $('#dnevnikBaze').html("");
            for (var zapis of json) {

                $('#dnevnikBaze').append('<tr>');
                $('#dnevnikBaze').append('<td>' + zapis['iddnevnikBaze'] + '</td>');
                $('#dnevnikBaze').append('<td>' + zapis['upit'] + '</td>');
                $('#dnevnikBaze').append('<td>' + zapis['korisnicko_ime'] + '</td>');
                $('#dnevnikBaze').append('</tr>');

            }
        }
    });
}