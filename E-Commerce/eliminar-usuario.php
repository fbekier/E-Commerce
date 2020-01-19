<?php 
    require_once "share/header.php";
    require_once "clases/class.users.php";

    $id = $_GET['id'];
    
    $user = new Users();
    $user->getUsuarioById($id);

?>
    <div class="container">
        <h3> Está seguro que desea eliminar al usuario: <?php echo $user->nombre." ".$user->apellido?> </h3>
        <button type="button" class="btn btn-primary" onclick="eliminarUsuario($id)">Eliminar</button>
        <button type="button" class="btn btn-primary" onclick="usuarios.php">Cancelar</button>
    </div>
    

