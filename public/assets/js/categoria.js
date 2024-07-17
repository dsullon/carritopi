(function(){
    const btnRegistrar = document.querySelector("#crearCategoria")

    if(btnRegistrar){
        btnRegistrar.addEventListener('click', (e) =>{
            e.preventDefault()
            procesarDatos('new')
        })
    }

    async function procesarDatos(accion){
        const nombre = document.querySelector('#nombre')
        const estado = document.querySelector('#estado')

        if(!nombre.value || !estado.value){
            Swal.fire('Error', "Debe completar todos los datos", 'error')
            return
        }

        const url = '/api/categorias'
        Swal.fire({
            title: "Procesando datos",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })


        const data = new FormData();
        data.append("nombre", nombre.value)
        data.append("estado", estado.value)
        data.append("accion", accion)
        try {
            const respuesta = await fetch(url, {
                method: "POST",
                body: data
            })
            const resultado = await respuesta.json()
            if(resultado.estado){
                Swal.fire({
                    title: resultado.mensaje,
                    icon: 'success',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 1000,
                    showConfirmButton: false
                }).then((result) => {
                    window.location = '/admin/categorias'
                })
            }
        } catch (error) {
            Swal.fire("Error", "Ocurrió un error al intentar procesar los datos")
        }
    }
})()