import { toast } from "../utils/toast";

const placeholderImage = 'https://placehold.net/600x400.png';

export function autoDetails(autoId = null) {
    return {
        autoId,
        auto: null,
        loading: true,
        error: '',
        statusUpdating: false,
        init() {
            this.loadAuto();
        },
        async loadAuto() {
            if (!this.autoId) {
                this.error = 'Geen auto-id gevonden in de URL.';
                this.loading = false;
                return;
            }

            try {
                const response = await fetch(`/api/autos/${this.autoId}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    if (response.status === 404) {
                        throw new Error('Auto niet gevonden.');
                    }

                    if (response.status === 403) {
                        throw new Error('Je hebt geen toegang tot deze auto.');
                    }

                    throw new Error('Auto kon niet geladen worden.');
                }

                this.auto = await response.json();
            } catch (error) {
                const message = error instanceof Error ? error.message : 'Auto kon niet geladen worden.';
                this.error = message;
                toast.error(message);
                console.error('Fout bij het ophalen van auto details', error);
            } finally {
                this.loading = false;
            }
        },
        photoUrl(photoPath) {
            if (!photoPath) {
                return placeholderImage;
            }

            if (photoPath.startsWith('http://') || photoPath.startsWith('https://')) {
                return photoPath;
            }

            return `/storage/${photoPath}`;
        },
        formatPrice(value) {
            if (value === null || value === undefined || value === '') {
                return 'N/A';
            }

            return `€ ${Number(value).toLocaleString('nl-NL', { maximumFractionDigits: 0 })}`;
        },
        formatNumber(value) {
            if (value === null || value === undefined || value === '') {
                return 'N/A';
            }

            return Number(value).toLocaleString('nl-NL');
        },
        get daysInStock() {
            if (!this.auto?.created_at) {
                return null;
            }

            const createdAt = new Date(this.auto.created_at);

            if (Number.isNaN(createdAt.getTime())) {
                return null;
            }

            return Math.max(0, Math.round((Date.now() - createdAt.getTime()) / (1000 * 60 * 60 * 24)));
        },
        statusClass(status) {
            const classes = {
                beschikbaar: 'before:bg-green-500',
                concept: 'before:bg-gray-500',
                verkocht: 'before:bg-red-600',
            };

            return classes[status] ?? 'before:bg-gray-300';
        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find((row) => row.startsWith(name + '='))
                ?.split('=')[1];
        },
        async updateStatus(newStatus) {
            if (!this.auto || this.statusUpdating || this.auto.status === newStatus) {
                return;
            }

            this.statusUpdating = true;

            const formData = new FormData();
            formData.append('kenteken', this.auto.kenteken ?? '');
            formData.append('merk', this.auto.merk ?? '');
            formData.append('model', this.auto.model ?? '');
            formData.append('bouwjaar', this.auto.bouwjaar ?? '');
            formData.append('km_stand', this.auto.km_stand ?? '');
            formData.append('prijs', this.auto.prijs ?? '');
            formData.append('beschrijving', this.auto.beschrijving ?? '');
            formData.append('status', newStatus);
            formData.append('replace_fotos', '0');

            try {
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
                    throw new Error(data.message || 'Status wijzigen mislukt.');
                }

                this.auto.status = newStatus;
                toast.success(newStatus === 'verkocht' ? 'Auto gemarkeerd als verkocht.' : 'Auto gemarkeerd als beschikbaar.');
            } catch (error) {
                const message = error instanceof Error ? error.message : 'Status wijzigen mislukt.';
                toast.error(message);
            } finally {
                this.statusUpdating = false;
            }
        },
        openPhotoGallery() {
            window.dispatchEvent(new CustomEvent('open-image-slider'));
        },
    };
}