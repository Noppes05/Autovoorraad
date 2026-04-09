import './bootstrap';
import { toastsetting } from "./utils/toast/toastsetting";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { add_car } from './AlpineData/Add_car';
import { autovoorraad } from './AlpineData/autovoorraad';
import Alpine from 'alpinejs';

gsap.registerPlugin(ScrollTrigger);

window.Alpine = Alpine;


document.addEventListener('alpine:init', () => {

   Alpine.store('toast', toastsetting()); 
    Alpine.data('autovoorraad', autovoorraad);
    Alpine.data('add_car', add_car);
    console.log(Alpine.store('toast'));
});
Alpine.start();



