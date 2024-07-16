<div class="dashboard-contenedor">
    <div class="dashboard-acciones">
        <a href="/admin/categorias">
            <i class="fa-solid fa-circle-arrow-left icono-sm"></i>
        </a>
    </div>
    <h1>Nueva Categoría</h1>
    <form class="formulario">
        <?php include __DIR__ . '/formulario.php'; ?>
        
        <input type="submit" value="Registrar" class="dashboard-boton" id="crearCategoria">
    </form>
</div>

<?php $script = '<script src="/assets/js/categoria.js"></script>' ?>