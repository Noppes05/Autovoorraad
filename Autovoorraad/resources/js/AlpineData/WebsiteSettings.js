import { toast } from "../utils/toast";

export function websiteSettings(initialSettings = {}) {
    return {
        naam: initialSettings.naam,
        logo: initialSettings.logo ?? '',
        kleur: initialSettings.kleur ?? '',
        herofoto: initialSettings.herofoto ?? '',
        hero_beschrijving: initialSettings.hero_beschrijving ?? '',
        telfoonnummer: initialSettings.telfoonnummer ?? '',
        Email: initialSettings.Email ?? '',
        plaats: initialSettings.plaats ?? '',
        adres: initialSettings.adres ?? '',
        postcode: initialSettings.postcode ??'',
        isSaved: false,
        isSaving: false,
        save_loading:false,
        init() {
            console.log('Auto data loaded for editing:', initialSettings);
        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find((row) => row.startsWith(name + '='))
                ?.split('=')[1];
        },
    }
}