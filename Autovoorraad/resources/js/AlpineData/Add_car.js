import { toast } from "../utils/toast";

export function add_car() {
    return {
        kenteken: '',
        merk: '',
        model: '',
        bouwjaar: '',
        km_stand: '',
        prijs: '',
        beschrijving: '',
        fotos: [], // 👈 blijft!
        status: 'basisinformatie',
        isConceptSaved: false,
        isPublished: false,
        rdwData_error:'',
        rdwData_loading:false,

        async init() {
            await fetch('/sanctum/csrf-cookie', {
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

        updateFotos(fotos) {
            this.fotos = fotos
        },
        async submitConceptCar() {
            try{
                const response = await this.submitCar('/api/AddConceptcar');
                console.log('Response status:', response);
                    if(response === 201){
                        this.isConceptSaved = true;
                        toast.success('Concept auto succesvol opgeslagen');
                    } 
                    else {
                        this.isConceptSaved = false;
                        toast.error('Fout bij het opslaan van de concept auto');
                        }
                    }
                catch (error) {
                    console.error('Fout bij opslaan concept auto:', error);
                }
                    
        },
        getCookie(name) {
            return document.cookie
                .split('; ')
                .find(row => row.startsWith(name + '='))
                ?.split('=')[1];
        },
        async submitBeschikbaarCar() {
            try{
                const response = await this.submitCar('/api/Addcar');
                if(response === 201){
                    toast.success('Auto succesvol gepubliceerd');
                    this.isPublished = true;
                } else {
                    toast.error('Fout bij het publiceren van de auto');
                    this.isPublished = false;
                if (!response.ok) {
                    toast.error('Fout bij opslaan')
                    return
                }
            }
        }
            catch (error) {
                console.error('Fout bij publiceren auto:', error);
            }
        },
        async submitCar(url) {
            const formdata = new FormData()
            formdata.append('kenteken', this.kenteken)
            formdata.append('merk', this.merk)
            formdata.append('model', this.model)
            formdata.append('bouwjaar', this.bouwjaar)
            formdata.append('km_stand', this.km_stand)
            formdata.append('prijs', this.prijs)
            formdata.append('beschrijving', this.beschrijving)
            console.log('fotos', this.fotos);
            this.fotos.forEach((foto, index) => {
                formdata.append(`fotos[${index}]`, foto);
            });

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-XSRF-TOKEN': decodeURIComponent(this.getCookie('XSRF-TOKEN'))
                    },
                    body: formdata
                })

                if (!response.ok) {
                    return response.status;
                }
                return response.status;

            } catch (e) {
                toast.error('Server fout')
            }
        }
    }
}