<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ipasums;
class PrintController extends Controller
{
      public function index()
      {
            $students = Ipasums::all();
            return view('printstudent')->with('students', $students);;
      }
      public function prnpriview()
      {
            $students = Ipasums::all();
            return view('students')->with('students', $students);;
      }
}
