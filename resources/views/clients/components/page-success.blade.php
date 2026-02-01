<!DOCTYPE html>
<html lang="en">
@include('components.head', ['title'=>'Registro de Viajeros'])
<style>
        /* Centrar el contenedor */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ocupa toda la altura de la pantalla */
        }
        .card {
            width: 400px; /* Ajusta el tamaño de la card si es necesario */
        }
    </style>
<body class="grey lighten-4">
    @if (Session::get('user'))
        @include('components.nav', ['userWk'=> Session::get('user'), 'showSearch'=> false])
    @else
        <nav class="blue darken-2">
            <h4 class="center" style="margin:0em;padding-top: 1%;">Cielo de Cebreros</h4>
        </nav>
    @endif
    <div class="container">
        <div class="card medium">
            <div class="card-image">
                <img src="https://img1.picmix.com/output/stamp/thumb/1/6/0/8/718061_1a0f1.gif">
                <span class="card-title black-text">¡Bienvenido/a! 🎉</span>
            </div>
            <div class="card-content">
                <p>Gracias por confiar en nosotros. Esperamos que disfrutes tu estadía.
                Si necesitas algo, nuestro equipo está aquí para ayudarte.</p>
            </div>
            <div class="card-action">
                <a href="https://tumasyohoteles.com/">Ir al inicio</a>
            </div>
        </div>
    </div>   
    <!-- </section> -->


 <!--Import jQuery before materialize.js-->
    @include('components.scripts')

</body>
</html>