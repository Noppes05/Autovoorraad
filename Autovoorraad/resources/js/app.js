import './bootstrap';
import { photoManager } from "./components/PhotoManager";
import { confirmDeleteStore } from "./utils/confirmDelete/confirmDelete";
import { confirmDelete } from './utils/confirmDeleteHelper'
import { toastsetting } from "./utils/toast/toastsetting";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { add_car } from './AlpineData/Add_car';
import { autoDetails } from './AlpineData/autoDetails';
import { autovoorraad } from './AlpineData/autovoorraad';
import Alpine from 'alpinejs';

gsap.registerPlugin(ScrollTrigger);

window.confirmDelete = confirmDelete;

window.Alpine = Alpine;


document.addEventListener('alpine:init', () => {

    Alpine.store('confirmDelete', confirmDeleteStore());
    Alpine.store('toast', toastsetting()); 
    Alpine.data('autovoorraad', autovoorraad);
    Alpine.data('autoDetails', autoDetails);
    Alpine.data('photoManager', photoManager);
    Alpine.data('add_car', add_car);
    console.log(Alpine.store('toast'));
});
Alpine.start();



