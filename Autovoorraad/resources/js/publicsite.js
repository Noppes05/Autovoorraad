import Alpine from "alpinejs";
import Splide from '@splidejs/splide';
import { publicHomePage } from "./AlpineData/public_Home_page";
import { publicCarDetail } from "./AlpineData/public_car_detail";
window.Alpine = Alpine;
window.Splide = Splide;
document.addEventListener('alpine:init', () => {
    Alpine.data('publicHomePage', publicHomePage);
    Alpine.data('publicCarDetail', publicCarDetail);
});
Alpine.start();