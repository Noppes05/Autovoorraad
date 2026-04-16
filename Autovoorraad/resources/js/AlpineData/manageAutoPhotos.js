import { toast } from "../utils/toast";

export function manageAutoPhotos(autoId, initialFotos = []) {
    return {
        autoId,
        fotos: Array.isArray(initialFotos) ? initialFotos : [],
        saving: false,
        init() {
            console.log('Initial photos:', this.fotos);
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
        goToDetails() {
            window.location.href = `/auto/${this.autoId}`;
        },
        async convertToFile(foto, fallbackIndex) {
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
            return new File([blob], `existing-${fallbackIndex}.${extension}`, { type: blob.type || 'image/jpeg' });
        },
        async saveFotos() {
            this.saving = true;

            const formData = new FormData();

            try {
                const files = await Promise.all(
                    this.fotos.map((foto, index) => this.convertToFile(foto, index))
                );

                files.filter(Boolean).forEach((file) => {
                    formData.append('fotos[]', file);
                });

                const response = await fetch(`/api/autos/${this.autoId}/fotos`, {
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
                    throw new Error(data.message || 'Opslaan van foto\'s is mislukt.');
                }

                toast.success('Foto\'s zijn opgeslagen.');
                this.goToDetails();
            } catch (error) {
                toast.error(error instanceof Error ? error.message : 'Opslaan van foto\'s is mislukt.');
            } finally {
                this.saving = false;
            }
        },
    };
}