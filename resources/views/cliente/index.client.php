@extends('layouts.app')

@section('title')
      Clientes
@endsection

@section('content')
<style>
  .container {
    display: flex;
}

.left-column {
    width: 45%; /* Ancho relativo de la columna izquierda */
}

.right-column {
    width: 55%; /* Ancho relativo de la columna derecha */
}
  .circle {
    margin-top: 5px;
    background-color: rgb(14, 200, 224);
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Hace que el borde sea circular */
    display: flex;
    justify-content: center;
    align-items: center;
    }
    .circle1 {
      width: 140px;
      height: 140px;
      border-radius: 50%; /* Hace que el borde sea circular */
      display: flex;
      justify-content: center;
      align-items: center ;
      overflow: hidden; /* Para recortar cualquier parte de la imagen que esté fuera del círculo */
      }
      .circle2 {
        background-color: rgb(255, 255, 255);
        width: 30px; /* Tamaño del círculo más pequeño */
        height: 30px; /* Tamaño del círculo más pequeño */
        border-radius: 50%;
        position: absolute;
        display: flex;
      justify-content: center;
      align-items: center;
        top: 75px; /* Distancia desde arriba */
        left: 30px; /* Distancia desde la izquierda */
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5); /* Añadir sombra */
    }
    .circle3 {
      background-color: rgb(255, 0, 0);
      width: 15px; /* Tamaño del círculo más pequeño */
      height: 15px; /* Tamaño del círculo más pequeño */
      border-radius: 50%;
      align-items: center;

  }
  .circle img {
    width: 100%;
    height: 100%;
    border-radius: 50%; /* Para que la imagen se ajuste al círculo */
  }
  td {
      text-align: center;
      
      padding: 5px;
       
      background-color:rgb(245, 245, 245);
      border: 0;
      height: 40px;
      
  }
  .arrow {
    display: inline-block;
  width: 0;
  height: 0;
  border-style: solid;
  margin: auto;
  transition: border-color 0.3s;
  }
  .arrow-container {
    text-align: center;
  }
  .left-arrow {
    border-width: 10px 15PX 10px 0px;
    border-color: transparent Rgb(200,200,200) transparent transparent ;
    margin-right: 20px;
  }
  .right-arrow {
    border-width: 10px 0px 10px 15PX;
    border-color: transparent transparent transparent Rgb(200,200,200);
    margin-left: 20px;
  }   
  .arrow:hover {
    border-color: transparent black transparent BLACK;
  }
  .triangulo{
    border-width: 10px 0px 10px 20PX;
    border-color: transparent transparent transparent Rgb(200,200,200);
  }
  .triangle {
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 10px solid black; /* Ajusta el tamaño y color del triángulo */
    position: absolute;
    top: 50%; /* Centra verticalmente el triángulo */
    left: 50%; /* Centra horizontalmente el triángulo */
    transform: translate(-50%, -50%); /* Centra el triángulo correctamente */
}
/* Posicionamiento del triángulo dentro de la flecha izquierda */
.left-arrow .triangle {
  position: absolute;
  top: 50%; /* Centra verticalmente el triángulo */
  right: -5px; /* Ajusta la posición del triángulo hacia la derecha */
  transform: translateY(-50%); /* Centra verticalmente el triángulo */
}

/* Posicionamiento del triángulo dentro de la flecha derecha */s
.right-arrow .triangle {
  position: absolute;
  top: 50%; /* Centra verticalmente el triángulo */
  left: -5px; /* Ajusta la posición del triángulo hacia la izquierda */
  transform: translateY(-50%); /* Centra verticalmente el triángulo */
}
 img{
    width: 14px;
    height: 14px;
    margin-right: 5px;
    
  }
  .celda2{
    width: 66%s;
    text-align: left;
  }
  td.celda2 div {
    position: absolute;
    top: 0;
  
  }
  select {
    
    padding: 10px; /* Ajusta el espacio interno */
    border: 2px solid #ccc; /* Añade un borde */
    border-radius: 5px; /* Añade esquinas redondeadas */
    background-color: #f9f9f9; /* Ajusta el color de fondo */
    font-size: 16px; /* Ajusta el tamaño de la fuente */
    width: 280px; /* Ajusta el ancho */
  }

  /* Estilo para los option del select */
  select option {
    background-color: #fff; /* Color de fondo para las opciones */
    color: #333; /* Color del texto de las opciones */
  }
  nav {
    background-color: #333;
  }
  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex; /* Utiliza flexbox para alinear los elementos */
    
  }
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    
  }
  li {
    width: 20%;
    border: 10px;
    
    border-right: 2px solid white;
  }
  li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }
  li a img{
    margin: 0 auto; /* Centra horizontalmente las imágenes */
    display: block;
    width: 20px;
    height: 20px;
    
    filter: brightness(0) invert(1);
  }
  nav li:last-child {
    font-size: 25px;
    padding:10px;
    text-align: center;
    color: #330dbe;
    width: 50%;
    border-right: none;
    background-color: white; /* Fondo blanco para el último li */
}
  li a:hover {
    background-color: rgb(14, 200, 224);
  }
  .celda3 div {
    height: 20%; /* Dividir la celda 3 en 5 filas */
    border-bottom: 1px solid #ccc; /* Agregar bordes entre las filas */
  }
  .celda3 div {
    height: 20%; /* Dividir la celda 3 en 5 filas */
    border-bottom: 1px solid #ccc; /* Agregar bordes entre las filas */
    display: table-row; /* Establece los div como filas de una tabla */
    text-align: center; /* Centra el contenido dentro de los div */
  }

  /* Estilo para el contenido dentro de los div en la celda 3 */
  .celda3 div div {
    display: table-cell; /* Establece el contenido como celdas de la tabla */
    vertical-align: middle; /* Centra verticalmente el contenido */
    border: 1px solid white; /* Agrega bordes blancos alrededor del contenido */
    padding: 10px; /* Agrega espacio interno al contenido */
  }
  .vertical-text {
    transform: rotate(180deg); /* Rotar el texto -90 grados */
    writing-mode: vertical-rl; /* Modo de escritura vertical de derecha a izquierda */
    white-space: nowrap; /* Evitar que el texto se divida en varias líneas */
    margin: 10px;
    
    
  }
  .ACTIVITI{
    padding: 0%;
    width: 5%;
    height: 200PX;
    color: white;
    background-color: #01020e;
    
  }
  .text_cuadro2{
    margin: 10px;
  }
  section {
    display: none;
    padding: 20px;
  }
  
  /* Estilo para mostrar la sección activa */
  section.active {
    display: block;
  }

  /* Estilo para el enlace activo */
  .active-link {
    font-weight: bold;
    /* Agrega cualquier otro estilo que desees para indicar el enlace activo */
  }

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cliente</title>
</head>

<body>
  <div class="container">
    <div class="left-column">
        <TABLE style="width:100%;">
            <TR>
                <td class="celda1" style="width: 25%;padding: 20px"rowspan="5">
                  <Div>
                    <a href="pagina1.html"><div class="arrow left-arrow"></div></a>
                    <a href="pagina2.html"><div class="arrow right-arrow"></div></a>
                  </Div>
                    <div class="circle">
                      <div class="circle1">
                        <img src="imagenes/perfil.png" alt=""><!--Para que la imagen se ajuste al círculo-->
                        <div class="circle2">
                          <div class="circle3"></div>
                        </div>
                      </div>
                    </div>
                    <h2 class="ID" style="color: rgb(14, 200, 224);">11111</h2>
                    <h3><img src="imagenes/link.png" alt=""><a href="" style="color: black;"><u>Link</u></a></h3>
                </td>
                
                <td class="celda2"style="width: 50%; padding:20px"rowspan="5" >
                  <div>
                  <h1><!--nombre del cliente-->monica</h1>
                  <h3><img src="imagenes/telefono.png" alt=""><!--numero de telefono-->999999999</h3>
                  <h3><img src="imagenes/carta.png" alt=""><!--correo-->hehnzo1473@gmail.com</h3>
                  <select style="width: 100%;" id="opciones" name="opciones">
                    <option value="opcion1">test</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                    <option value="opcion4">Opción 4</option>
                  </select>
                </div>
                </td>
                <td class="celda3"style="width: 20%;">
                  <tr>
                    <td style="margin: 0; padding: 0"><a href=""style="color: black;"><h4 style="margin: 0;padding: 0;"><img src="imagenes/telefono (2).png" alt=""><u>Call</u></h4></a><!--metodo para enviar email al cliente--></td>
                  </tr>
                </td>
            </TR>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td></td>
            </tr>
            <tr>
              <td style="margin: 0; padding: 0; height:40px"><a href=""style="color: black;"><h4 style="margin: 0;padding: 0;"><img src="imagenes/carta.png" alt="" ><u>Email</u></h4></a><!--metodo para enviar email al cliente--></td>
            </tr>
            
        </TABLE>
        <table style="width: 100%;">
        <Tr>
              <td class="ACTIVITI"><h4 class="vertical-text">Activity</h4></td>
              <td colspan="">
                <div class="container">
                <div class="left-column" style="text-align: left;">
                  <ul style="color: rgb(14, 200, 224);"><h3 class="text_cuadro2">Brand</h3></ul>
                  <ul style="color: rgb(14, 200, 224);"><h3 class="text_cuadro2">Registration</h3></ul>
                  <ul style="color: rgb(14, 200, 224);"><h3 class="text_cuadro2">FTD Date</h3></ul>
                  <ul style="color: rgb(14, 200, 224);"><h3 class="text_cuadro2">Consumer status</h3></ul>
                  <ul style="color: rgb(14, 200, 224);"><h3 class="text_cuadro2">Desk</h3></ul>
                </div>
                <div class="right-column" style="text-align:left; ">
                  <ul style="color: rgb(0, 0, 0);"><h3 class="text_cuadro2">1123456789098765432s</h3></ul>
                  <ul style="color: rgb(0, 0, 0);"><h3 class="text_cuadro2">1123456789098765432s</h3></ul>
                  <ul style="color: rgb(0, 0, 0);"><h3 class="text_cuadro2">1123456789098765432s</h3></ul>
                  <ul style="color: rgb(0, 0, 0);"><h3 class="text_cuadro2">1123456789098765432s</h3></ul>
                  <ul style="color: rgb(0, 0, 0);"><h3 class="text_cuadro2">1123456789098765432s</h3></ul>
                </div>
              </div>
              </td>

           </Tr>
        </table>
      </Div>
      <DIV class="right-column" style="margin-left: 15px;">
        <th class="celda4" rowspan="5">
          <tr>
            <h3 style="Background-color:#01020e; color:white;margin:0;padding: 15px">Comunication History</h3>
        </tr>
          <nav>
            <ul>
              <li><a href="#todo" onclick="mostrarSeccion(event, 'todo')"><img style="color:white" src="imagenes/multitarea.png" alt=""></a></li>
              <li><a href="#comentario" onclick="mostrarSeccion(event, 'comentario')"><img src="imagenes/gente.png" alt=""></a></li>
              <li><a href="#historial de llamada" onclick="mostrarSeccion(event, 'historial de llamada')"><img src="imagenes/telefono.png" alt=""></a></li>
              <li><a href="#task" onclick="mostrarSeccion(event, 'Task')"><img src="imagenes/movil.png" alt=""></a></li>
              <li id="nombre-seleccionado"></li>
            </ul>
          </nav>
          <section id="todo" class="active" style="padding:0">
            <div>
            <table style="width: 100%; ">
              
              <tr>
                <td>123456</td>
                <td>23456</td>
                <td>23456</td>
              </tr>
              <tr>
                <td>123456</td>
                <td>23456</td>
                <td>23456</td>
              </tr>
              <tr>
                <td>123456</td>
                <td>23456</td>
                <td>23456</td>
              </tr>
              <tr>
                <td>123456</td>
                <td>23456</td>
                <td>23456</td>
              </tr>
            </table>
            </div>
            <!-- Contenido de la sección de inicio -->
          </section>
          
          <section id="comentario">
            <div>
              <table style="width: 100%; ">
              
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
              </table>
            </div>
            <!-- Contenido de la sección de nosotros -->
          </section>
          
          <section id="historial de llamada">
            <div>
              <table style="width: 100%; ">
              
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
              </table>
            </div>
            <!-- Contenido de la sección de servicios -->
          </section>
          
          <section id="Task">
            <div>
              <table style="width: 100%; ">
              
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
                <tr>
                  <td>123456</td>
                  <td>23456</td>
                  <td>23456</td>
                </tr>
              </table>
            </div>
            <!-- Contenido de la sección de contacto -->
          </section>
          <script>
            function mostrarSeccion(event, id) {
              event.preventDefault(); // Evita que el enlace redireccione a otra página
              
            
              // Ocultar todas las secciones
              var secciones = document.querySelectorAll('section');
              secciones.forEach(function(seccion) {
                seccion.classList.remove('active');
              });
            
              // Mostrar la sección correspondiente al ID pasado como argumento
              var seccionMostrar = document.getElementById(id);
              if (seccionMostrar) {
                seccionMostrar.classList.add('active');
              }
              var nombreSeleccionado = document.getElementById('nombre-seleccionado');
            switch (id) {
                case 'todo':
                    nombreSeleccionado.textContent = 'Todo';
                    break;
                case 'comentario':
                    nombreSeleccionado.textContent = 'Comentario';
                    break;
                case 'historial de llamada':
                    nombreSeleccionado.textContent = 'Historial de Llamada';
                    break;
                case 'Task':
                    nombreSeleccionado.textContent = 'Task';
                    break;
                default:
                    nombreSeleccionado.textContent = '';
                    break;
            }
              // Marcar el enlace como activo
              var enlaces = document.querySelectorAll('nav a');
              enlaces.forEach(function(enlace) {
                enlace.classList.remove('active-link');
              });
            
              event.target.classList.add('active-link');
            }
            
            </script>          
        </th>
      </DIV>
    </DIV>
    
</body>

@endsection