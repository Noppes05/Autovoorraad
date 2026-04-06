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
        status:'foto_toevoegen',
        addeditem: null,
        draggedIndex: null,
        overIndex: null,
        fileInput: null,
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
        fetch(`https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=${this.kenteken.toUpperCase()}`)
            .then(response => response.json())
            .then(data => {
                console.log(data.length);
                if (data.length > 0) {
                    console.log('RDW Data gevonden:', data[0]);
                    this.merk = data[0].merk;
                    this.model = data[0].handelsbenaming;
                    this.bouwjaar = data[0].datum_eerste_tenaamstelling_in_nederland.substring(0, 4);
                    this.rdwData_error = '';
                }else{
                    this.rdwData_error = 'Geen gegevens gevonden voor dit kenteken. Controleer de invoer.';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
      } ,

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
                this.fotos.push({
                    name: file.name,
                    url: URL.createObjectURL(file)
                })
                console.log('Huidige foto', this.fotos);
            }
        }
    }
}