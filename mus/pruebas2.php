<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script type="text/javascript">
dato = [
    <?php
    echo "{'id':1,'nombre':'emi','mano':true,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':2,'nombre':'fernando','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':3,'nombre':'juan','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':4,'nombre':'paco','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''}";
    ?>];
    console.log(dato[0]['nombre']);

    let dato2 = new Array();
    let cadena = [{'id':1,'nombre':'emi','mano':true,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':2,'nombre':'fernando','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':3,'nombre':'juan','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':4,'nombre':'paco','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''}];
    //dato2.push("{'id':1,'nombre':'emi','mano':true,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':2,'nombre':'fernando','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':3,'nombre':'juan','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''},{'id':4,'nombre':'paco','mano':false,'conectado':true,'team':0,'cartas':[{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false},{id:-1,seleccionada:false,cambiada:false}],'posicion':0,'mensaje':''}");
    dato2 = cadena;
    console.log(dato2[0]);
</script>
</body>
</html>