<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Registro</title>
<!--<link rel="stylesheet" href="paginaLogin.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
    .registro{
        margin: 100px 450px;
    }
   .presentacion{
        margin-top: 50px;
    }
    </style>
</head>
<body class="bg-info">
<div class="container-fluid text-center">
    <header>
        <div class="row justify-content-around position-relative bg-info">
                <img src="logo.png" />
        </div>
        </header>
<?php
session_start();
    
    //Recoge los datos del campo del formulario y a partir de ahi los añade a la base de datos.
    
if(isset($_POST['registrarse']))
{
	session_destroy();
	session_start();
	$conexion = mysqli_connect( "localhost","root","" ) or die ("No se ha podido conectar al servidor de Base de datos");
	$db = mysqli_select_db( $conexion, "Enfermedades" ) or die ("No se ha podido conectar con la base de datos");
	$consulta="Select * from usuarios where USUARIO='".$_POST['USUARIO']."'";
	$resultado = mysqli_query( $conexion, $consulta );
	$columna = mysqli_fetch_array($resultado);
	if($columna!=0)
	{
		print "El Usuario ya existe";
		header("Refresh:3; url=registro.php");
	}
	else
	{
		$insertar="INSERT INTO `usuarios`(`NOMBRE`, `APELLIDOS`, `EDAD`, `EMAIL`, `PASSWORD`, `USUARIO`, `NACIONALIDAD`) VALUES ('".$_POST['NOMBRE']."','".$_POST['APELLIDOS']."',".$_POST['EDAD'].",'".$_POST['EMAIL']."','".$_POST['PASSWORD']."','".$_POST['USUARIO']."','".$_POST['NACIONALIDAD']."')";
		if(mysqli_query($conexion,$insertar))
		{
			print"Se Registro Correctamente";
			header("Refresh:3; url=paginaPrincipal.php");
		}
		else
		{
			print"Fallo al registro";
			header("Refresh:3; url=registro.php");
            mysql_close($conexion);
		}
	}
}
else
{
?>
<div class="presentacion">
    <div>
        <p>Bienvenido, parar poder interaccionar con nuestro ChatBot para que le diagnostique la enfermedad que está sufriendo, por favor debe registrarse en nuestra página.<br/>
        Desde nuestro equipo de desarrollo le deseamos una grata experiencia con nuestra web.   </p>
    </div>
    <div class="registro">
        <form class="form-group" action='registro.php' method='post'>
            <table class="usuario">
            <tr><td>Nombre</td><td><input class="form-control" type='text' name='NOMBRE' required></td></tr>
            <tr><td>Apellidos</td><td><input class="form-control" type='text' name='APELLIDOS' required></td></tr>
            <tr><td>Edad</td><td><input  class="form-control" type='number' name='EDAD' required></td></tr>
            <tr><td>Email</td><td><input class="form-control" type='text' name='EMAIL' required></td></tr>
            <tr><td>Password</td><td><input class="form-control" type='password' name='PASSWORD' required></td></tr>
            <tr><td>Usuario</td><td><input class="form-control" type='text' name='USUARIO' required></td></tr>
            <tr><td>Nacionalidad</td><td><input class="form-control" type='text' name='NACIONALIDAD' required></td></tr>
                <tr><td><input class="form-control" type='submit' name='registrarse' value='registrarse'></td><td><a class="nav-link text-white" href="paginaPrincipal.php">Volver a la Pagina Principal</a></td></tr>
            </table>
        </form>
    </div>    
</div>    
<?php

}
?>

    <footer class="bg-info text-center text-white">
    <p>&copy; La página tiene nuestro copyright</p>
    </footer> 
</div>
</body>
</html>