import './bootstrap';
import { photoManager } from "./components/PhotoManager";
import { fotoSlider } from "./components/FotoSlider";
import Splide from '@splidejs/splide';
import { confirmDeleteStore } from "./utils/confirmDelete/confirmDelete";
import { confirmDelete } from './utils/confirmDeleteHelper'
import { toastsetting } from "./utils/toast/toastsetting";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { add_car } from './AlpineData/Add_car';
import { autoDetails } from './AlpineData/autoDetails';
import { manageAutoPhotos } from './AlpineData/manageAutoPhotos';
import { updateCar } from './AlpineData/updateCar';
import { autovoorraad } from './AlpineData/autovoorraad';
import Alpine from 'alpinejs';

gsap.registerPlugin(ScrollTrigger);

window.confirmDelete = confirmDelete;
window.Splide = Splide;

window.Alpine = Alpine;


document.addEventListener('alpine:init', () => {

    Alpine.store('confirmDelete', confirmDeleteStore());
    Alpine.store('toast', toastsetting()); 
    Alpine.data('autovoorraad', autovoorraad);
    Alpine.data('autoDetails', autoDetails);
    Alpine.data('manageAutoPhotos', manageAutoPhotos);
    Alpine.data('updateCar', updateCar);
    Alpine.data('photoManager', photoManager);
    Alpine.data('fotoSlider', fotoSlider);
    Alpine.data('add_car', add_car);
    console.log(Alpine.store('toast'));
});
Alpine.start();



