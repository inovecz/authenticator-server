import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';
import './bg';
import './bootstrap';
import {delegate} from "tippy.js";
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'


Alpine.plugin(persist)
window.Alpine = Alpine
Alpine.start()

delegate('body', {
    theme: 'light',
    interactive: true,
    allowHTML: true,
    target: '[data-tippy-content]',
    delay: 50,
});
