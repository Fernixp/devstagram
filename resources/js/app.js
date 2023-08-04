import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aqui tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false,

//funcion para rescatar la imagen por si hay algun error de validacion en el formulario tienen algun error
    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim()) { //en caso de que haya algo, va seleccionar la imagen y va llenar los atributos de dropzone
            const imagenPublicada = {}
            imagenPublicada.size = 1234; //asignamos tamaño
            imagenPublicada.name = document.querySelector('[name="imagen"]').value; //asignamos nombre

            this.options.addedfile.call(this, imagenPublicada);  //cuande se inicie la funcion se manda a llamar
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`)

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');

        }
    }
});


dropzone.on('success', function (file, response) { //para obtener la respuesta
    console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen; //pasamos la respuesta al input hidden imagen
});


dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = ""; //si se elimina el archivo en el formulario, cambiamos el valor del imput hidden
});