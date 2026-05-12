export function publicCarDetail(tenantId,carPublicId) {
    return {
        car: null,
        loading: true,
        splideInstance: null,
        proefritForm: {
            naam: '',
            email: '',
            telefoonnummer: '',
            datumtijd: '',
            bericht: ''
        },
        formSubmitting: false,
        formMessage: '',

        init() {
            console.log('Initializing Alpine component with tenantId:', tenantId, 'and carPublicId:', carPublicId);
            this.fetchCarDetail();
            this.$watch('car', () => {
                this.$nextTick(() => {
                    if (this.car && this.car.fotos && this.car.fotos.length > 0) {
                        this.initSplide();
                    }
                });
            });
        },

        async fetchCarDetail() {
            try {
                const response = await fetch(`/AutoDetail?public_id=${carPublicId}`, {
                    method: 'GET',
                });
                if (!response.ok) {
                    throw new Error('Failed to fetch car details');
                }
                const data = await response.json();
                this.car = data.auto;
            } catch (error) {
                console.error('Error fetching car details:', error);
            } finally {
                this.loading = false;
            }
        },

        initSplide() {
            

            this.$nextTick(() => {
                const mainElement = document.getElementById('main-carousel');
                const thumbElement = document.getElementById('thumb-carousel');

                if (!mainElement || !thumbElement) {
                    setTimeout(() => this.initSplide(), 100);
                    return;
                }

                const mainSplide = new Splide(mainElement, {
                    type: 'fade',
                    rewind: true,
                    pagination: false,
                    arrows: true,
                });

                const thumbsSplide = new Splide(thumbElement, {
                    type: 'slide',
                    rewind: true,
                    perPage: 4,
                    gap: 8,
                    pagination: false,
                    isNavigation: true,
                    focus: 'center',
                    breakpoints: {
                        640: {
                            perPage: 3,
                        },
                    },
                });

                mainSplide.sync(thumbsSplide);
                mainSplide.mount();
                thumbsSplide.mount();

                this.splideInstance = mainSplide;
            });
        },

        formatPrice(value) {
            if (value === null || value === undefined || value === '') {
                return 'N/A';
            }
            const formattedValue = Math.round(Number(value)).toLocaleString('en-US', {
                maximumFractionDigits: 0,
            });
            return `€${formattedValue}`;
        },

        async submitProefrit() {
            this.formSubmitting = true;
            this.formMessage = '';

            try {
                // Add your API endpoint for submitting test drive requests here
                // const response = await fetch('/ProefritRequest', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                //     },
                //     body: JSON.stringify({
                //         car_id: this.car.id,
                //         ...this.proefritForm
                //     })
                // });

                // if (!response.ok) {
                //     throw new Error('Failed to submit request');
                // }

                this.formMessage = 'Proefrit request submitted!';
                this.resetProefritForm();
            } catch (error) {
                console.error('Error submitting proefrit:', error);
                this.formMessage = 'Error submitting request. Please try again.';
            } finally {
                this.formSubmitting = false;
            }
        },

        resetProefritForm() {
            this.proefritForm = {
                naam: '',
                email: '',
                telefoonnummer: '',
                datumtijd: '',
                bericht: ''
            };
        }
    };
}
