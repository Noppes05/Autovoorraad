import { toast } from "../utils/toast";

export function photoManager(initialFotos = []) {
    return {
        fotos: [],
        draggedIndex: null,
        overIndex: null,

        init() {
            this.fotos = initialFotos.map(f => ({
                file: null,
                preview: f.url ?? f,
                existing: true,
                id: f.id ?? null
            }))
        },

        addFoto(event) {
            const files = event.target.files

            if (!files.length) return

            for (let file of files) {
                this.fotos.push(file)
            }

            this.emit()
            toast.success(`${files.length} foto(s) toegevoegd`)
        },

        deletePicture(index) {
            this.fotos.splice(index, 1)
            this.emit()
        },

        startDrag(index) {
            this.draggedIndex = index
        },

        dragOver(index) {
            this.overIndex = index
        },

        drop(index) {
            const item = this.fotos.splice(this.draggedIndex, 1)[0]
            this.fotos.splice(index, 0, item)
            this.reset()
            this.emit()
        },

        endDrag() {
            this.reset()
        },

        reset() {
            this.draggedIndex = null
            this.overIndex = null
        },

        emit() {
            this.$dispatch('photos-updated', this.fotos)
        }
    }
}