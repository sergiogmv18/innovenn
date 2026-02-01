<!DOCTYPE html>
<html lang="en">
@include('components.head', ['title'=>'Registro de Viajeros'])
<body class="grey lighten-4">
    @if (Session::get('user'))
        @include('components.nav', ['userWk'=> Session::get('user'), 'showSearch'=> false])
    @endif
    <section class="section section-stats center" style="margin-top: 4.5em;">
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <h2 style="margin-top: 10px;" class="style-body-text center">Politica y privacidad</h2>
                </div>
<!-- 1 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">1. Introducción</h4>
                    <p class="style-body-text light">
                        Gracias por elegirnos. Nos comprometemos a proteger la privacidad y seguridad de sus datos de reserva. Estos términos de uso explican cómo manejamos la información recopilada durante el proceso de reserva y la política aplicable a esos datos.
                    <br><br>
                </div>
<!-- 2 -->             
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">2. Recopilación de Datos</h4>
                    <p class="style-body-text light">
                        Durante el proceso de reserva, recopilamos información personal necesaria para garantizar su estancia. Esto puede incluir nombre, dirección de correo electrónico y número de teléfono de contacto.
                    <br><br>
                </div>
<!-- 3 --> 
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">3. Uso de la Información</h4>
                    <p class="style-body-text light">
                        La información recopilada se utilizará exclusivamente para gestionar su reserva y mejorar nuestros servicios. No compartiremos sus datos con terceros sin su consentimiento expreso.
                    <br><br>
                </div>
<!-- 4 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">4. Retención de Datos</h4>
                    <p class="style-body-text light">
                        Los datos de reserva se conservarán mientras sea necesario para cumplir con los fines para los que se recopilaron. Una vez que la reserva haya concluido, los datos personales serán eliminados. Sin embargo, para elogios y comentarios positivos, conservaremos de manera segura (criptografada) su nombre, dirección de correo electrónico y número de teléfono de contacto.
                    <br><br>
                </div>
<!-- 5 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">5. Seguridad de Datos</h4>
                    <p class="style-body-text light">
                        Implementamos medidas de seguridad adecuadas para proteger sus datos contra accesos no autorizados, divulgación, alteración o destrucción.
                    <br><br>
                </div>
<!-- 6 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">6. Derechos del Titular de los Datos</h4>
                    <p class="style-body-text light">
                        Usted tiene el derecho de acceder, corregir o eliminar sus datos personales. Si desea ejercer alguno de estos derechos, contáctenos a través de la información proporcionada al final de estos términos.
                    <br><br>
                </div>
<!-- 7 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">7. Cambios en la Política</h4>
                    <p class="style-body-text light">
                        Nos reservamos el derecho de actualizar esta política en cualquier momento. Se le notificará sobre cambios significativos a través de los medios de contacto proporcionados durante la reserva.
                    <br><br>
                </div>
<!-- 8 -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">8. Contacto</h4>
                    <p class="style-body-text light">
                        Si tiene preguntas o inquietudes sobre esta política o la gestión de sus datos, comuníquese con nosotros a través de telefono:<span style="font-weight: bold;" >+34633302615</span>, email:<span style="font-weight: bold;" >reservas@cielodecebreros.com</span>. Al hacer una reserva en Hotel El Cielo de Cebreros, acepta estos términos de uso. Gracias por confiar en nosotros.
                    <br><br>
                </div>    
<!-- VIGENCIA  -->
                <div class="col s12 left">
                    <h4 style="margin-top: 10px;" class="title-politic-options">Fecha de entrada en vigencia:</h4>
                    <p class="style-body-text light">
                        10/11/2023
                    </p>  
                    <br><br>
                </div>

            </div>
        </div>    
    </section>


 <!--Import jQuery before materialize.js-->
    @include('components.scripts')

</body>
</html>