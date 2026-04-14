export function fotoSlider() {
    return {
        open: false,
        main: null,
        thumbnails: null,
        openHandler: null,
        closeTimer: null,
        init() {
            this.openHandler = () => {
                if (this.closeTimer) {
                    clearTimeout(this.closeTimer);
                    this.closeTimer = null;
                }

                this.open = true;
                this.$nextTick(() => this.mountSlider());
            };

            window.addEventListener('open-image-slider', this.openHandler);
        },
        close() {
            this.open = false;

            if (this.closeTimer) {
                clearTimeout(this.closeTimer);
            }

            // Wait for leave transition before destroying Splide instances.
            this.closeTimer = setTimeout(() => {
                this.destroySlider();
                this.closeTimer = null;
            }, 220);
        },
        mountSlider() {
            this.destroySlider();

            this.main = new Splide(this.$refs.main, {
                type       : 'fade',
                rewind     : true,
                pagination : false,
                arrows     : false,
            });
            this.thumbnails = new Splide(this.$refs.thumbnails, {
                rewind          : true,
                fixedWidth      : 104,
                fixedHeight     : 58,
                isNavigation    : true,
                gap             : 10,
                focus           : 'center',
                pagination      : false,
                dragMinThreshold: {
                    mouse: 4,
                    touch: 10,
                },
                breakpoints : {
                    640: {
                        fixedWidth: 64,
                        fixedHeight: 44,
                    },
                },
                }
            );
            this.main.sync(this.thumbnails);
            this.main.mount();
            this.thumbnails.mount();
        },
        destroySlider() {
            this.main?.destroy(true);
            this.thumbnails?.destroy(true);
            this.main = null;
            this.thumbnails = null;
        },
        destroy() {
            if (this.closeTimer) {
                clearTimeout(this.closeTimer);
                this.closeTimer = null;
            }

            if (this.openHandler) {
                window.removeEventListener('open-image-slider', this.openHandler);
            }
        },
    };
}
