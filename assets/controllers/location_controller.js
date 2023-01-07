import {Controller} from '@hotwired/stimulus';
import $ from 'jquery';
import autocomplete from 'autocomplete.js';
/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['input'];

    static values = {placeholder: String, searchable: Boolean};

    $(function()){
    /*$.getJSON("https://api-adresse.data.gouv.fr/search/?type=municipality&q=" + value, function(data) {
        $("#autocomplete").autocomplete({
            source: data,
            select: function(event, ui) {
                window.location.href = ui;
            }
        });*/
}


                /* for (let i = 0; i < data.features.length; i++) {
                     const option = document.createElement('option');
                     option.val = data.features[i].properties.city;
                     option.innerHTML = data.features[i].properties.city + ' (' + data.features[i].properties.postcode + ')';
                     this.inputTarget.appendChild(option);
                     this.inputTarget.value = data.features[i].properties.city;
                 }*/


}
