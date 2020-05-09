<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Página Principal</title>
<!--<link rel="stylesheet" href="paginaLogin.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
    li{
        list-style: none;
    }
    .enfermedades
    {
        border:1px double gray;
        margin:auto;
    }
    .chatbot{
        margin-left: 520px;
        width:300px;
        height:400px;
        border:1px solid black;
    }
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
    <?php
    $visitas;
    session_start();
    
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
    
    //Realiza la conexión a la base de datos, además de las comprobaciones sobre el usuario y la contraseña para poder iniciar sesión.
    
    if(isset($_POST['entrar']))
    {
        session_destroy();
        session_start();
        $conexion = mysqli_connect( "localhost","root","" ) or die ("No se ha podido conectar al servidor de Base de datos");
        $db = mysqli_select_db( $conexion, "Enfermedades" ) or die ("No se ha podido conectar con la base de datos");
        $consulta="Select * from usuarios where USUARIO='".$_POST['USUARIO']."'";
        $resultado = mysqli_query( $conexion, $consulta );
        $columna = mysqli_fetch_array($resultado);
        if($columna==0)
        {
            print "Usuario No Encontrado";
            header("Refresh:3; url=paginaprincipal.php");
        }
        else
        {
            if($columna['PASSWORD']==$_POST['PASSWORD'])
            {
                print "Ha iniciado sesion correctamente";
                $_SESSION['usuario']=$_POST['USUARIO'];
                header("Refresh:3; url=paginaprincipal.php");
            }
            else
            {
                print "Password Erronea";
                header("Refresh:0; url=paginaprincipal.php");
                mysql_close($conexion);
            }
        }
    }
    
    //Cuando le das al botón de cerrar sesión te redirige a la página principal.
    
    else if(isset($_POST['cerrar']))
    {
            session_destroy();
            print    "Se ha cerrado sesion correctamente";
            header("Refresh:3; url=paginaprincipal.php");
           // mysql_close($conexion);
    }
    
    //En caso de que tengas una sesión abierta te mostrará la página del chatbots y el resto de las opciones de la página.
    
    else if (isset($_SESSION['usuario']))
    {
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
        <article >
            <h1 class="bg-info rounded text-white ">CHATBOT</h1>
            <div  class=" chatbot" ></div>
        </article>

    <?php
    }
    
    //Te mostrará la pequeña descripción y el formulario de inicio de sesión, también un enlace a otra página de registro.
    
    else
    {
    
    print "<img  src='logo.png'' /><br/> Necesita Iniciar Sesion o Registrarse para poder acceder a nuestra pagina";
    ?>
        
    <div class="presentacion">
        <div>
                <p>Bienvenido a nuetra página de diagnosis de enfermedades, nuestro equipo de desarrollo lo que quiere con este proyexto es no saturar tanto los hospitales, ambulatorios o centros de salud.<br/>
                Desde nuestro equipo de desarrollo le deseamos una grata experiencia con nuestra web.   </p>
        </div>
        <div class="registro row-2">
            <form  class="form-group" action='paginaprincipal.php' method='post'>
                <table>
                <tr><td>Usuario</td><td><input class="form-control"     type='text' name='USUARIO' required></td></tr>
                <tr><td>Password</td><td><input class="form-control" type='password' name='PASSWORD' required></td></tr>
                <tr><td><input class="form-control" type='submit' name='entrar' value='login'></td><td><a class="nav-link text-white" href="registro.php">Ir a la pagina de registro</a></td></tr>
                </table>
            </form>
        </div>
       
    </div>
    <?php
    print $mensaje;
    }
    
    ?>
    <footer class="bg-info text-center text-white">
    <p>&copy; La página tiene nuestro copyright</p>
    </footer> 
</div>
</body>
</html>