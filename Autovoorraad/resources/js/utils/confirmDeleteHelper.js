export function confirmDelete(car) {
    Alpine.store('confirmDelete').show({ car })
}