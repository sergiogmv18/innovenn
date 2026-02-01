<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Invoice extends Model
{
 
    protected $table = 'invoices';
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var list<string>
     */
    public $fillable = [
        'uuid',
        'status',
        'number',
        'type',
        'creationDate',
        'creationUserUUID',
        'traveluuid',
        'invoiceuuid',
        'comentary',
        'data',
        'totalValue',
        'importValue',
        'taxableBase',
        'methodOfPayment'
    ];

    /**
     * Los atributos que deben ocultarse en la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
    
    ];

    /**
     * Obtener los atributos que deben ser casteados.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'int',
            'uuid' => 'string',
        ];
    }

    /**
     * Validate input and return array whit value
     * 
     * @param Request $request Datos del viaje a guardar.
     * @return array
     */
    public function validateInput(Request $request) {
        try {
            $validatedData = $request->validate([
                'uuid' => 'nullable|string',
                'status'=> 'required|string',
                'number'=> 'required|numeric',
                'type'=> 'required|string',
                'creationDate'=> 'required|string',
                'creationUserUUID'=> 'required|string',
                'traveluuid'=> 'nullable|string',
                'invoiceuuid'=> 'nullable|string',
                'comentary'=> 'nullable|string',
                'data'=> 'required|string',
                'totalValue' => 'required|numeric',
                'importValue' => 'required|numeric',
                'taxableBase' => 'required|numeric',
                'methodOfPayment'=>'required|string',
            ]);

            return [
                'success' => true,
                'value'=> $validatedData,
            ];

        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors()
            ];
        }
    }

    /**
     * Get all Invoice
     * 
     * 
     * @return
     */
    public function getAll(){
        return $this::orderBy('id', 'desc')->get();
    }

     /**
     * Get Specific travel
     * @param string $uuid
     * @return Invoice|null if uuid no exist
     */
    public function getSpecificInvoice(string $uuid) {
        if (empty($uuid)) {
            return null;
        }
        // Buscar el usuario por nombre
        $invoice = $this::where('uuid', $uuid)->first();
        if ($invoice) {
            return $invoice;
        }
    
        return null;
    }

     /**
     * Get Specific travel
     * @param string $uuid
     * @return integer
     */
    public function getMaxNumber() {
        // Obtener el último registro ordenado por el número de factura en orden descendente
        $lastInvoice = $this::orderBy('number', 'desc')->first();
    
        // Si hay un registro, retornar el siguiente número
        if ($lastInvoice) {
            return $lastInvoice->number + 1;
        }
        // Si no hay registros, comenzar desde el número 1
        return 90;
    }

     /**
     * Get Date Of Creation Format
     * 
     * 
     * @return
     */
    public function getFromFormat(){
        $date = \DateTime::createFromFormat('Y-m-d', $this->creationDate);

        if ($date) {
            return $date->format('d/m/Y');
        } else {
            return " "; // O cualquier otro valor por defecto
        }
    }
    /**
     * Get travel relate with invoice
     * 
     * 
     * @return
     */
    public function getTravelRelate(){
        $travel = new Travel();
        if($this->traveluuid != null){
            return $travel->getSpecificTravel(uuid: $this->traveluuid);
        }
        return null;
        
    }

/**
     * Get sum total of all invoice
     * 
     * 
     * @return
     */
    public function getTotalValueSum() {
        // $travel = new Travel();
        return $this->sum('totalValue');
    }

    /**
     * Get total invoice value for the current year
     * 
     * @return float
     */
    public function getTotalValueForCurrentYear() {
        return $this->whereYear('creationDate', date('Y'))->sum('totalValue');
    }

    /**
     * Get total invoice value per month for the current year
     * 
     * @return array
     */
    public function getTotalInvoiceValuePerMonth() {
        $invoice = new Invoice();
        
        // Consulta para obtener el total de las facturas agrupadas por mes
        $results = $invoice->selectRaw('DATE_FORMAT(creationDate, "%m") as month, SUM(totalValue) as total')
                        ->whereYear('creationDate', date('Y')) // Filtrar solo el año actual
                        ->groupBy('month')
                        ->orderBy('month', 'asc')
                        ->get();

        // Inicializar el array con todos los meses en 0
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = [str_pad($i, 2, '0', STR_PAD_LEFT), 0];
        }

        // Rellenar con los resultados obtenidos
        foreach ($results as $result) {
            foreach ($data as &$row) {
                if ($row[0] == $result->month) {
                    $row[1] = (float)$result->total; // Sumar los valores de totalValue
                }
            }
        }

        return $data;
    }



         /**
    * Get type of relation with invoice
    * @author SGV
    * @version 1.0 - 20230215 - initial release
    * @return <view>
    **/
    public function getNumberOfRelationWithinvoice(){
        if($this->type == 'Abonadas'){
            $invoiceWk  =  $this->getSpecificInvoice($this->invoiceuuid);
            return  '( Abonada de '.$invoiceWk->number.')';
        }
        return '';
    }

    

}
