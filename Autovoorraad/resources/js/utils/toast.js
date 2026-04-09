export const toast = {
    success(message, duration = 5000) {
        queueMicrotask(() => {
            Alpine.store('toast')?.show(message, 'success', duration)
        })
    },

    error(message, duration = 7000) {
        Alpine.store('toast').show(message, 'error', duration)
    },

    info(message, duration = 5000) {
        Alpine.store('toast').show(message, 'info', duration)
    },

    warning(message, duration = 6000) {
        Alpine.store('toast').show(message, 'warning', duration)
    }
}