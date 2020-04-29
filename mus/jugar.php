<div class="wrapper">
    <div class="box contenedor-cartas-top">
        <div class="player-name player-name-top"></div>
        <div class="contenedor-cartas">
              <div class="carta" id="carta-top-1"></div>
              <div class="carta" id="carta-top-2"></div>
              <div class="carta" id="carta-top-3"></div>
              <div class="carta" id="carta-top-4"></div>
        </div>
        <div class="player-name player-message-top"></div>
    </div>
    
    <div class="box contenedor-cartas-left">
        <div class="player-name player-name-left"></div>
        <div class="contenedor-cartas">
              <div class="carta" id="carta-left-1"></div>
              <div class="carta" id="carta-left-2"></div>
              <div class="carta" id="carta-left-3"></div>
              <div class="carta" id="carta-left-4"></div>
        </div>
        <div class="player-name player-message-left"></div>
    </div>
    
    <!-- div class="box contenedor-centro"></div -->
        
    <div class="box contenedor-cartas-right">
        <div class="player-name player-name-right"></div>
        <div class="contenedor-cartas">
              <div class="carta" id="carta-right-1"></div>
              <div class="carta" id="carta-right-2"></div>
              <div class="carta" id="carta-right-3"></div>
              <div class="carta" id="carta-right-4"></div>
        </div>
        <div class="player-name player-message-right"></div>
    </div>
    
    <div class="box contenedor-cartas-bottom-left">
         <div class="player-name player-name-bottom"></div>
        <div class="contenedor-cartas">
              <div class="carta" id="carta-bottom-1"></div>
              <div class="carta" id="carta-bottom-2"></div>
              <div class="carta" id="carta-bottom-3"></div>
              <div class="carta" id="carta-bottom-4"></div>
              
              <div class="checkCarta"><input type="checkbox" id="carta-1" name="carta-1" /></div>
              <div class="checkCarta"><input type="checkbox" id="carta-2" name="carta-2" /></div>
              <div class="checkCarta"><input type="checkbox" id="carta-3" name="carta-3" /></div>
              <div class="checkCarta"><input type="checkbox" id="carta-4" name="carta-4" /></div>
        </div>
    </div>
        <div class="box contenedor-cartas-bottom-right">
        
        <?php
        
            //$usuarios = leerUsuarios();
            //leerEstadoJuego();
            //anadirAccionesEstadoJuego($_POST['usuario']);
            
            echo '<div class="contenedor-botones" class="primerPlano">';
            echo '<button type="submit" name="mus" onclick="musClicked()">Hay mus</button>';
            echo '<button type="submit" name="nomus" onclick="nomusClicked()">No hay mus</button>';
            echo '<div id="mano"></div>';
            
             /* if(compruebamano($usuarios,$_POST['usuario']))
             {
                if(compruebaAccion($acciones, '?')) {  
                    echo '<div class="primerPlano"><button type="submit" name="nuevaMano">Nueva Mano</button></div>';
                } else if(compruebaAccion($acciones, '*')) {  
                    echo '<div class="primerPlano"><button type="submit" name="bajarCartas">Bajar Cartas</button></div>';
                }
                echo '<div class="primerPlano"><button type="submit" name="nuevaPartida">Nueva Partida</button></div>';
             }*/
             
             echo '<input type="hidden" name="usuario" value="'.$_POST['usuario'].'">';
             echo '<input type="hidden" name="iniciado" value="'.$_POST['iniciado'].'">';
             
             echo '</div>';
        ?>
        </div>
    </div>
</div>


