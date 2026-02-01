@extends('main')

@section('showSearch', false)

@section('title', 'Inicio')

@section('content')

      <!-- Section: Stats -->
  <section class="section section-stats center">
    <div class="row center">
<!-- TOTAL OF USER -->
      <div class="col s12 m4 l4" style="max-height: 19em; height: 19em;">
        <div class="card-panel center white lighten-1 black-text" style="height: -webkit-fill-available; border-radius: var(--border-radius); border-radius: var(--border-radius);">
          <i class="fa-solid fa-users blue-text medium"></i>
          <h5>Total Usuarios</h5>
          <h3 class="count">{{ $userRelatedWithHotel }}</h3>
        </div>
      </div>
<!-- CHECKING TODAY -->
      <div class="col s12 m4 l4" style="max-height: 19em; height: 19em;">
        <div class="card-panel center white lighten-1 black-text" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
          <i class="fa-solid fa-person-circle-check blue-text medium"></i>
          <h5 class>Check-in - {{  date("d/m/Y") }}</h5>
          <h3 class="count">3</h3>
        </div>
      </div>
<!-- COMPARATIONS OF AFTER MOST WHIT CURRENT MOST -->
      <div class="col s12 m4 l4" style="max-height: 19em; height: 19em;">
        <div class="card-panel center  white lighten-1 black-text" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
          <i class="fa-solid fa-euro-sign blue-text medium"></i>
          <h5 style="margin: 0em;">Ventas ↑100% comparado con Diciembre</h5>
            <!-- <small> -->
              <h6>Mes actual: €{{ number_format( 454.20, 2) }}<br>
              Mes anterior: €{{ number_format(0.00, 2) }}</h6>
            <!-- </small> -->
        </div>
      </div>
      <div class="col s12 m4 l4" style="max-height: 19em; height: 19em;">
        <div class="card-panel center  blue lighten-1 white-text" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
          <i class="material-icons medium">assignment_ind</i>
          <h5>Total Registros {{  date("Y") }}</h5>
          <h3 class="count">{{$allRegisteredCurrentYear}}</h3>
        </div>
      </div>
      <div class="col s12 m8 l8" style="max-height: 19em; height: 19em;">
        <div class="card-panel" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
            <div id="chart_div" style=" width: 100%;" ></div>
        </div>
      </div>
      <div class="col s12 m4 l4" style="max-height: 19em; height: 19em;">
        <div class="card-panel blue lighten-1 white-text center" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
          <i class="material-icons medium">attach_money</i>
          <h5>total facturado {{  date("Y") }}</h5>
          <div style="display: flex; margin-top: -1.2em; justify-content: center;">
            <h3>€</h3><h3 class="count">{{ $totalSellAnual}}</h3>
          </div> 
          <!-- <div class="progress grey lighten-1">
            <div class="determinate white" style="width: 100%;"></div>
          </div> -->
        </div>
      </div>
      <div class="col s12 m8 l8" style="max-height: 19em; height: 19em;">
        <div class="card-panel" style="height: -webkit-fill-available; border-radius: var(--border-radius);">
            <div id="chart_div_invoice-total" style=" width: 100%;"></div>
        </div>
      </div>


    </div>
  </section>

  <!-- Section: Visitor -->
  <!-- <section class="section section-visitors blue lighten-4">
    <div class="row">
      <div class="col s12 m12 l12">
        <div class="card-panel">
            <div id="chart_div" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col s12 m12 l12">
        <div class="card-panel">
            <div id="chart_div_invoice-total" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
    </div>
  </section> -->


@endsection

@push('scripts')
    <script>
      $(document).ready(function () {
        // Animation counter
        $('.count').each(function () {
          $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
          }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
              $(this).text(Math.ceil(now));
            }
          });
        });
      }); 
      var totalInvoiceValuePerMonth = `{{ json_encode($totalInvoiceValuePerMonth) }}`;
      totalInvoiceValuePerMonth = totalInvoiceValuePerMonth.replace(/&quot;/g, '"'); // Reemplaza &quot; por "
      totalInvoiceValuePerMonth = JSON.parse(totalInvoiceValuePerMonth);

      var betsSellingRooms = `{{ json_encode($betsSellingRooms) }}`;
    betsSellingRooms = betsSellingRooms.replace(/&quot;/g, '"'); // Reemplaza &quot; por "
    betsSellingRooms = JSON.parse(betsSellingRooms); // Convierte a un array de objetos de JS
    
    document.addEventListener('DOMContentLoaded', function() {
     // CHART TO ROOMS  
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(bestSellingRooms);
    
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(totalInvoiceToMoth);
    }); 

    function bestSellingRooms() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mes');
      data.addColumn('number', 'Registros');
      data.addRows(
        betsSellingRooms
      );

      var options = {
        title: 'Total de registros del año',
        hAxis: {
          title: 'Meses',
          // format: 'h:mm a',
           viewWindow: {
            min: [800, 30, 0],
            max: [17, 30, 0]
           }
        },
        vAxis: {
          title: 'Cantidad de registros'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }

    function totalInvoiceToMoth() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Mes');
      data.addColumn('number', 'factuación');
      data.addRows(
        totalInvoiceValuePerMonth
      );

      var options = {
        title: 'Total de factuación anual',
        hAxis: {
          title: 'Meses',
          // format: 'h:mm a',
           viewWindow: {
            min: [800, 30, 0],
            max: [17, 30, 0]
           }
        },
        vAxis: {
          title: 'Cantidad de factuación'
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div_invoice-total'));
      chart.draw(data, options);
    }




   
    </script>
@endpush
