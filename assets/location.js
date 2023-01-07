import $ from 'jquery';
import autocomplete from 'autocomplete.js';

$(function ()
{
    $.getJSON("https://api-adresse.data.gouv.fr/search/?type=municipality&q=" + value, function (data) {
        $("#autocomplete").autocomplete({
            source: data,
            select: function (event, ui) {
                window.location.href = ui;
            }
        });
    }
});
