(function(){
    const btnRegistrar = document.querySelector("#crearCategoria")

    if(btnRegistrar){
        btnRegistrar.addEventListener('click', (e) =>{
            e.preventDefault()
            procesarDatos('new')
        })
    }

    function procesarDatos(acccion){
        const nombre = document.querySelector('#nombre')
        const estado = document.querySelector('#estado')

        if(!nombre.value || !estado.value){
            Swal.fire('Error', "Debe completar todos los datos", 'error')
            return
        }

        Swal.fire('Procesando', "Los datos se están procesando", 'success')
    }
})()