import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {

    dictDefaultMessage: "Sube aquí tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar archivo",
    maxFiles: 1,
    uploadMultiple: false,

    //esta funcion se ejecuta automaticamente cuando se inicia dropzone,osea la zona de las imagenes
    init: function () {

        if (document.querySelector('[name="imagen"]').value.trim()) {

            const imagenPublicada = {}
            //este es un valor que se requiere pero no es obligatorio un valor especifico
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            //opciones de dropzone
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            //clases de dropzone
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    },
})

//eventos con dropzone,hay varios,usaremos el sending porque estamos enviando archivos,y se le pasa un callback,tambien podemos usar el success,y otros mas.
// dropzone.on('sending',function(file,xhr,formData){

//     console.log(formData);
// })

dropzone.on('success', function (file, response) {

    document.querySelector('[name="imagen"]').value = response.imagen;
})

// dropzone.on('error', function (file, message) {

//     console.log(message);
// })


//funcion dropzone para borrar la imagen,en este caso lo que hacemos es resetear el input de la imagen
dropzone.on('removedfile', function () {

    document.querySelector('[name="imagen"]').value = " ";
})
