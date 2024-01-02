<?php

namespace App\Http\Controllers;
use App\Models\Vesture;

use Illuminate\Http\Request;

class VestureController extends Controller
{
    public function GetAll()
    {
        

        // Order by created_at in descending order
        $vesture = Vesture::orderBy('id', 'asc')->get();
        $startDate = Vesture::min('date');
        $endDate = Vesture::max('date');

        return view('pages.darbibuvesture', compact('vesture', 'startDate', 'endDate'));
    }
    public function filterByDate(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (empty($endDate)) {
        $endDate = $startDate;
    }

       
        $vesture = Vesture::whereBetween('date', [$startDate, $endDate])
        ->orderBy('id', 'desc')
        ->get();
        
        // Pass $vesture and other necessary data to your view
        return view('pages.darbibuvesture', compact('vesture','startDate','endDate'));
    }

}
