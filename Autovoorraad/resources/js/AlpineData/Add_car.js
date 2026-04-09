export function add_car() {
    return {
        kenteken: '',
        merk: '',
        model: '',
        bouwjaar: '',
        km_stand: '',
        prijs:'',
        beschrijving: '',
        fotos: [],
        rdwData_error:'',
        status:'basisinformatie',
        addeditem: null,
        draggedIndex: null,
        overIndex: null,
        fileInput: null,
        csrf_token: null,
        isPublished: false,
        rdwData_loading: false,
        isConceptSaved: false,
        async init() {
            this.csrf_token = await fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });
        },
       handleKentekenInput() {
           this.kenteken = this.kenteken.replace(/\s/g, '').toUpperCase().replace('-','');
           this.kenteken = this.kenteken.replace(/[^A-Z0-9-]/g, '');
           console.log('Kenteken ingevoerd:', this.kenteken);
            if (this.kenteken.trim() === '') {
            console.warn('Kenteken is leeg. Geen gegevens op te halen.');
            return;
            }
            if(this.kenteken.length < 6 || this.kenteken.length > 10) {
                console.warn('Ongeldig kenteken formaat. Controleer de invoer.');
                return;
            }
            this.rdwData_loading = true;
            fetch(`/api/rdw/kenteken`, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                   'accept': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(this.getCookie('XSRF-TOKEN'))
                },
                body: JSON.stringify({ kenteken: this.kenteken })}
                )
                .then(response => response.json())
                .then(data => {
                    console.log(data['data']);
                    if (data['data'] !=undefined) {
                        console.log('RDW Data gevonden:', data['data']);
                        this.merk = data['data']["merk"];
                        this.model = data['data']["model"];
                        this.bouwjaar = data['data']["bouwjaar"];
                        if(data['data']["kilometer_stand"] != null){
                            this.km_stand = data['data']["kilometer_stand"];
                        }
                        this.rdwData_error = '';
                        this.rdwData_loading = false;
                    }else{
                        this.rdwData_error = 'Geen gegevens gevonden voor dit kenteken. Controleer de invoer.';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } ,
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find(row => row.startsWith(name + '='))
                ?.split('=')[1];
    },
        // Drag and Drop functies
        startDrag(index) {
            this.draggedIndex = index;
        },

        dragOver(index) {
            this.overIndex = index;
        },

        drop(index) {
            const movedItem = this.fotos[this.draggedIndex];

            // verwijder item
            this.fotos.splice(this.draggedIndex, 1);

            // voeg opnieuw in op nieuwe plek
            this.fotos.splice(index, 0, movedItem);

            this.reset();
        },

        endDrag() {
            this.reset();
        },
        reset() {
            this.draggedIndex = null;
            this.overIndex = null;
        },
        deletePicture(index) {
            this.fotos.splice(index, 1);
        },
        OpenFotoKiezen(){
            const fileinput = document.getElementById('fileinput');
            fileinput.click();
        },
        AddFoto(event){
            const files = event.target.files;
            // Controleer of er bestanden zijn geselecteerd
            if (files === 0) {
                console.warn('Geen bestanden geselecteerd.');
                return;
            }   
            //toevoegen van de geselecteerde foto's aan de foto array en deze weergeven in de interface
            for (let i = 0; i < files.length; i++) {
                console.log('Bestand toegevoegd:', fileinput.files[i].name);
                const file = fileinput.files[i];
                this.fotos.push(file)
                console.log('Huidige foto', this.fotos);
            }
        },
        async submitConceptCar() {
            await this.submitCar('/api/AddConceptcar');
            this.isConceptSaved = true;
        },
        async submitBeschikbaarCar() {
            await this.submitCar('/api/Addcar');
              this.isPublished = true;
        },

        async submitCar(url) {
            console.log(this.fotos);
            const formdata = new FormData();
            formdata.append('kenteken', this.kenteken);
            formdata.append('merk', this.merk);
            formdata.append('model', this.model);
            formdata.append('bouwjaar', this.bouwjaar);
            formdata.append('km_stand', this.km_stand);
            formdata.append('prijs', this.prijs);
            formdata.append('beschrijving', this.beschrijving);
            this.fotos.forEach((foto, index) => {
                formdata.append(`fotos[${index}]`, foto);
            });
            
            console.log('Te verzenden gegevens:', formdata);
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'X-XSRF-TOKEN': decodeURIComponent(this.getCookie('XSRF-TOKEN'))
                        },
                        body: formdata,
                    },
                        
                    );
                    if (!response.ok) {
                        throw new Error(`Netwerkfout: ${response.statusText}`);
                    }
                    const data = await response.json();
                    console.log('Response van server:', data);
        }
        catch (error) { 
                       console.error('Fout bij verzenden:', error);
        }
    }
    }
}