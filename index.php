<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // abrir la coneccion a la base de datos
        $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
        $conexion = new PDO('mysql:host=localhost; dbname=practicagit', 'root', '1234', $pdo_options);

        if(isset($_POST["accion"])){
            // echo "Quieres " . $_POST["accion"];
            if($_POST["accion"] == "Crear"){
                $insert = $conexion->prepare("INSERT INTO Alumno (Carnet, Nombre, dpi, direccion) VALUES (:Carnet,:Nombre,:dpi,:direccion)");
                $insert->bindValue('Carnet', $_POST['Carnet']);
                $insert->bindValue('Nombre', $_POST['Nombre']);
                $insert->bindValue('dpi', $_POST['dpi']);
                $insert->bindValue('direccion', $_POST['direccion']);
                $insert->execute();
            }
            if($_POST["accion"] == "Editado"){
                $UPDATE = $conexion->prepare("UPDATE Alumno SET Nombre=:Nombre,dpi=:dpi,direccion=:direccion  WHERE Carnet=:Carnet");
                $UPDATE->bindValue('Carnet', $_POST['Carnet']);
                $UPDATE->bindValue('Nombre', $_POST['Nombre']);
                $UPDATE->bindValue('dpi', $_POST['dpi']);
                $UPDATE->bindValue('direccion', $_POST['direccion']);
                $UPDATE->execute();
                header("Refresh: 0");
            }
        }


        // ejecutamos la consulta
        $select = $conexion->query("SELECT Carnet, Nombre, dpi, direccion FROM Alumno");

    ?>


    <?php if (isset($_POST["accion"]) && $_POST["accion"] == "Editar") { ?>
    <form method="POST">
        <input type="text" name="Carnet" value="<?php echo $_POST["Carnet"]?>" placeholder="Ingrese el carnet"/>
        <input type="text" name="Nombre" placeholder="Ingrese el Nombre"/>
        <input type="text" name="dpi" placeholder="Ingrese el DPI"/>
        <input type="text" name="direccion" placeholder="Ingrese su dirrecion"/>
        <input type="hidden" name="accion" value="Editado"/>
        <button type="submit">Guardar</button>
    </form>

    <?php } else {?>
        <form method="POST">
        <input type="text" name="Carnet" placeholder="Ingrese el carnet"/>
        <input type="text" name="Nombre" placeholder="Ingrese el Nombre"/>
        <input type="text" name="dpi" placeholder="Ingrese el DPI"/>
        <input type="text" name="direccion" placeholder="Ingrese su dirrecion"/>
        <input type="hidden" name="accion" value="Crear"/>
        <button type="submit">Crear</button>
    </form>
    <?php }?>
    <table border="1">
        <thead>
            <tr>
                <th>Carnet</th>
                <th>Nombre</th>
                <th>DPI</th>
                <th>Direccion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($select->fetchAll() as $Alumno) {?>
            <tr>
                <td><?php echo $Alumno["Carnet"] ?></td>
                <td><?php echo $Alumno["Nombre"] ?></td>
                <td><?php echo $Alumno["dpi"] ?></td>
                <td><?php echo $Alumno["direccion"] ?></td>
                <td>
                    <form method="POST">
                        <button type="submit">Editar</button> 
                        <input type="hidden" name="accion" value="Editar"/>
                        <input type="hidden" name="Carnet" value="<?php echo $Alumno["Carnet"] ?>"/>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
<!-- http://localhost/practica_git/ -->
</html>