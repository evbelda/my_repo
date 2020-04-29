<?php

//nuevas
if (isset($_GET['parametro']))
{
    if($_GET['parametro'] == 'seed')
    {
        leerSeed();
    }
    elseif($_GET['parametro'] == 'posicion')
    {
        leerPosicion();
    }
    elseif($_GET['parametro'] == 'leer')
    {
        leerDatos();
    }
    elseif($_GET['parametro'] == 'usuarios')
    {
        actualizarTodo();
    }
    else{
        leerAcciones();
    }
}

function leerDatos()
{
    $seed=0;
    $data = Array();
    $acciones = Array();

    $contenidoFicheroSeed = file_get_contents("data/seed.txt");
    $acciones[] = file_get_contents("data/acciones1.txt");
    $acciones[] = file_get_contents("data/acciones2.txt");
    $acciones[] = file_get_contents("data/acciones3.txt");
    $acciones[] = file_get_contents("data/acciones4.txt");
    if($contenidoFicheroSeed && $acciones) {
        $seed = intval($contenidoFicheroSeed);
        $data['status'] = 'ok';
        $data['result']['seed'] = $seed;
        $data['result']['posicion'] = 0;
        $data['result']['acciones'] = $acciones;
    } else {
        $data['status'] = 'err';
        $data['result'] = 0;
    }

    echo json_encode($data);      
}

function actualizarTodo()
{
    global $acciones; 
    $cadena = '';
    $usuarios = leerUsuarios();
    leerEstadoJuego();
    
    //hay que enviar el usuario por ajacx
    anadirAccionesEstadoJuego($_GET['usuario']);
    $data['status'] = 'ok';
    

    if(compruebamano($usuarios,$_GET['usuario']))
    {
       $devolverUsu=llamarUsuarios($usuarios,1);
       //echo '<script>alert("dentro de llamarUsuarios1")</script>';
       if(compruebaAccion($acciones, '?')) {  
           $cadena = '<div class="primerPlano"><button type="submit" name="nuevaMano">Nueva Mano</button></div>';
       } else if(compruebaAccion($acciones, '*')) {  
           $cadena = '<div class="primerPlano"><button type="submit" name="bajarCartas">Bajar Cartas</button></div>';
       }
       $cadena = $cadena.'<div class="primerPlano"><button type="submit" name="nuevaPartida">Nueva Partida</button></div>';
       $data['result'] = $cadena;
    }
    else{
        $devolverUsu=llamarUsuarios($usuarios,1);
    }
    
    $data['usuarios'] = $devolverUsu;
    echo json_encode($data); 
}


function leerSeed()
{
    $seed=0;
    $data = Array();
    $contenidoFicheroSeed = file_get_contents("data/seed.txt");
    if($contenidoFicheroSeed) {
        $seed = intval($contenidoFicheroSeed);
        $data['status'] = 'ok';
        $data['result'] = $seed;
    } else {
        $data['status'] = 'err';
        $data['result'] = 0;
    }
    echo json_encode($data);
}

function leerPosicion()
{
    $data = Array();
    $data['status'] = 'ok';
    $data['result'] = 0;
    echo json_encode($data);
    
}

function leerAcciones()
{
    global $acciones;
    $acciones = Array();
    $acciones[] = file_get_contents("data/acciones1.txt");
    $acciones[] = file_get_contents("data/acciones2.txt");
    $acciones[] = file_get_contents("data/acciones3.txt");
    $acciones[] = file_get_contents("data/acciones4.txt");
}

function llamarUsuarios($usuarios, $tipo)
{
    if($usuarios) {
        $devuelve = array();
        $i=0;
        $arrayUsuariosStr ='';
        foreach ($usuarios as $user) {
            if(strlen($arrayUsuariosStr) > 0) {
                $arrayUsuariosStr = $arrayUsuariosStr.",";
            }
            $arrayUsuariosStr = $arrayUsuariosStr."{'id':".$user['id'].",'nombre':'".$user['nombre']."','mano':";
            $devuelve[$i]['id'] = $user['id'];
            $devuelve[$i]['nombre'] = $user['nombre'];    
            if($user['mano']) {
               $arrayUsuariosStr = $arrayUsuariosStr."true,"; 
               $devuelve[$i]['mano'] = true;
            } else {
                $arrayUsuariosStr = $arrayUsuariosStr."false,";
                $devuelve[$i]['mano'] = false;
            }
            
            $arrayUsuariosStr = $arrayUsuariosStr."'conectado':";
            
            if(usuarioConectado($user['id'])) {
                $arrayUsuariosStr = $arrayUsuariosStr."true"; 
                $devuelve[$i]['conectado'] = true;
            } else {
                $arrayUsuariosStr = $arrayUsuariosStr."false";
                $devuelve[$i]['conectado'] = false;
            }
            $arrayUsuariosStr = $arrayUsuariosStr.",'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''}";
            $devuelve[$i]['team'] = 0;
            $devuelve[$i]['cartas'][] = ['id'=>-1,'seleccionada'=>false,'cambiada'=>false];
            $devuelve[$i]['cartas'][] = ['id'=>-1,'seleccionada'=>false,'cambiada'=>false];
            $devuelve[$i]['cartas'][] = ['id'=>-1,'seleccionada'=>false,'cambiada'=>false];
            $devuelve[$i]['cartas'][] = ['id'=>-1,'seleccionada'=>false,'cambiada'=>false];
            $devuelve[$i]['posicion'] = 0;
            $devuelve[$i]['mensaje'] = '';
            $i++;
        }
        if ($tipo == 1)
        {
            return $devuelve;
        }
        else
        {
            return $arrayUsuariosStr;
        }
        
    }
}
//fin de nuevas



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
    //$seed = rand(0, 256*256*256);
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
}

?>