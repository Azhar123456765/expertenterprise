<?php

namespace App\Http\Controllers;

use App\Models\buyer;
use App\Models\SaleInvoice;
use App\Models\products;
use App\Models\sales_officer;
use Illuminate\Support\Facades\DB;
use App\Models\users;
use Illuminate\Http\Request;

class SaleInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = SaleInvoice::whereIn('sale_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('sale_invoices')
                ->groupBy('unique_id');
        })->count();

        $data = compact('count');
        return view('invoice.sale_invoice')->with($data);
    }
    public function create_first(Request $request)
    {
        $invoice = SaleInvoice::where('unique_id', 1)->get();
        $single_invoice = SaleInvoice::where('unique_id', 1)->first();
        if (count($invoice) > 0) {
            return view('invoice.edit_sale_invoice', compact('invoice', 'single_invoice'));
        } else {
            $count = SaleInvoice::grouped()->count();
            if ($count == 0) {
                $data = compact('count');
                return view('invoice.sale_invoice')->with($data);
            } else {
                session()->flash('something_error', 'Invoice Not Found');
                return redirect()->back();
            }
        }
    }

    public function create_last(Request $request)
    {
        $count = SaleInvoice::whereIn('sale_invoices.id', function ($query2) {
            $query2->select(DB::raw('MIN(id)'))
                ->from('sale_invoices')
                ->groupBy('unique_id');
        })->count();

        $invoice = SaleInvoice::where('unique_id', $count)->get();
        $single_invoice = SaleInvoice::where('unique_id', $count)->first();
        if (count($invoice) > 0) {
            return view('invoice.edit_sale_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = session()->get('user_id')['user_id'];
        users::where("user_id", $user_id)->update([
            'no_records' => DB::raw("no_records + " . 1)
        ]);
        // $income = new Income;
        // $income->category_id = $request['unique_id'];
        // $income->category = 'Chick Invoice';
        // $income->amount = $request['amount_paid'];
        // $income->save(); 
        // $array = $request['amount'];
        // $filteredArray = array_filter($array, function ($value) {
        //     return $value > 0;
        // });

        $arrayLength = count(array_filter($request['item']));

        for ($i = 0; $i < $arrayLength; $i++) {

            $invoice = new SaleInvoice;

            $invoice->unique_id = $request['unique_id'] ?? 000;
            $invoice->user_id = $user_id;
            $invoice->item = $request['item']["$i"];
            $invoice->unit = $request['unit']["$i"];
            $invoice->date = $request['date'] ?? 000;

            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->remark = $request['remark'] ?? null;

            $invoice->price = $request['price']["$i"] ?? 000;
            $invoice->qty = $request['qty']["$i"] ?? 000;
            $invoice->discount = $request['discount']["$i"] ?? 000;
            $invoice->amount = $request['amount']["$i"] ?? 000;

            $invoice->qty_total = $request['qty_total'] ?? 000;
            $invoice->discount = $request['discount'] ?? 000;
            $invoice->cash_receive = $request['cash_receive'] ?? 000;
            $invoice->cash_receive_account = $request['cash_receive_account'] ?? 000;
            $invoice->remaining_balance = $request['remaining_balance'] ?? 000;
            $invoice->amount_total = $request['amount_total'] ?? 000;

            $invoice->pr_item = $request['item']["$i"] ?? 000;
            $invoice->pr_qty = $request['qty']["$i"] ?? 000;
            $invoice->pr_remaining_balance = $request['remaining_balance']["$i"] ?? 000;

            $image = $request->file('attachment');
            if ($image) {
                $attachmentPath = $image->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment');
            }

            $invoice->attachment = $attachmentPath;

            $invoice->save();

            $SaleInvoice = SaleInvoice::where('unique_id', $request['unique_id'])
                ->where('item', $request['item']["$i"])
                ->first();

            if ($SaleInvoice) {
                $product = $SaleInvoice->product;
                $productUnit = $product->unit; // The unit stored in the database for the product
                $invoiceUnit = $request['unit']["$i"]; // The unit selected by the user in the invoice
                $qty = $request['qty']["$i"]; // The quantity entered in the invoice

                $unitRatios = [
                    'inch' => 1,          // Base unit
                    'foot' => 12,         // 1 foot = 12 inches
                    'yard' => 36,         // 1 yard = 36 inches
                    'meter' => 39.3701,   // 1 meter = ~39.37 inches
                    'gaz' => 36,          // Example, 1 gaz = 36 inches (adjust if needed)
                ];

                // Check if both product and invoice units are defined in the conversion table
                if (isset($unitRatios[$productUnit]) && isset($unitRatios[$invoiceUnit])) {
                    // Convert the quantity from the invoice unit to the product's stored unit
                    $qtyInBaseUnit = $qty * ($unitRatios[$invoiceUnit] / $unitRatios[$productUnit]);
                    // Update the product's opening quantity in the database
                    products::where("product_id", $request['item']["$i"])->update([
                        'opening_quantity' => DB::raw("opening_quantity - " . $qtyInBaseUnit)
                    ]);
                }

            }


        }

        $data = 'Invoices added successfully!';
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $SaleInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(SaleInvoice $SaleInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleInvoice  $SaleInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $invoice = SaleInvoice::where('unique_id', $id)->get();
        $single_invoice = SaleInvoice::where('unique_id', $id)->first();
        if (count($invoice) > 0) {
            return view('invoice.edit_sale_invoice', compact('invoice', 'single_invoice'));
        } else {
            session()->flash('something_error', 'Invoice Not Found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleInvoice  $SaleInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user_id = session()->get('user_id')['user_id'];
        SaleInvoice::where('unique_id', $id)->delete();
        // users::where("user_id", $user_id)->update([
        //     'no_records' => DB::raw("no_records + " . 1)
        // ]);
        // $income = new Income;
        // $income->category_id = $request['unique_id'];
        // $income->category = 'Chick Invoice';
        // $income->amount = $request['amount_paid'];
        // $income->save(); 
        // $array = $request['amount'];
        // $filteredArray = array_filter($array, function ($value) {
        //     return $value > 0;
        // });

        $arrayLength = count(array_filter($request['item']));

        for ($i = 0; $i < $arrayLength; $i++) {
            $invoice = new SaleInvoice;
        
            // Assign common fields
            $invoice->unique_id = $request['unique_id'] ?? '000';
            $invoice->user_id = $user_id;
            $invoice->item = $request['item'][$i];
            $invoice->unit = $request['unit'][$i];
            $invoice->date = $request['date'] ?? now(); // Use current date if not provided
        
            $invoice->buyer = $request['buyer'];
            $invoice->sales_officer = $request['sales_officer'] ?? null;
            $invoice->remark = $request['remark'] ?? null;
        
            // Sanitize numeric inputs
            $invoice->price = is_numeric($request['price'][$i]) ? $request['price'][$i] : 0;
            $invoice->qty = is_numeric($request['qty'][$i]) ? $request['qty'][$i] : 0;
            $invoice->discount = is_numeric($request['discount'][$i]) ? $request['discount'][$i] : 0;
            $invoice->amount = is_numeric($request['amount'][$i]) ? $request['amount'][$i] : 0;
        
            $invoice->qty_total = is_numeric($request['qty_total']) ? $request['qty_total'] : 0;
            $invoice->cash_receive = is_numeric($request['cash_receive']) ? $request['cash_receive'] : 0;
            $invoice->cash_receive_account = is_numeric($request['cash_receive_account']) ? $request['cash_receive_account'] : 0;
            $invoice->remaining_balance = is_numeric($request['remaining_balance']) ? $request['remaining_balance'] : 0;
            $invoice->amount_total = is_numeric($request['amount_total']) ? $request['amount_total'] : 0;
        
            $invoice->pr_item = $request['pr_item'][$i] ?? null;
            $invoice->pr_qty = is_numeric($request['pr_qty'][$i]) ? $request['pr_qty'][$i] : 0;
            $invoice->pr_remaining_balance = is_numeric($request['pr_remaining_balance'][$i]) ? $request['pr_remaining_balance'][$i] : 0;
        
            // Handle attachments
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('attachments');
            } else {
                $attachmentPath = $request->input('old_attachment', null);
            }
            $invoice->attachment = $attachmentPath;
        
            // Save the invoice
            $invoice->save();
        
            // Update product stock
            $SaleInvoice = SaleInvoice::where('unique_id', $request['unique_id'])
                ->where('item', $request['item'][$i])
                ->first();
        
            if ($SaleInvoice) {
                $product = $SaleInvoice->product;
                $productUnit = $product->unit; // Stored unit
                $invoiceUnit = $request['unit'][$i]; // Invoice unit
                $qty = $request['qty'][$i]; // Quantity
        
                $unitRatios = [
                    'inch' => 1,
                    'foot' => 12,
                    'yard' => 36,
                    'meter' => 39.3701,
                    'gaz' => 36,
                ];
        
                if (isset($unitRatios[$productUnit]) && isset($unitRatios[$invoiceUnit])) {
                    $qtyInBaseUnit = $qty * ($unitRatios[$invoiceUnit] / $unitRatios[$productUnit]);
        
                    products::where('product_id', $request['item'][$i])->update([
                        'opening_quantity' => DB::raw("opening_quantity - " . $qtyInBaseUnit)
                    ]);
                }
            }
        }

        $data = 'Invoices Updated successfully!';
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleInvoice  $SaleInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleInvoice $SaleInvoice)
    {
        //
    }
}
