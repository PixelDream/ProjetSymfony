import { Controller } from '@hotwired/stimulus';
import noUiSlider from 'nouislider';
import wNumb from 'wnumb';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['select', 'min', 'max'];

    static values = {
        min: Number,
        max: Number,
        suffix: String,
        step: Number
    }

    connect() {
        const minValue = Math.floor(parseInt(this.minValue, 10) / this.stepValue) * this.stepValue;
        const maxValue = Math.ceil(parseInt(this.maxValue, 10) / this.stepValue) * this.stepValue;

        console.log(minValue, maxValue);

        noUiSlider.create(this.selectTarget, {
            start: [
                this.minTarget.value || minValue,
                this.maxTarget.value || maxValue
            ],
            connect: true,
            step: this.stepValue ? this.stepValue : 1,
            tooltips: wNumb({
                thousand: ' ',
                decimals: 0,
                suffix: this.suffixValue ? ' ' + this.suffixValue : ''
            }),
            format: wNumb({
                decimals: 0,
            }),
            range: {
                'min': minValue,
                'max': maxValue
            }
        }).on('slide', (values , handle) => {
            if (handle) {
                this.maxTarget.value = Math.round(values[handle]);
            } else {
                this.minTarget.value = Math.round(values[handle]);
            }
        });
    }
}
