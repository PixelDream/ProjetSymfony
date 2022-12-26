import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    cityInputList = [];

    initialize() {
        this.cityInputList = document.getElementsByClassName('field-auto-complete');

    }

    connect() {

        for (let i = 0; i < this.cityInputList.length; i++) {
            // On auto complete cityInput fetch city by zip code
            console.info('field', this.cityInputList[0].getElementsByTagName('input'));
            const select = this.cityInputList[i].getElementsByClassName('ts-dropdown-content')[0];
            const el = this.cityInputList[i].getElementsByTagName('input')[1];

            console.info('el', el);
            console.info('select', select);

            el.addEventListener('keyup', (event) => {
                const city = event.target.value;

                if (city.length < 3) return;

                console.log(city);

                // // fetch api on https://vicopo.selfbuild.fr/cherche/{zipCode}
                fetch('https://vicopo.selfbuild.fr/cherche/' + zipCode)
                    .then(response => response.json())
                    .then(data => {
                        // add autocomplete to select
                        select.innerHTML = '';

                        for (let i = 0; i < data.cities.length; i++) {
                            const option = document.createElement('div');
                            option.dataset.selectable = "";
                            option.dataset.value = data.cities[i].code;
                            option.classList.add('option');
                            option.id = 'Property_category-opt-' + i;
                            option.innerHTML = data.cities[i].city + ' (' + data.cities[i].code + ')';
                            select.appendChild(option);
                        }

                        console.log(data.cities);
                    });


                console.log(city);
            });
        }

    }
}