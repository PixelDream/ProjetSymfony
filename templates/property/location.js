import $ from 'jquery';
import autocomplete from 'autocomplete.js';

$(function ()
{


    $.getJSON("https://api-adresse.data.gouv.fr/search/?type=municipality&q=" + $('#value').val(), function (data) {
        $("#value").autocomplete({
            minLength: 3,
            source: data,
            select: function (event, ui) {
                var city = ui.features;
            }
        });
    });
});

$( document ).ready(function() {
    console.log( "ready!" );
});
