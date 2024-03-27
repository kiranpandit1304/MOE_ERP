<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\SellersImport;
//use App\Models\SellersExport;
use PDF;
use Excel;
use Auth;

class SellerBulkUploadController extends Controller
{
    public function __construct() {

        $this->middleware(['permission:seller_bulk_import'])->only('index');
        //$this->middleware(['permission:seller_bulk_export'])->only('export');
    }

    public function index()
    {
        if (Auth::user()->user_type == 'admin') {
            return view('backend.sellers.bulk_upload.index');
        }
    }

    // public function export(){
    //     return Excel::download(new SellersExport, 'sellers.xlsx');
    // }

    public function bulk_upload(Request $request)
    {
        if($request->hasFile('bulk_file')){
            $import = new SellersImport;
            Excel::import($import, request()->file('bulk_file'));
        }
        
        return back();
    }

}
