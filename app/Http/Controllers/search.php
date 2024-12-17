<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Carbon\Carbon;




use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\seller;



class search extends Controller
{



    public function buyer_search(Request $post)
{
    $search = $post->input('search');

    if ($search != '') {

        $buyer = buyer::where('company_name','LIKE',"%$search%")->get();

        if (count($buyer) > 0) {
            session()->put('pdf_data', $buyer);
            foreach ($buyer as $index => $data) {
                $newRow = '<tr class="tr-shadow">';
                $newRow .= '<td></td>';
                $newRow .= '<td>' . ($index + 1) . '</td>';
                $newRow .= '<td><a href="/view_single_buyer' . $data->buyer_id . '"><span class="block-email">' . $data->company_name . '</span></a></td>';
                $newRow .= '<td><span class="role member">' . $data->contact_person . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->debit . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->credit . '</span></td>';
                $newRow .= '<td>' . $data->total_records . '</td>';
                $newRow .= '<td>' . $data->buyer_type . '</td>';
                $newRow .= '<td>';
                $newRow .= '<div class="table-data-feature">';
                $newRow .= '<a href="/edit_buyer' . $data->buyer_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">';
                $newRow .= '<i class="fa fa-edit"></i>';
                $newRow .= '</a>';
                $newRow .= '<a href="/view_single_buyer' . $data->buyer_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="View">';
                $newRow .= '<i class="fa fa-light fa-eye"></i>';
                $newRow .= '</a>';
                $newRow .= '</div>';
                $newRow .= '</td>';
                $newRow .= '</tr>';

                $buyer .= $newRow;

                
            }
            

        } else {
            $buyer .= '<tr><td colspan="9">No results found.</td></tr>';
        }
        
        $data = compact('buyer','search');
        return response()->json($data);
    
    }elseif($search == ''){


        $buyer = buyer::all();

        if (count($buyer) > 0) {
            session()->put('pdf_data', $buyer);
            foreach ($buyer as $index => $data) {
                $newRow = '<tr class="tr-shadow">';
                $newRow .= '<td></td>';
                $newRow .= '<td>' . ($index + 1) . '</td>';
                $newRow .= '<td><a href="/view_single_buyer' . $data->buyer_id . '"><span class="block-email">' . $data->company_name . '</span></a></td>';
                $newRow .= '<td><span class="role member">' . $data->contact_person . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->debit . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->credit . '</span></td>';
                $newRow .= '<td>' . $data->total_records . '</td>';
                $newRow .= '<td>' . $data->buyer_type . '</td>';
                $newRow .= '<td>';
                $newRow .= '<div class="table-data-feature">';
                $newRow .= '<a href="/edit_buyer' . $data->buyer_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">';
                $newRow .= '<i class="fa fa-edit"></i>';
                $newRow .= '</a>';
                $newRow .= '<a href="/view_single_buyer' . $data->buyer_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="View">';
                $newRow .= '<i class="fa fa-light fa-eye"></i>';
                $newRow .= '</a>';
                $newRow .= '</div>';
                $newRow .= '</td>';
                $newRow .= '</tr>';

                $buyer .= $newRow;

                
            }
            

        }

        $data = compact('buyer');
        return  response()->json($data);

    }

}





public function seller_search(Request $post)
{
    $search = $post->input('search');

    if ($search != '') {
        $seller = seller::where('company_name', 'LIKE', "%$search%")->limit(15)->get();

        $data = compact('sellerTable', 'search');
        return response()->json($data);
    } else {
        $seller = seller::limit(15)->get();

        if (count($seller) > 0) {
            foreach ($seller as $index => $data) {
                $newRow = '<tr class="tr-shadow">';
                $newRow .= '<td><a href="/view_single_seller' . $data->seller_id . '"><span class="block-email">' . $data->company_name . '</span></a></td>';
                $newRow .= '<td><span class="role member">' . $data->contact_person . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->debit . '</span></td>';
                $newRow .= '<td><span class="status--process">' . $data->credit . '</span></td>';
                $newRow .= '<td>' . $data->total_records . '</td>';
                $newRow .= '<td>' . $data->seller_type . '</td>';
                $newRow .= '<td>';
                $newRow .= '<div class="table-data-feature">';
                $newRow .= '<a href="/edit_seller' . $data->seller_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="Edit">';
                $newRow .= '<i class="fa fa-edit"></i>';
                $newRow .= '</a>';
                $newRow .= '<a href="/view_single_seller' . $data->seller_id . '" class="item" data-bs-toggle="tooltip" data-placement="top" title="View">';
                $newRow .= '<i class="fa fa-light fa-eye"></i>';
                $newRow .= '</a>';
                $newRow .= '</div>';
                $newRow .= '</td>';
                $newRow .= '</tr>';

                $seller .= $newRow;
            }
        }

        $data = compact('sellerTable');
        return response()->json($data);
    }
}

}
