import './bootstrap';
import Alpine from 'alpinejs';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { add_car } from './AlpineData/Add_car';

gsap.registerPlugin(ScrollTrigger);

window.Alpine = Alpine;

Alpine.data('add_car', add_car);
Alpine.start();


