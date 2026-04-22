import Alpine from "alpinejs";
import { publicHomePage } from "./AlpineData/public_Home_page";
window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('publicHomePage', publicHomePage);
});
Alpine.start();