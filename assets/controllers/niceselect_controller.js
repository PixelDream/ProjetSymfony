import {Controller} from '@hotwired/stimulus';
import NiceSelect from "nice-select2/dist/js/nice-select2";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = { placeholder: String, searchable: Boolean };

    connect() {
        new NiceSelect(this.element, {placeholder: this.placeholderValue, searchable: this.searchableValue});
    }
}
