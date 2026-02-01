@extends('main')
@section('showSearch', false)

@section('title', 'Factura')
@section('content')
<section class="section section-stats center">
        <div class="container">
            <div id="contentPDF" class="row">  
                <div class="col s2 m2 l2 lx2">
                    <img  style="width: 100%;" src="{{ asset('storage/'.$billingData?->photoPath)  }}">
                </div>
                <div class="col s5 m5 l5 lx5">
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                        {{ $billingData?->name}}
                    </p> 
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                        {{ $billingData?->getAddress(isArray:false)}}
                    </p> 
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                        {{ $billingData?->postalCode}}
                    </p> 
                    <!-- <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                        Antonio Ruíz Muñoz
                    </p>  -->
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                        {{ $billingData?->typeBillingData.' '.$billingData?->documentNumber}}
                    </p> 
                </div>
                <div class="col s5 m5 l5 lx5">
                    <p style=" margin-block-end: 0em; line-height: 1rem; text-align: start;">
                      Facturas {{$invoiceWk->type}} : {{$invoiceWk->number}}
                    </p> 
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                      Forma de pago: {{$invoiceWk->methodOfPayment}}
                    </p> 
                    <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                      Fecha: {{$invoiceWk->getFromFormat()}}
                    </p> 
                    @if ($invoiceWk->traveluuid != null)
<!-- VERIFICAR QUE NO QUIERE FACTURA -->
                        @if (!$invoiceWk->getTravelRelate()->travelFatureData)
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                                {{$invoiceWk->getTravelRelate()->firstName}}  {{$invoiceWk->getTravelRelate()->subName}}
                            </p> 
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                                {{$invoiceWk->getTravelRelate()->contact}}
                            </p> 
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                                {{$invoiceWk->getTravelRelate()->formatAddress()}}, {{$invoiceWk->getTravelRelate()->postalCode}} 
                            </p> 
                        @endif
                        @if (!$invoiceWk->getTravelRelate()->usePersonalDataInInvoice)
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                                {{$invoiceWk->getTravelRelate()->nameResponsibleToBilling}}
                            </p> 
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                            {{$invoiceWk->getTravelRelate()->typeOfEntity == "PJ"? "CIF":"NIF"}}, {{$invoiceWk->getTravelRelate()->documentOfEntity}}
                            </p> 
                            <p style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem; text-align: start;">
                                {{$invoiceWk->getTravelRelate()->formatAddressBilling()}}, {{$invoiceWk->getTravelRelate()->postalCodeOfFacture}} 
                            </p> 
                        @endif
                    @endif
                </div>
                <div class="col s12 m12 l12 lx12" style="height:3em;"></div>
                <table  class="centered">
                    <thead>
                        <tr style="background-color: gainsboro; border: 1px solid;">
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Dto</th>
                            <th>Total Dto</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="border: 1px solid;">
                        @foreach (json_decode( $invoiceWk->data, true) as $service)
                            <tr style="border-bottom: 1px solid #fff;">
                                <td>{{$service['descripcion'] }}</td>
                                <td>{{$service['cantidad'] }}</td>
                                <td>{{$service['precio'] }}€</td>
                                <td>{{empty($service['descuento']) ?$service['descuento'] :$service['descuento'].'%'  }}</td>
                                <td>{{empty($service['total_descuento']) ? $service['total_descuento'] : $service['total_descuento'].'€'  }}</td>
                                <td>{{$service['total'] }}€</td>
                            </tr>
                        @endforeach
                        <tr style="border-bottom: 1px solid;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col s12 m12 l12 lx12" style="height:1em;"></div>
                <table  class="centered">
                    <thead>
                        <tr style="background-color: white; border: 1px solid;">
                            <th>Impuesto</th>
                            <th>B.I</th>
                            <th>Importe</th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="border: 1px solid;">
                        <tr style="border-bottom: none;">
                            <td>10% IVA</td>
                            <td>{{ $invoiceWk->taxableBase }}€</td>
                            <td>{{$invoiceWk->importValue }}€</td>
                            <td></td>
                            <td></td>
                            <td>{{$invoiceWk->totalValue }}€</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col s12 m12 l12 lx12" style="height:1em;"></div>
                <div class="col s12 m12 l12 lx12">
                    <p class="center" style="margin-block-start: 0.5em; margin-block-end: 0em; line-height: 1rem;">
                    {{ $billingData?->footer}} 
                    </p> 
                </div>
            </div>
            <a class="btn waves-effect waves-light button"  onclick="showIvoice()" style="background-color: var(--color-button);">Descargar
                <i class="material-icons right">unarchive</i>
            </a>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> 
    <script>
     function showIvoice(){
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            html2canvas(document.getElementById('contentPDF')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                doc.addImage(imgData, 'PNG', 10, 10, 190, 0);
                doc.save('factura-{{$invoiceWk->number}}.pdf');
            });
        }
    </script>
@endpush