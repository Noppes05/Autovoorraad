export function publicHomePage(id) {
    return {
        
        cars: [],
        init(){
            this.fetchCars();
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
        async fetchCars() {
            try {
                const response = await fetch(`/Autos?user_id=${id}`,{
                    method: 'GET',
                    
                });
                if (!response.ok) {
                    throw new Error('Failed to fetch cars');
                }
                const data = await response.json();
                console.log('Fetched cars:', data);
                this.cars = data.autos || [];
            } catch (error) {
                console.error('Error fetching cars:', error);
            }
        }
    }
}