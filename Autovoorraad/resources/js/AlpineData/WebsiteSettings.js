import { toast } from "../utils/toast";

export function websiteSettings(user='') {
    return {
        naam: '',
        logo:  null,
        kleur: '#000000',
        herofoto:  null,
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
                this.logo = settings.logo || null;
                this.kleur = settings.kleur || '#000000';
                this.herofoto = settings.herofoto || null;
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
        getImagePreview(image, fallback) {
            if (!image) {
                return fallback;
            }

            if (typeof image === 'string') {
                return image;
            }

            return URL.createObjectURL(image);
        },
        async updateSettings() {
            console.log(this.logo)
            const csrf = await fetch('/sanctum/csrf-cookie', {
                method: 'GET',
                credentials: 'include',
            });
            if (!csrf.ok) {
                throw new Error('Failed to get CSRF token');
            }
            var formData = new FormData();
            if (this.naam) {
                formData.append('naam', this.naam);
            } else{
                toast.error('Naam is verplicht');
                return;
            }
            if (this.email) {
                formData.append('email', this.email);
            } else {
                toast.error('Email is verplicht');
                return;
            }
            if (this.logo instanceof File) {
                formData.append('logo', this.logo);
            }
            formData.append('kleur', this.kleur);
            if (this.herofoto instanceof File) {
                formData.append('herofoto', this.herofoto);
            }
            formData.append('hero_beschrijving', this.hero_beschrijving);
            formData.append('telefoonnummer', this.telefoonnummer);
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
        },
        addlogo(event){
            const file = event.target.files[0];
            console.log(file)
            if (file) {
                this.logo = file;
            }
        },
        addHero(event) {
            const file = event.target.files[0];
            if (file) {
                this.herofoto = file;
            }
        }

        
    }
}