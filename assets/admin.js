/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/scss/admin/style.scss';

//import './bootstrap';

// wait app load
// document.addEventListener('DOMContentLoaded', function() {
//     const cityInputList = document.getElementsByClassName('field-auto-complete');
//
//     console.info('cityInputList', cityInputList);
//
//     for (let i = 0; i < cityInputList.length; i++) {
//         // On auto complete cityInput fetch city by zip code
//         const select = cityInputList[i].getElementsByClassName('ts-dropdown-content')[0];
//         cityInputList[i].getElementsByTagName('input')[1].addEventListener('keyup', (event) => {
//             const zipCode = event.target.value;
//
//             if (zipCode.length < 3) return;
//
//             // fetch api on https://vicopo.selfbuild.fr/cherche/{zipCode}
//             fetch('https://vicopo.selfbuild.fr/cherche/' + zipCode)
//                 .then(response => response.json())
//                 .then(data => {
//                     // add autocomplete to select
//                     select.innerHTML = '';
//
//                     for (let i = 0; i < data.cities.length; i++) {
//                         const option = document.createElement('div');
//                         option.dataset.selectable = "";
//                         option.dataset.value = data.cities[i].code;
//                         option.classList.add('option');
//                         option.id = 'Property_category-opt-' + i;
//                         option.innerHTML = data.cities[i].city + ' (' + data.cities[i].code + ')';
//                         select.appendChild(option);
//                     }
//
//                     console.log(data.cities);
//                 });
//
//
//
//             console.log(zipCode);
//         });
//     }
// });
