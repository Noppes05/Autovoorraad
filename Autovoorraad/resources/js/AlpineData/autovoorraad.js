export function autovoorraad() {
    return {
        autos: [],
        async init() {
            try {
                const csrf_token = await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });
                const response = await fetch('/api/autos', {
                    method: 'GET',
                    credentials: 'include',
                });
                if (!response.ok) {
                    throw new Error("Netwerkfout bij het ophalen van auto's");
                }
                const data = await response.json();
                console.log("Autos opgehaald:", data);
                this.autos = data;
            } catch (error) {
                console.error("Fout bij het ophalen van auto's, error");
            }
        }
    }
}