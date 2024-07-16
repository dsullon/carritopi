<div class="dashboard-contenedor">
    <div class="dashboard-acciones">
        <a href="/admin/categorias/crear" class="dashboard-boton">
            <i class="fa-solid fa-circle-plus"></i>
            Nueva categoría
        </a>
    </div>
    <?php if(!empty($categorias)): ?>
        <h1>Listado de categorías</h1>
        <table class="table">
            <thead>
                <th>Código</th>
                <th>Nombre</th>
            </thead>
            <tbody>
                <?php foreach($categorias as $categoria): ?>
                    <tr>
                        <td><?php echo $categoria->codigo ?></td>
                        <td><?php echo $categoria->nombre ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay categorías registradas</p>
    <?php endif; ?>
</div>