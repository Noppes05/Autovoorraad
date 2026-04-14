import { toast } from "../toast";

export const confirmDeleteStore = () => ({
    open: false,
    car: null,
    loading: false,

    show( car ) {
        this.car= car.car
        this.open = true
    },

    close() {
        this.open = false
        this.car = null
    },
    getCookie(name) {
            return document.cookie
                .split('; ')
                .find(row => row.startsWith(name + '='))
                ?.split('=')[1];
        },
    async confirm() {
        if (!this.car) return
        this.loading = true
        console.log(this.car)
        const car = this.car
        try {
            console.log(car)
            const response = await fetch(`/api/autos/delete/`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'accept': 'application/json',
                        'X-XSRF-TOKEN': decodeURIComponent(this.getCookie('XSRF-TOKEN')),
                    },
                    body: JSON.stringify({ car }),
                });
            console.log(response)
            if (!response.ok) {
                toast.error('Verwijderen mislukt')
                return
            }

            toast.success(`${this.car.merk} ${this.car.model} verwijderd`)
            
            window.dispatchEvent(new CustomEvent('item-deleted', {
                detail: { id: this.car.id }
            }))

            this.close()
            window.location.href = '/dashboard';

        } catch (e) {
            toast.error('Server fout')
        } finally {
            this.loading = false
        }
    }
})