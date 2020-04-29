<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style/style.css">
  <title>Mus Masturb & Henderson</title>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
  <main>
     <form action="acceso.php" method="post">
<?php
include( 'funciones.php' );

/*
function leerUsuarios()
{
   
    $usuarios = array();

    $usuarios[0]["id"] = 1;
    $usuarios[0]["nombre"] = "emi";
    $usuarios[0]["mano"] = true;
    
    $usuarios[1]["id"] = 2;
    $usuarios[1]["nombre"] = "fernando";
    $usuarios[1]["mano"] = false;
    
    $usuarios[2]["id"] = 3;
    $usuarios[2]["nombre"] = "juan";
    $usuarios[2]["mano"] = false;
    
    $usuarios[3]["id"] = 4;
    $usuarios[3]["nombre"] = "paco";
    $usuarios[3]["mano"] = false;

    return $usuarios;
}

function acceso($usuarios, $usuario)
{
    $conectado=false;
    foreach ($usuarios as $user) {
        if($user['nombre'] == $usuario)
        {
            $conectado[] =$user['nombre'];
            $conectado[] =$user['id'];
            $conectado[] =$user['mano'];
            $conectado[] =0;
            return $conectado;
        }
    }
    return false;
}

function compruebamano($usuarios,$usuario)
{
    return $usuarios[$usuario-1]['mano'];
}

function leerEstadoJuego()
{
    global $seed;
    global $posicion;
    global $acciones; 
    //lectura del archivo seed
    $contenidoFicheroSeed = file_get_contents("data/seed.txt");
    if($contenidoFicheroSeed) {
        $seed = intval($contenidoFicheroSeed);
    } else {
        $seed = 0;
    }
    //Lectura de datos acciones
    $acciones[] = file_get_contents("data/acciones1.txt");
    $acciones[] = file_get_contents("data/acciones2.txt");
    $acciones[] = file_get_contents("data/acciones3.txt");
    $acciones[] = file_get_contents("data/acciones4.txt");
    
    $posicion = 0;
}

function nuevoEstadoJuego($acc)
{
    global $seed;
    global $posicion;
    global $acciones;
    
    $seed = random_int(0, 256*256*256);
    $posicion = 0;
    $acciones = $acc;
    //escribe en seed
    file_put_contents("data/seed.txt", ''.$seed);
    for($i = 0 ; $i < 4 ; $i++) {
        file_put_contents("data/acciones".($i + 1).".txt", $acciones[$i]);
    }
}

function updateAccionesEstadoJuego($idUser)
{
    global $acciones;
    //escribe en el archivo acciones correspondiente
    file_put_contents("data/acciones".$idUser.".txt", $acciones[$idUser - 1]);
}

function usuarioConectado($idUser)
{
    global $acciones;
    
    if($idUser) {
        if(strlen($acciones[$idUser - 1]) > 0) { 
            $descriptor = substr($acciones[$idUser - 1], 0, 1);
            if($descriptor == '*') {
                return true;
            }
        }
    }
    
    return false;
}

function anadirAccionesEstadoJuego($idUser)
{
    global $posicion;
    global $acciones;
    
    $cambio = false;
    
    if($idUser) {
        if(usuarioConectado($idUser) == false) {
            if(strlen($acciones[$idUser - 1]) == 0) { 
                $acciones[$idUser - 1] = $acciones[$idUser - 1]."-";
            }
            $acciones[$idUser - 1] = substr_replace($acciones[$idUser - 1], '*' , 0, 1);
            $cambio = true;
        } else {
            $nuevaMano = isset($_POST['nuevaMano']);
            $bajarCartas = isset($_POST['bajarCartas']);
            $nuevaPartida = isset($_POST['nuevaPartida']);
            $nuevaPartidaInicial = isset($_POST['nuevaPartidaInicial']);
            $mus = isset($_POST['mus']);
            $nomus = isset($_POST['nomus']);

            if($bajarCartas) {
                if(strlen($acciones[$idUser - 1]) > 1) {
                    $acciones[$idUser - 1] = substr_replace($acciones[$idUser - 1], '?' , strlen($acciones[$idUser - 1]) - 1, 1);
                    $cambio = true;
                }
            } else if($nuevaMano) {
                if(strlen($acciones[$idUser - 1]) > 1) {
                    $acciones[$idUser - 1] = substr_replace($acciones[$idUser - 1], '$' , strlen($acciones[$idUser - 1]) - 1, 1);
                    $cambio = true;
                }
            }else if($nuevaPartidaInicial) {
                $acc = array();
                $acc[] = '';
                $acc[] = '';
                $acc[] = '';
                $acc[] = '';
                nuevoEstadoJuego($acc);
            } else if($nuevaPartida) {
                $acc = array();
                for($i = 0 ; $i < 4 ; $i++) {
                   $acc[$i] = substr($acciones[$i], 0, 1);
                }
                nuevoEstadoJuego($acc);
            } else if($mus || $nomus) {
                    if($nomus == true) {
                        $acciones[$idUser - 1] = $acciones[$idUser - 1]."*";
                        $cambio = true;
                    } else if($mus == true) {
                        $carta1Substituida = isset($_POST['carta-1']);
                        $carta2Substituida = isset($_POST['carta-2']);
                        $carta3Substituida = isset($_POST['carta-3']);
                        $carta4Substituida = isset($_POST['carta-4']);
                        if($carta1Substituida == true || $carta2Substituida == true ||
                            $carta3Substituida == true || $carta4Substituida == true) {
                            $descriptorAccion = getDescriptorAccion($carta1Substituida, $carta2Substituida,
                                $carta3Substituida, $carta4Substituida);
                            $acciones[$idUser - 1] = $acciones[$idUser - 1].$descriptorAccion;
                            $cambio = true;
                        }
                    }
            }
        }
    }

    if($cambio) {
        updateAccionesEstadoJuego($idUser);
    }
}

function getDescriptorAccion($carta1Substituida, $carta2Substituida,
            $carta3Substituida, $carta4Substituida) {
    $charindex = 0;
    
    if($carta1Substituida == true) {
        $charindex = $charindex + 8;
    }

    if($carta2Substituida == true) {
        $charindex = $charindex + 4;
    }
    
    if($carta3Substituida == true) {
        $charindex = $charindex + 2;
    }
    
    if($carta4Substituida == true) {
        $charindex = $charindex + 1;
    }
    
    if($charindex < 10) {
        $charcode = ord('0') + $charindex;
    } else {
        $charcode = ord('A') + $charindex - 10;
    }
    return chr($charcode);
}

function compruebaAccion($acciones, $accion) {
    $found = false;

        for($i = 0 ; $i < 4; $i++) {
            if(substr($acciones[$i], strlen($acciones[$i]) - 1, 1) == $accion) {
                $found = true;
                break;
            }
        }

    return $found;
}*/

if(isset($_POST['inputUsuario']))
{
    $seed = 0;
    $posicion = 0;
    $acciones = array();
    $acciones[] = '';
    $acciones[] = '';
    $acciones[] = '';
    $acciones[] = '';
    
    if ($_POST['inputUsuario'] !='')
    {

        $usuarios = leerUsuarios();
        $usuario = $_POST['inputUsuario'];

        $conectado = true;
        $conectado = acceso($usuarios, $usuario);
        echo '<div class="contenedor-botones-nueva-partida" class="primerPlano">';
        if(compruebamano($usuarios,$conectado[1]))
        {
            echo '<button type="submit" name="nuevaPartidaInicial">Nueva Partida</button>';
        } else {
            echo '<button type="submit" name="joinGame">Unirse a la Partida</button>';
        }
        echo '<input  type="hidden" name="usuario" value="'.$conectado[1].'">';
        echo '<input  type="hidden" name="iniciado" value="'.$conectado[3].'">';
        echo '</div>';
        echo 'Estas conectado '.$conectado[1].'<br>'; 
    }
}
elseif(isset($_POST['usuario']))
{
    $usuarios = leerUsuarios();
    leerEstadoJuego();
    anadirAccionesEstadoJuego($_POST['usuario']);
    
    if (file_exists( 'jugar.php' )) 
    {
        include( 'jugar.php' );
        echo '<br>';
    }
    else 
     echo 'Error al cargar el mòdulo <b>';
}
else{
    echo 'no estas conectado<br>';
    echo '<form action="index.php">';
    echo '<input type="Submit" value="Volver">';
    echo '</form>';
}

?>
    </form>
<!--Seed: <div id="seed"></div></br>
Posicion: <div id="posicion"></div>
Acciones: <div id="acciones"></div>-->
<div id="overlayDiv">
    <div class="overlay transparentOverlay"></div>
</div>

<div class="modal-content">
<div class="modal-header"></div>
<div class="modal-body">
    <p id="modal-text"></p>
</div>
<div class="modal-footer"></div>
</div>

  </main>
  <script type="text/javascript" src="script\scripts.js">
  </script>
  <script type="text/javascript">

    var seed; 
    var posicion;
    var acciones; 
    var textOverlay = '';
    var primerasDadas = true;
    var mano = 1;
    var tipoCarta = 1;
    var mostrarCartasOtros = false;
    var cards = new Array();
    var cardsLeft;
    var usuarios = new Array();
    var bloquear = false;
    
    $(document).ready(function(){
        $('#overlayDiv').hide();        
        leerDatos();
        setInterval(function(){
            if(bloquear) {
               leerDatos();
            }
        },3500);
    })
 
    //se necesita refresco hasta aqui
    function ajaxDatos(parametro)
	   {
           let promise = new Promise(function(resolve, reject)
           {
                $.ajax({
                // En data puedes utilizar un objeto JSON, un array o un query string
                        data: {"parametro" : parametro},
                        //Cambiar a type: POST si necesario
                        type: "GET",
                        // Formato de datos que se espera en la respuesta
                        dataType: "json",
                        // URL a la que se enviarÃ¡ la solicitud Ajax
                        url: "funciones.php",
                    })
                    .done(function( data) {
                        if(data.status == 'ok'){
                            let datos = [data.result.seed,data.result.posicion,data.result.acciones]
                            resolve(datos); 
                            //$('.user-content').slideDown();
                        }else{
                            //$('.user-content').slideUp();
                            alert("No se ha devuelto ningun dato...");
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( "La solicitud a fallado: " +  textStatus);
                            reject(textStatus);
                        }
                    });  
            });
            return promise;
        }

        function ajaxLeer(parametro, usuario)
        {
            let promise = new Promise(function(resolve, reject)
            {
                $.ajax({
                // En data puedes utilizar un objeto JSON, un array o un query string
                        data: {"parametro" : parametro, "usuario": usuario},
                        //Cambiar a type: POST si necesario
                        type: "GET",
                        // Formato de datos que se espera en la respuesta
                        dataType: "json",
                        // URL a la que se enviarÃ¡ la solicitud Ajax
                        url: "funciones.php",
                    })
                    .done(function( data) {
                        if(data.status == 'ok'){
                            $('#mano').html(data.result);
                            //let dato = new Array();
                            let dato = data.usuarios;
                            resolve(dato); 
                            //$('.user-content').slideDown();
                        }else{
                            //$('.user-content').slideUp();
                            alert("No se ha devuelto ningun dato...");
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( "La solicitud a fallado: " +  textStatus);
                            reject(textStatus);
                        }
                    });  
            });
            return promise;
        }



        function leerDatos(){
            ajaxDatos('leer').then(function (dato) {
            seed=dato[0];
            posicion =dato[1];
            acciones = dato[2];
            for(var i = 0 ; i < 40 ; i++) {
                cards[i] = false;
            }
            cardsLeft = 40;
            textOverlay = '';
            mostrarCartasOtros = false;
            bloquear = false;
            /*$('#seed').text(seed);
            $('#posicion').text(posicion);
            $('#acciones').text(acciones);*/
            //alert (dato[0]+"-"+dato[1]+"-"+idUsuario+"-"+usuarios);
            var idUsuario = <?php
                if(isset($_POST['usuario'])) {
                    echo $_POST['usuario'];
                } else {
                    echo 0;
                }
            ?>;

            <?php
                if(isset($_POST['usuario']))
                {
            ?>
                    ajaxLeer('usuarios', <?=$_POST['usuario'] ?>).then(function (datos) {
                        
                        //alert ('actualizacion ok');
                        usuarios = datos; 

                        //console.log(usuarios[1]+' dentro de la llamada ajax')
                        //alert(usuarios[0]['nombre']);
                        //alert (seed+"-"+acciones+"-"+idUsuario+"-"+usuarios[0]['nombre']);
                        checkState(seed, acciones, idUsuario, usuarios);
                        mostrarCartas(usuarios, primerasDadas, mano, tipoCarta, mostrarCartasOtros);
                        
                        $("#modal-text").text(textOverlay);
                        if(bloquear) {
                          console.log('show');
                          $('#overlayDiv').show();
                        } else{
                          console.log('hide');
                          $('#overlayDiv').hide();         
                        }
                    //setTimeout(dato,3500);
                    },function (err){
                        console.log(err);
                        alert (err);
                    }); 

            <?php
                } 
                else{
                    echo 'usuarios=['.llamarUsuarios($usuarios,0).'];';
                    //echo 'console.log(usuarios[1]);';
                    //echo 'alert (seed+"-"+acciones+"-"+idUsuario+"-"+usuarios[0][\'nombre\']);';
                    //echo 'checkState(seed, acciones, idUsuario, usuarios);';
                    echo 'mostrarCartas(usuarios, primerasDadas, mano, tipoCarta, mostrarCartasOtros);';
                }                
            ?>

            /*usuarios = [<?php  
            //llamarUsuarios($usuarios);
            ?>];*/
            
            },function (err){
                console.log(err);
                seed = 0;
                posicion = 0;
                acciones = ['','','',''];
            });
        }
   </script>
</body>
</html>
