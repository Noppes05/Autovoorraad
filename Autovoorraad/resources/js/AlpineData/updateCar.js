import { toast } from "../utils/toast";

export function updateCar(initialAuto = {}, initialFotos = []) {
    return {
        autoId: initialAuto.id,
        kenteken: initialAuto.kenteken ?? '',
        merk: initialAuto.merk ?? '',
        model: initialAuto.model ?? '',
        bouwjaar: initialAuto.bouwjaar ?? '',
        km_stand: initialAuto.km_stand ?? '',
        prijs: initialAuto.prijs ?? '',
        beschrijving: initialAuto.beschrijving ?? '',
        auto_status: initialAuto.status ?? 'beschikbaar',
        fotos: Array.isArray(initialFotos) ? initialFotos : [],
        status: 'basisinformatie',
        isSaved: false,
        isSaving: false,
        init() {
            console.log('Auto data loaded for editing:', initialAuto);
            console.log('Initial photos loaded for editing:', initialFotos);
        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find((row) => row.startsWith(name + '='))
                ?.split('=')[1];
        },
        updateFotos(fotos) {
            this.fotos = fotos;
        },
        resolveFotoSrc(foto) {
            if (foto instanceof File) {
                return URL.createObjectURL(foto);
            }

            return foto?.url ?? foto?.preview ?? '';
        },
        async convertToFile(foto, index) {
            if (foto instanceof File) {
                return foto;
            }

            const url = foto?.url ?? foto?.preview ?? (typeof foto === 'string' ? foto : null);
            if (!url) {
                return null;
            }

            const response = await fetch(url, { credentials: 'include' });
            if (!response.ok) {
                throw new Error('Bestaande foto kon niet geladen worden voor opslaan.');
            }

            const blob = await response.blob();
            const extension = blob.type.split('/')[1] || 'jpg';
            return new File([blob], `update-${index}.${extension}`, { type: blob.type || 'image/jpeg' });
        },
        async saveUpdate() {
            this.isSaving = true;
            this.isSaved = false;

            const formData = new FormData();
            formData.append('kenteken', this.kenteken);
            formData.append('merk', this.merk);
            formData.append('model', this.model);
            formData.append('bouwjaar', this.bouwjaar);
            formData.append('km_stand', this.km_stand ?? '');
            formData.append('prijs', this.prijs ?? '');
            formData.append('beschrijving', this.beschrijving ?? '');
            formData.append('status', this.auto_status);
            formData.append('replace_fotos', '1');

            try {
                const files = await Promise.all(this.fotos.map((foto, index) => this.convertToFile(foto, index)));
                files.filter(Boolean).forEach((file) => {
                    formData.append('fotos[]', file);
                });

                const response = await fetch(`/api/autos/${this.autoId}/update`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-XSRF-TOKEN': decodeURIComponent(this.getCookie('XSRF-TOKEN') ?? ''),
                        accept: 'application/json',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.message || 'Bijwerken mislukt.');
                }

                this.isSaved = true;
                toast.success('Auto succesvol bijgewerkt.');
                window.location.href = `/auto/${this.autoId}`;
            } catch (error) {
                toast.error(error instanceof Error ? error.message : 'Bijwerken mislukt.');
            } finally {
                this.isSaving = false;
            }
        },
    };
}