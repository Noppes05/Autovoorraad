export const toastsetting = () => ({
    toasts: [],

    show(message, type = 'info', duration = 5000) {
        const id = Date.now() + Math.random()

        this.toasts.push({
            id,
            message,
            type,
            visible: true
        })

        setTimeout(() => this.hide(id), duration - 500)
        setTimeout(() => this.remove(id), duration)
    },

    hide(id) {
        const toast = this.toasts.find(t => t.id === id)
        if (toast) toast.visible = false
    },

    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id)
    }
})