const mostrarCarta = (sitioNumero, sitioPalo, numeroAleatorio) => {
  let imagenNumeros = [
    'https://image.flaticon.com/icons/svg/60/60141.svg',
    'https://image.flaticon.com/icons/svg/60/60046.svg',
    'https://image.flaticon.com/icons/svg/427/427591.svg',
    'https://image.flaticon.com/icons/svg/2014/2014144.svg'
  ]
  let imagenPalos = [
    'https://image.flaticon.com/icons/svg/991/991959.svg',
    'https://image.flaticon.com/icons/svg/1425/1425468.svg',
    'https://image.flaticon.com/icons/svg/2159/2159565.svg',
    'https://image.flaticon.com/icons/svg/1518/1518599.svg'
  ];
  let numeroEntero = numeroAleatorio%10 + 1;
  let palo = Math.floor(numeroAleatorio/10);
  if (numeroEntero === 1){
    sitioNumero.style.backgroundImage = `url(${imagenNumeros[0]}`;
    sitioNumero.style.backgroundColor = '#f4f4f4';
  } else if (numeroEntero === 8) {
    sitioNumero.style.backgroundImage = `url(${imagenNumeros[1]}`;
    sitioNumero.style.backgroundColor = '#f4f4f4';
  } else if (numeroEntero === 9) {
    sitioNumero.style.backgroundImage = `url(${imagenNumeros[2]}`;
    sitioNumero.style.backgroundColor = '#f4f4f4';
  } else if (numeroEntero === 10) {
    sitioNumero.style.backgroundImage = `url(${imagenNumeros[3]}`;
    sitioNumero.style.backgroundColor = '#f4f4f4';
  } else {
    sitioNumero.innerHTML = `<h1>${numeroEntero}</h1>`;
  }
  if (palo === 0) {
    sitioPalo.style.backgroundImage = `url(${imagenPalos[0]}`;
  } else if (palo === 1) {
    sitioPalo.style.backgroundImage = `url(${imagenPalos[1]}`;
  } else if (palo === 2) {
    sitioPalo.style.backgroundImage = `url(${imagenPalos[2]}`;
  } else if (palo === 3) {
    sitioPalo.style.backgroundImage = `url(${imagenPalos[3]}`;
  }
};

function nombreFicheroCarta(id) {
    var nombreFichero = 'img/cartas/';
    if(id == -1) {
        nombreFichero += 'Dorso.jpg';
    } else {
        var numero = '0';
        var i = id%10 + 1;
        if(i < 8) {
            numero = '' + i;
        } else if(i == 8) {
            numero = 'S';
        } else if(i == 9) {
            numero = 'C';
        } else if(i == 10) {
            numero = 'R';
        }
        
        var numeroPalo = Math.floor(id/10);
        var palo = '';
        if(numeroPalo == 0) {
            palo = 'O';
        } else if(numeroPalo == 1) {
            palo = 'C';
        } else if(numeroPalo == 2) {
            palo = 'E';
        } else if(numeroPalo == 3) {
            palo = 'B';
        }
        
        nombreFichero += numero + palo + '.jpg';
    }

    return nombreFichero;
}

function mostrarCartaPorTipo(tipoCarta, posicion, index, id, marcar) {
    let carta = document.getElementById(`carta-${posicion}-${index}`);
    if(tipoCarta == 0) {
        carta.innerHTML ='<div class="contenedorNumero" id="contenedorNumero-' + posicion + '-' + index + '"></div>' +
            '<div id="paloCarta-' + posicion + '-' + index + '" class="contenedorPalo"></div>';
        let contenedorPalo = document.getElementById(`paloCarta-${posicion}-${index}`);
        let numero = document.getElementById(`contenedorNumero-${posicion}-${index}`);
        mostrarCarta(numero, contenedorPalo, id);
    } else if(tipoCarta == 1) {
        var nombreFichero = nombreFicheroCarta(id);
        carta.innerHTML ='<div style="position:block;text-align:center;background-position:center;margin-top:auto"><img src="' + nombreFichero + '" style=";max-width:96px;max-height:146px" /></div>';
    }
    if(marcar) {
        carta.classList.add('cartaMarcada');
    }
}

function mostrarCartas(usuarios, primerasDadas, mano, tipoCarta, mostrarCartasOtros) {
  var usuarioTop;
  var mensajeUsuarioTop;
  var usuarioLeft;
  var mensajeUsuarioLeft;
  var usuarioRight;
  var mensajeUsuarioRight;
  var usuarioBottom;
  var mensajeUsuarioBottom;
  
  for (var i = 0; i < 4; i++) {
      if(usuarios[i].posicion == 0) {
          usuarioTop = usuarios[i];
          mensajeUsuarioTop = usuarioTop.nombre + (mano == usuarioTop.id ? ' (mano)' : '') + (usuarioTop.mensaje != '' ? ': ' + usuarioTop.mensaje : '');
      } else if(usuarios[i].posicion == 1) {
          usuarioLeft = usuarios[i];
          mensajeUsuarioLeft = usuarioLeft.nombre + (mano == usuarioLeft.id ? ' (mano)' : '') + (usuarioLeft.mensaje != '' ? ': ' + usuarioLeft.mensaje : '');
      } else if(usuarios[i].posicion == 2) {
          usuarioBottom = usuarios[i];
          mensajeUsuarioBottom = usuarioBottom.nombre + (mano == usuarioBottom.id ? ' (mano)' : '') + (usuarioBottom.mensaje != '' ? ': ' + usuarioBottom.mensaje : '');
      } else if(usuarios[i].posicion == 3) {
          usuarioRight = usuarios[i];
          mensajeUsuarioRight = usuarioRight.nombre + (mano == usuarioRight.id ? ' (mano)' : '') + (usuarioRight.mensaje != '' ? ': ' + usuarioRight.mensaje : '');
      }
  }
  
  let playerNameTop = document.getElementsByClassName(`player-name-top`)[0];
  playerNameTop.innerHTML = `<h2>${mensajeUsuarioTop}</h2>`;
  
  let playerNameLeft = document.getElementsByClassName(`player-name-left`)[0];
  playerNameLeft.innerHTML = `<h2>${mensajeUsuarioLeft}</h2>`;
  
  let playerNameRight = document.getElementsByClassName(`player-name-right`)[0];
  playerNameRight.innerHTML = `<h2>${mensajeUsuarioRight}</h2>`;
  
  let playerNameBottom = document.getElementsByClassName(`player-name-bottom`)[0];
  playerNameBottom.innerHTML = `<h2>${mensajeUsuarioBottom}</h2>`;

  for (var i = 1; i <= 4; i++) {
    mostrarCartaPorTipo(tipoCarta, 'top', i, mostrarCartasOtros ? usuarioTop.cartas[i-1].id : -1,
        !primerasDadas && usuarioTop.cartas[i-1].cambiada);
    
    mostrarCartaPorTipo(tipoCarta, 'left', i, mostrarCartasOtros ? usuarioLeft.cartas[i-1].id : -1,
        !primerasDadas && usuarioLeft.cartas[i-1].cambiada);
    
    mostrarCartaPorTipo(tipoCarta, 'right', i, mostrarCartasOtros ? usuarioRight.cartas[i-1].id : -1,
        !primerasDadas && usuarioRight.cartas[i-1].cambiada);
    
    mostrarCartaPorTipo(tipoCarta, 'bottom', i, usuarioBottom.cartas[i-1].id,
        !primerasDadas && usuarioBottom.cartas[i-1].cambiada);
    
    let checkBottom = document.getElementById(`carta-${i}`);
    checkBottom.checked = usuarioBottom.cartas[i-1].seleccionada;
  }
}

function randomWithSeed(seed, i0, n) {
    var x = 0;
    var i = 0;
    var s = seed;
    var r = new Array();
    while(i < i0 + n) {
        if(i%4 == 0) {
            x = Math.abs(Math.sin(s + 1));
            x = x * 256;
            x = x - Math.floor(x);
            s = 1;
        }
        x = x * 256;
        var v = Math.floor(x);  
        x = x - v;
        
        if(i%4 < 3) {
            s = s * 256 + v;
        }

        if(i >= i0 && i < i0 + n) {
            r.push(v);
        }
        
        i++;
    }
    return r;
}

function checkState(seed, acciones, idUsuario, usuarios) {
    var randomValues = randomWithSeed(seed, 0, 1000);
    
    // equipos

    var nUsuario = 0;
    var usuariosEquipo = 0;
    while(usuariosEquipo < 2) {
        var index = sacarCarta(cards, randomValues, cardsLeft);
        if((index + 1)%10 == 0) {
            usuarios[nUsuario].team = 1;
            usuariosEquipo++;
        }
        
        do {
            nUsuario = (nUsuario + 1)%4;
        } while(usuarios[nUsuario]["team"] == 1);
    }
    
    // calculo posicion jugadores
    var usuarioPosicion = new Array();
    usuarioPosicion[0] = usuarios[0];
    usuarioPosicion[1] = -1;
    usuarioPosicion[2] = -1;
    usuarioPosicion[3] = -1;
    var posOtroTeam = 1;
    for(var i = 1 ; i < 4 ; i++) {
        if(usuarios[i].team == usuarios[0].team) {
            usuarioPosicion[2] = usuarios[i];
        } else {
            usuarioPosicion[posOtroTeam] = usuarios[i];
            posOtroTeam += 2;
        }
    }
    
    var offset = 0;
    for(var i = 0 ; i < 4 ; i++) {
        if(usuarioPosicion[i].id == idUsuario) {
            offset = 2 - i;
            break;
        }
    }
    
    for(var i = 0 ; i < 4 ; i++) {
        usuarioPosicion[i].posicion = (i + offset + 4)%4;
    }
    
    // mano inicial
    
    mano = randomValues[posicion]%4 + 1;
    posicion++;
    
    // ordenes
    var ordenReparto = new Array();
    var ordenMus = new Array();
    var i = 0;
    while(usuarioPosicion[i].id != mano) {
        i = (i + 1)%4;
    }
    for(var i2 = 0 ; i2 < 4 ; i2++) {
        ordenReparto.push(usuarioPosicion[(i + i2)%4].id);
    }
    ordenMus.push(ordenReparto[0]);
    ordenMus.push(ordenReparto[2]);
    ordenMus.push(ordenReparto[1]);
    ordenMus.push(ordenReparto[3]);
    
    // cartas iniciales
    
    for(var i = 0 ; i < 40 ; i++) {
        cards[i] = false;
    }
    cardsLeft = 40;

    repartir(usuarios, ordenReparto, cards, randomValues);

    var usuariosNoConectados = new Array();
    for(var i = 0 ; i < 4 ; i++) {
        if(!usuarios[i].conectado) {
            usuariosNoConectados.push(usuarios[i]);
        }
    }

    if(usuariosNoConectados.length == 0) {
        var turnos = getTurnos(acciones);
        var esperando = new Array();
        var nomus = -1;
        var nuevaMano = false;
        var bajar = -1;
        var noAccionUltimoTurno = false;
        var turnosManoActual = 1;
        if(turnos.length > 0) {
            for(var i = 0 ; i < turnos.length ; i++) {
                var turno = turnos[i];
                var accionesTurno = getAccionesTurno(turno);
                esperando = new Array();
                nomus = -1;
                nuevaMano = false;
                bajar = -1;
                
                var ultimoTurno = i == turnos.length - 1;
                for(var i2 = 0 ; i2 < 4 ; i2++) {
                    var idUsuarioTurno = ordenMus[i2];
                    var accionTurno = accionesTurno[idUsuarioTurno - 1];
                    if(accionTurno == '*') {
                        nomus = idUsuarioTurno;
                    } else if(accionTurno == '?') {
                        bajar = idUsuarioTurno;
                    } else if(accionTurno == '$') {
                        nuevaMano = true;
                        break;
                    } 
                }

                if(!nuevaMano && nomus == -1 && bajar == -1) {
                    for(var i2 = 0 ; i2 < 4 ; i2++) {
                        var idUsuarioTurno = ordenMus[i2];
                        var accionTurno = accionesTurno[idUsuarioTurno - 1];
                        if(accionTurno == '-') {
                            esperando.push(idUsuarioTurno);
                        }
                    }
                }
 
                     if(nuevaMano) {
                        for(var i2 = 0 ; i2 < 40 ; i2++) {
                            cards[i2] = false;
                        }
                        cardsLeft = 40;
                        for(var i2 = 0 ; i2 < 4 ; i2++) {
                            for(var i3 = 0 ; i3 < 4 ; i3++) {
                                usuarios[i2].cartas[i3].id = -1;
                            }
                        }
                        
                        mano = siguienteMano(ordenReparto, ordenMus);
        
                        repartir(usuarios, ordenReparto, cards, randomValues);
        
                        turnosManoActual = 1;
                        
                        noAccionUltimoTurno = ultimoTurno;
                    } else {
                        if(esperando.length == 0 && nomus == -1 && bajar == -1) {
                           for(var i2 = 0 ; i2 < 4 ; i2++) {
                              var idUsuarioTurno = ordenMus[i2];
                              var accionTurno = turno[idUsuarioTurno - 1];
                              eliminarCartas(usuarios[idUsuarioTurno - 1], accionTurno);
                           }
                                
                           repartir(usuarios, ordenReparto, cards, randomValues);
        
                           noAccionUltimoTurno = ultimoTurno;
                                    
                           turnosManoActual = turnosManoActual + 1; 
                        } else {
                            for(var i2 = 0 ; i2 < 4 ; i2++) {
                                var idUsuarioTurno = ordenMus[i2];
                                var accionTurno = turno[idUsuarioTurno - 1];
                                seleccionarCartas(usuarios[idUsuarioTurno - 1], accionTurno);
                            }
                            break;
                        }
                    }
            }
        } else {
            noAccionUltimoTurno = true;
        }

        if(esperando.length > 0) {
            var esperandoYo = false;
            var esperandoOtros = '';
            for(var i = 0 ; i < esperando.length ; i++) {
                 if(esperando[i] == idUsuario) {
                     esperandoYo = true;
                 } else {
                     if(esperandoOtros.length > 0) {
                         esperandoOtros += ', ';
                     }
                     esperandoOtros += usuarios[esperando[i] - 1].nombre;
                 }
            }
            
            if(!esperandoYo && esperandoOtros.length > 0) {
                 textOverlay = 'Esperando a ' + esperandoOtros;
                 bloquear = true;
            }
        } else if(!nuevaMano && bajar == -1 && nomus != -1) {
            textOverlay = 'Apuestas';
            bloquear = true;
        } else if(!nuevaMano && bajar != -1) {
            textOverlay = 'Bajar cartas';
            mostrarCartasOtros = true;
            bloquear = true;
        } else {
            textOverlay = 'Cartas repartidas';
            bloquear = false;
        }

        if(bloquear) {
            var found = false;
            for(var i = 0 ; i < 4 ; i++) {
                var idUsuarioTurno = ordenMus[i];

                if(!found) {
                        if(nomus != -1 && nomus == idUsuarioTurno) {
                            usuarios[idUsuarioTurno -1].mensaje = 'no mus';
                            found = true;
                        } else if(!esperando.includes(idUsuarioTurno)) {
                            usuarios[idUsuarioTurno -1].mensaje = 'mus';
                        } else {
                            usuarios[idUsuarioTurno -1].mensaje = '';
                            found = true;
                        }
                } else {
                    usuarios[idUsuarioTurno -1].mensaje = '';
                }
            }
        }

        primerasDadas =  (turnosManoActual < 2) && (esperando.length > 0 || nomus != -1 || bajar != -1 || noAccionUltimoTurno);
    } else {
        var txt = '';
        for(var i = 0 ; i < usuariosNoConectados.length ; i++) {
            if(txt != '') {
                txt += ', ';
            }
            
            txt +=  usuariosNoConectados[i].nombre;
        }
        
        textOverlay = 'Esperando a ' + txt;
        bloquear = true;
    }
}

function sacarCarta(cards, randomValues) {
    var index = 0;
    
    if(cardsLeft > 1) {
        index = randomValues[posicion]%cardsLeft;
        posicion++;
    }
    
    var i = 0;
    var i2 = 0;
    var found = false;
    while(true) {
        if(!cards[i]) {
            if(i2 == index) {
                cards[i] = true;
                cardsLeft--;
                return i;
            }
            i2++;
        }
        i++;
    }
    
    return -1;
}

function getTurnos(acciones) {
    var turnos = new Array();
    
    var maxLength = 0;
    for(var i = 0 ; i < 4 ; i++) {
        if(acciones[i].length > maxLength) {
           maxLength = acciones[i].length;
        }
    }
    
    for(var i = 1 ; i < maxLength ; i++) {
        var acc = new Array();
        for(var i2 = 0 ; i2 < 4 ; i2++) {
             if(acciones[i2].length > i) {
                acc.push(acciones[i2].charAt(i));
             } else {
                acc.push('-');
             }
        }
        
        turnos.push(acc);
    }

    return turnos;
}

function getAccionesTurno(turno) {
    var accionesTurno = new Array();
    for(var i = 0 ; i < 4 ; i++) {
        accionesTurno.push(turno[i]);
    }
    
    return accionesTurno;
}

function siguienteMano(ordenRepartir, ordenMus) {

    var nuevaMano = ordenRepartir[1];
    var swap = ordenRepartir[0];
    for(var i = 1 ; i < 4 ; i++) {
        ordenRepartir[i - 1] = ordenRepartir[i];
    }
    ordenRepartir[3] = swap;

    swap = ordenMus[0];
    ordenMus[0] = ordenMus[2];
    ordenMus[2] = ordenMus[1];
    ordenMus[1] = ordenMus[3];
    ordenMus[3] = swap;

    return nuevaMano;    
}

function eliminarCartas(usuario, accionTurno) {
    var ch = accionTurno.charCodeAt(0);
    var chA = 'A'.charCodeAt(0);
    var ch0 = '0'.charCodeAt(0);
    var n = ch >= chA ? 10 + ch - chA : ch - ch0;
    if((n & 8) > 0) {
        usuario.cartas[0].id = -1;
        usuario.cartas[0].seleccionada = false;
        usuario.cartas[0].cambiada = false;
    }
    
    if((n & 4) > 0) {
        usuario.cartas[1].id = -1;
        usuario.cartas[1].seleccionada = false;
        usuario.cartas[1].cambiada = false;
    }
    
    if((n & 2) > 0) {
        usuario.cartas[2].id = -1;
        usuario.cartas[2].seleccionada = false;
        usuario.cartas[2].cambiada = false;
    }
    
    if((n & 1) > 0) {
        usuario.cartas[3].id = -1;
        usuario.cartas[3].seleccionada = false;
        usuario.cartas[3].cambiada = false;
    }
}

function seleccionarCartas(usuario, accionTurno) {
    if(accionTurno == '-' || accionTurno == '*' || accionTurno == '?') {
       usuario.cartas[0].seleccionada = false;
       usuario.cartas[1].seleccionada = false;
       usuario.cartas[2].seleccionada = false;
       usuario.cartas[3].seleccionada = false;
    } else {
       var ch = accionTurno.charCodeAt(0);
       var chA = 'A'.charCodeAt(0);
       var ch0 = '0'.charCodeAt(0);
       var n = ch >= chA ? 10 + ch - chA : ch - ch0;

       usuario.cartas[0].seleccionada = ((n & 8) > 0 ? true : false);
       usuario.cartas[1].seleccionada = ((n & 4) > 0 ? true : false);
       usuario.cartas[2].seleccionada = ((n & 2) > 0 ? true : false);
       usuario.cartas[3].seleccionada = ((n & 1) > 0 ? true : false);
    }
}

function repartir(usuarios, ordenReparto, cards, randomValues) {
    var i = 0;
    while(i < 4) {
        var idUser = ordenReparto[i];
        var nCartaJugador = 0;
        while(nCartaJugador < 4) {
            if(usuarios[idUser - 1].cartas[nCartaJugador].id == -1) {
                if(cardsLeft == 0) {
                    // Se baraja de nuevo cuando se acaban
                    for(var i2 = 0 ; i2 < 40 ; i2++) {
                        cards[i2] = false;
                    }
                    cardsLeft = 40;
                    for(var i2 = 0 ; i2 < usuarios.length ; i2++) {
                        for(var i3 = 0 ; i3 < 4 ; i3++) {
                            var carta = usuarios[i2].cartas[i3].id;
                            if(carta != -1) {
                                cards[carta] = true;
                                cardsLeft--;
                            }
                        }
                    }
                }
                
                var index = sacarCarta(cards, randomValues);
                
                usuarios[idUser - 1].cartas[nCartaJugador].id = index;
                usuarios[idUser - 1].cartas[nCartaJugador].seleccionada = false;
                usuarios[idUser - 1].cartas[nCartaJugador].cambiada = true;
                
            } else {
                usuarios[idUser - 1].cartas[nCartaJugador].seleccionada = false;
                usuarios[idUser - 1].cartas[nCartaJugador].cambiada = false;
            }
            
            nCartaJugador++;
        }
        
        i++;
    }
}

function musClicked() {
    var carta1 = document.getElementById("carta-1").checked;
    var carta2 = document.getElementById("carta-2").checked;
    var carta3 = document.getElementById("carta-3").checked;
    var carta4 = document.getElementById("carta-4").checked;
    
    if (!carta1 && !carta2 && !carta3 && !carta4) {
        alert("Selecciona cartas antes de dar mus");

        return false;
    }
    
    return true;
}

function nomusClicked() {
    var carta1 = document.getElementById("carta-1").checked;
    var carta2 = document.getElementById("carta-2").checked;
    var carta3 = document.getElementById("carta-3").checked;
    var carta4 = document.getElementById("carta-4").checked;
    
    if (carta1 || carta2 || carta3 || carta4) {
        alert("No puede haber cartas seleccionadas cuando se corta el mus");

        return false;
    }
    
    return true;
}