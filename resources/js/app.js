import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone',{
    dictDefaultMessage: 'Sube aqui tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar Archivo',
    maxFiles: 1,
    uploadMultiple: false
});

dropzone.on('sending',function(file,xhr,formData){ //sending para enviar el archivo
    console.log(formData);
})

dropzone.on('success', function (file, response) { //para obtener la respuesta
    console.log(response);
})

dropzone.on('error', function (file, message) { //para obtener la respuesta
    console.log(message);
})

dropzone.on('removedfile', function () { //cuando se elimina la imagen
    console.log('Archivo eliminado');
})