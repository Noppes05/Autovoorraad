import { apply } from "@splidejs/splide/src/js/utils";

export function publicHomePage(id) {
    return {
        merken:[],
        allModels:[],
        cars: [],
        openDropdown: null,
        tempMinPrice: '',
        tempMaxPrice: '',
        filters: {
            brands: [],
            models: [],
            min_prijs: '',
            max_prijs: ''
        },
        init(){
            this.fetchCars();
            this.fetchMerken();
            this.$watch('filters.brands', () => this.clearModelsOnBrandChange(), { deep: true });
        },
        clearModelsOnBrandChange() {
            if (this.filters.brands.length === 0) {
                this.filters.models = [];
            }
        },
        get filteredCars() {
            return this.cars.filter(car => {
                const brandMatch = this.filters.brands.length === 0 || this.filters.brands.includes(car.merk);
                const modelMatch = this.filters.models.length === 0 || this.filters.models.includes(car.model);
                const minPrice = this.filters.min_prijs ? parseInt(this.filters.min_prijs) : 0;
                const maxPrice = this.filters.max_prijs ? parseInt(this.filters.max_prijs) : Infinity;
                const priceMatch = car.prijs >= minPrice && car.prijs <= maxPrice;

                return brandMatch && modelMatch && priceMatch;
            });
        },
        get availableModels() {
            if (this.filters.brands.length === 0) {
                return [];
            }
            const modelsSet = new Set(
                this.cars
                    .filter(car => this.filters.brands.includes(car.merk))
                    .map(car => car.model)
            );
            return Array.from(modelsSet).sort();
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
                this.fetchMerken();
            } catch (error) {
                console.error('Error fetching cars:', error);
            }
        },
        fetchMerken() {
            try {
                const merkenSet = new Set(this.cars.map(car => car.merk));
                this.merken = Array.from(merkenSet).sort();
            } catch (error) {
                console.error('Error fetching merken:', error);
            }
        },
        toggleBrand(brand) {
            const index = this.filters.brands.indexOf(brand);
            if (index > -1) {
                this.filters.brands.splice(index, 1);
                this.filters.models = [];
            } else {
                this.filters.brands.push(brand);
            }
        },
        toggleModel(model) {
            const index = this.filters.models.indexOf(model);
            if (index > -1) {
                this.filters.models.splice(index, 1);
            } else {
                this.filters.models.push(model);
            }
        },
        isBrandSelected(brand) {
            return this.filters.brands.includes(brand);
        },
        isModelSelected(model) {
            return this.filters.models.includes(model);
        },
        carMatchesFilter(car) {
            const brandMatch = this.filters.brands.length === 0 || this.filters.brands.includes(car.merk);
            const modelMatch = this.filters.models.length === 0 || this.filters.models.includes(car.model);
            const minPrice = this.filters.min_prijs ? parseInt(this.filters.min_prijs) : 0;
            const maxPrice = this.filters.max_prijs ? parseInt(this.filters.max_prijs) : Infinity;
            const priceMatch = car.prijs >= minPrice && car.prijs <= maxPrice;

            return brandMatch && modelMatch && priceMatch;
        },
        toggleDropdown(dropdown) {
            this.openDropdown = this.openDropdown === dropdown ? null : dropdown;
        },
        closeDropdown() {
            this.openDropdown = null;
        },
        onPriceBlur(type) {
            if (type === 'min') {
                this.filters.min_prijs = this.tempMinPrice;
            } else if (type === 'max') {
                this.filters.max_prijs = this.tempMaxPrice;
            }
        },
        applyFilter() {
            console.log('Filters applied:', this.filters);
        }
    }
}