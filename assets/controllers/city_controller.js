import { Controller } from '@hotwired/stimulus';
import NiceSelect from "nice-select2/dist/js/nice-select2";

export default class extends Controller {

    static targets = ['select'];

    static values = { placeholder: String, searchable: Boolean };

    niceSelector = null;

    connect() {
        this.loadNiceSelect();

        const input = this.element.getElementsByTagName('input')[0];

        input.addEventListener('keyup', (event) => {
            event.preventDefault();

            const list = this.element.getElementsByTagName('ul')[0];
            const value = input.value;

            if (value.length < 3) return;

            fetch('https://vicopo.selfbuild.fr/cherche/' + value)
                .then(response => response.json())
                .then(data => {
                    // add autocomplete to select
                    list.innerHTML = '';
                    this.selectTarget.innerHTML = '';

                    for (let i = 0; i < data.cities.length; i++) {
                        const option = document.createElement('option');
                        option.value = data.cities[i].city;
                        option.innerHTML = data.cities[i].city + ' (' + data.cities[i].code + ')';
                        this.selectTarget.appendChild(option);


                        const li = document.createElement('li');
                        li.value = data.cities[i].city;
                        li.classList.add('option');
                        li.classList.add('null');
                        li.innerHTML = data.cities[i].city + ' (' + data.cities[i].code + ')';
                        list.appendChild(li);
                    }
                }).then(() => {
                    this.niceSelector.update();
                    input.value = value;
            });
        });
    }

    loadNiceSelect() {
        this.niceSelector = new NiceSelect(this.selectTarget, {placeholder: this.placeholderValue, searchable: this.searchableValue});
    }
}