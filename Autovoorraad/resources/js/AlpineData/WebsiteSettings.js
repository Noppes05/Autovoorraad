import { toast } from "../utils/toast";

export function websiteSettings(user='') {
    return {
        naam: '',
        logo:  '',
        kleur: '#000000',
        herofoto:  '',
        hero_beschrijving:  '',
        telefoonnummer:  '',
        email:  '',
        plaats:  '',
        adres:  '',
        postcode: '',
        isSaved: false,
        isSaving: false,
        save_loading:false,
        async init() {
            if (!user) {
                console.error('User ID is required to fetch website settings.');
                toast.error('Kon gebruiker Id niet vinden. Website instellingen kunnen niet worden geladen.');
                return;
            }
            console.log('Fetching website settings for user ID:', user);
            try {
                const response = await fetch(`/api/website-settings?user_id=${encodeURIComponent(user)}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'x-xsrf-token': this.getCookie('XSRF-TOKEN'),
                    },
                });
                if (!response.ok) {
                    throw new Error('Failed to fetch website settings');
                }
                const data = await response.json();
                const settings = data.settings || {};
                this.naam = settings.naam || '';
                this.logo = settings.logo || '';
                this.kleur = settings.kleur || '#000000';
                this.herofoto = settings.herofoto || '';
                this.hero_beschrijving = settings.hero_beschrijving || '';
                this.telefoonnummer = settings.telefoonnummer || '';
                this.email = settings.Email || '';
                this.plaats = settings.plaats || '';
                this.adres = settings.adres || '';
                this.postcode = settings.postcode || '';
            } catch (error) {
                console.error('Error fetching website settings:', error);
                toast.error('Fout bij het ophalen van website instellingen');
            }

        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find((row) => row.startsWith(name + '='))
                ?.split('=')[1];
        },
        async updateSettings() {
            const csrf = await fetch('/sanctum/csrf-cookie', {
                method: 'GET',
                credentials: 'include',
            });
            if (!csrf.ok) {
                throw new Error('Failed to get CSRF token');
            }
            var formData = new FormData();
            formData.append('naam', this.naam);
            formData.append('logo', this.logo);
            formData.append('kleur', this.kleur);
            formData.append('herofoto', this.herofoto);
            formData.append('hero_beschrijving', this.hero_beschrijving);
            formData.append('telefoonnummer', this.telefoonnummer);
            formData.append('email', this.email);
            formData.append('plaats', this.plaats);
            formData.append('adres', this.adres);
            formData.append('postcode', this.postcode);
            
            try {
                const response = await fetch(`/api/website-settings`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'x-xsrf-token': this.getCookie('XSRF-TOKEN'),
                    },
                    body: formData,
                });
                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'Failed to update website settings');
                }
                toast.success('Website instellingen zijn succesvol bijgewerkt');
            } catch (error) {
                console.error('Fout bij bijwerken website instellingen:', error);
                const message = error instanceof Error ? error.message : 'Failed to update website settings';
                toast.error(message);
            }
        }
    }
}