<?php

namespace App\Http\Controllers;

use App\Mail\sendInvoiced;
use App\Stock;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the stock dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stocks = Stock::orderby('id', 'desc')->paginate(10);

        return view('home', compact('stocks'));
    }


    /**
     * Create stock items.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'item_name' =>  'required',
            'quantity' => 'required',
            'price' => 'required',
            'payment_mode' => 'required',
        ]);
        
        $pets= Stock::create([
            'item_name'=>$request->get('item_name'),
            'quantity' =>  $request->get('quantity'),
            'price' =>  $request->get('price'),
            'payment_mode' =>  $request->get('payment_mode')
        ]);
        return redirect()->route('home')->with('error', 'Record Created!');
    }

    /**
     * Delete stock items.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id) {
        Stock::find($id)->delete();
        return redirect('home')->with('error', 'Record Deleted!');
    }


     /**
     * Billing items.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function billing()
    {
        $stocks = Stock::orderby('id', 'desc')->pluck('item_name','id');
        return view('billing', compact('stocks'));
    }

    /**
     * Billing Store.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function billingStore(Request $request)
    {
        $this->validate(request(), [
            'stock' =>  'required',
            'quantity' => 'required',
            'price' => 'required',
            'sale_date' => 'required',
            'cust_name' => 'required',
            'email' => 'required',
        ]);

        $stock = null;
        if (isset($request->stock)) {
            try {
                $stock = Stock::find($request->stock);
            } catch (ModelNotFoundException $exception) {
                return back()->withError($exception->getMessage())->withInput();
            }
        }
        if (!$stock) {
            return redirect('billing')->with('error', 'Stock is not avalable!');
        }
        if ($stock->quantity <  $request->quantity){
            return redirect('billing')->with('error', 'Out of stock');
        }
    
        //Generating Mail

        $data = $request->all();
        $pdf = PDF::loadView('pdf.invoice', $data);
        $pdf->save(storage_path('pdf').'_invoice.pdf');

        //Sending Mail

        Mail::to($request->email)->send(new sendInvoiced($data));

        return redirect('home')->with('error', 'Invoice generated and sent mail successfully');
    }
}
