<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Enfermedades Diagnosticadas</title>
<!--<link rel="stylesheet" href="paginaLogin.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body class="bg-info">
<div class="container-fluid text-center">
<?php
session_start();
if (isset($_SESSION['usuario']))
{    
    //Crea las cookies sobre las visitas y lleva la cuenta.
    
	if(isset($_COOKIE[ 'visitas' ])) 
	{

		setcookie( 'visitas', $_COOKIE[ 'visitas' ] + 1, time() + 3600 * 24 );
		$mensaje = 'Numero de visitas: '.$_COOKIE[ 'visitas' ];
	}
	else 
	{

		setcookie( 'visitas', 1, time() + 3600 * 24 );
		$mensaje = 'Bienvenido por primera vez a nuesta web';
	}
		$conexion = mysqli_connect( "localhost","root","" ) or die ("No se ha podido conectar al servidor de Base de datos");
		$db = mysqli_select_db( $conexion, "Enfermedades" ) or die ("No se ha podido conectar con la base de datos");
		$consulta="Select * from enfermedades where Usuario='".$_SESSION['usuario']."'";
		$resultado = mysqli_query( $conexion, $consulta );
		$columnas= mysqli_num_rows($resultado);
		
		//Realiza una búsqueda de las enfermedades que se le han diagnosticado al usuario conectado y se las muestra.
		
?>
<header>
        <div class="row justify-content-around position-relative bg-info">
            <div  class="row-2 ">
                <img  src="logo.png" />
            </div>
            <div class="row-8 navbar">
                <nav class="navbar navbar-expand-md text-white">
                    <ul class="nav nav-pills">
                        <li class="nav-item active"><a class="nav-link text-white" href="paginaPrincipal.php">Inicio</a></li>
                        <li class="nav-item"><a  class="nav-link text-white" href="enfermedadesComunes.php">Enfermedades comunes</a></li>
                        <li class="nav-item active"><a class="nav-link text-white" href="enfermedadesDiagnosticadas.php">Enfermedades diagnosticadas</a></li>
                    </ul>
                </nav>
            </div>
            <div class="row-2">
                <form action='paginaprincipal.php' method='post'>
                <table class="table">
                    <tr><td ><?php print"Bienvenido ".$_SESSION['usuario'];?></td></tr>
                    <tr><td><?php print $mensaje; ?></td></tr>
                    <tr><td><input type='submit' name='cerrar' value='cerrar'></td></tr>
                </table>
                </form>
            </div>
        </div>
        </header>
<?php
		
		print "<table  class='table table-striped table-bordered table-hover'";
		print"<tr><td>Nombre de la enfermedad</td>
			<td>Tasa de mortalidad</td>
			<td>Dias de Baja</td>";
		 for ($i=0;$i<$columnas;$i++)
		{
				$filas=mysqli_fetch_array($resultado); 
			print"<tr><td>".$filas['Nombre']."</td>
			<td>".$filas['Mortalidad']."</td>
			<td>".$filas['Baja']."</td>";
		
		
		}
	
		print"</table></center>";
	
	
mysqli_close($conexion);
}
else
{
	print "<h1>No tienes permiso para estar aqui</h1>";
}
?>
    <footer class="bg-info text-center text-white">
    <p>&copy; La página tiene nuestro copyright</p>
    </footer> 
</div>
</body>
</html>