export function autovoorraad() {
    return {
        autos: [],
        async init() {
            try{
                const csrf_token = await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include',
                });
                    if (!csrf_token.ok) {
                        throw new Error("Netwerkfout bij het verkrijgen van CSRF-token");
                    }
                await this.getCars();
            } 
            catch (error) {
                console.error("Fout bij het verkrijgen van CSRF-token", error);
            }
            
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
                console.error("Fout bij het ophalen van auto's, error");
            }
        },
        async deleteCar(car){
            try {
                const response = await fetch(`/api/autos/delete/`, {
                    method: 'DELETE',
                    credentials: 'include',
                    body: JSON.stringify({ car }),
                });
                if (!response.ok) {
                    throw new Error("Netwerkfout bij het verwijderen van de auto");
                }
                console.log(`Auto met ID ${id} succesvol verwijderd`);
                this.getCars();
            } catch (error) {   
                console.error(`Fout bij het verwijderen van de auto met ID ${id}`, error);
            }
        }
    }
}