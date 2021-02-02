<?php

namespace App\Exports;

use App\Models\City;
use App\Models\KoodReq;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;


class KoodReqExport implements FromView
{
////    use Exportable;
    private $response;
//
    public function __construct($response)
    {

//        dd($this->response= $response);
        $this->response= $response;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
//        dd($this->response);
//        $employees = KoodReq::query()->get();
//        return view('employee.table', compact('employees'));

        return view('admin.report.reportTable',['response'=>$this->response,$ch=0]);
    }
}
