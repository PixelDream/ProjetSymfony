import {Controller} from '@hotwired/stimulus';
import NiceSelect from "nice-select2/dist/js/nice-select2";

export default class extends Controller {

    static targets = ['input'];

    static values = {placeholder: String, searchable: Boolean};

    niceSelector = null;

  connect() {
        this.loadNiceSelect();

        const span = this.element.getElementsByTagName('span')[0];
        const inputSearch = this.element.getElementsByTagName('input')[1];

        if (this.inputTarget.value) span.innerHTML = this.inputTarget.value;

        inputSearch.addEventListener('keyup', (event) => {
            event.preventDefault();

            const list = this.element.getElementsByTagName('ul')[0];
            const value = inputSearch.value;

            if (value.length < 3) return;

            fetch('https://vicopo.selfbuild.fr/cherche/' + value)
                .then(response => response.json())
                .then(data => {
                    list.innerHTML = '';
                    this.inputTarget.value = '';

                    for (let i = 0; i < data.cities.length; i++) {
                        const option = document.createElement('option');
                        option.value = data.cities[i].city;
                        option.innerHTML = data.cities[i].city + ' (' + data.cities[i].code + ')';
                        this.inputTarget.appendChild(option);


                        this.inputTarget.value = data.cities[i].city;
                    }
                }).then(() => {
                this.niceSelector.update();
            });
        });
    }

    loadNiceSelect() {
        this.niceSelector = new NiceSelect(this.inputTarget, {
            placeholder: this.placeholderValue,
            searchable: this.searchableValue
        });
    }
}