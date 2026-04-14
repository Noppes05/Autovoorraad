import { toast } from "../utils/toast";

export function autovoorraad() {
    return {
        autos: [],
        async init() {
            try{
                await this.getCsrfToken();
                await this.getCars();
            } 
            catch (error) {
                console.error("Fout bij het verkrijgen van CSRF-token", error);
            }
            
        },
        async getCsrfToken() {
            try {
                const response = await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });
                if (!response.ok) {
                    throw new Error("Netwerkfout bij het verkrijgen van CSRF-token");
                }
                console.log("CSRF-token succesvol verkregen");
            } catch (error) {
                console.error("Fout bij het verkrijgen van CSRF-token", error);
            }
        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find(row => row.startsWith(name + '='))
                ?.split('=')[1];
        },
        async getCars(){
            try {
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
                toast.error("Fout bij het ophalen van auto's");
                console.error("Fout bij het ophalen van auto's, error");
            }
        },
        async Updatecar(car){
            window.location.href = `/auto/${car.id}/bewerken`;
        },
        async deleteCar(car){
            try {
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
                if (!response.ok) {
                    throw new Error("Netwerkfout bij het verwijderen van de auto");
                }
                toast.success("Auto succesvol verwijderd");
                this.getCars();
            } catch (error) {   
                toast.error("Fout bij het verwijderen van de auto");
                console.error(`Fout bij het verwijderen van de auto met ID ${car.id}`, error);
            }
        },
        openDetails(car){
            window.location.href = `/auto/${car.id}`;
        }
    }
}