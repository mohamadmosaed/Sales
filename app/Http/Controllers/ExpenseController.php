<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense=Expense::get();
        $totalAmount = Expense::sum('amount');
        return view('expense.index',compact('expense','totalAmount'));
    }


    public function create()
    {
        return view('expense.create');
    }


    public function store(Request $request)
    {

    $expense=Expense::create([
'date_of_expense'=>$request->date_of_expense,
'category'=>$request->category,
'amount'=>$request->amount,
'description'=>$request->description,
'payment_method'=>$request->payment_method,
'beneficiary'=>$request->beneficiary,
'notes'=>$request->notes,
     ]);
     $expense->save();
     return redirect()->route('expense.index')->with('message','insert is ok');
    }
    public function show(Expense $expense)
    {
        //
    }


    public function edit($id)
    {
        $expense=Expense::findOrFail($id);
        return view('expense.edit',compact('expense'));

    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'date_of_expense' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'payment_method' => 'required|string|max:50',
            'beneficiary' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $expense = Expense::findOrFail($id);
            $expense->update([
                'date_of_expense' => $request->date_of_expense,
                'category' => $request->category,
                'amount' => $request->amount,
                'description' => $request->description,
                'payment_method' => $request->payment_method,
                'beneficiary' => $request->beneficiary,
                'notes' => $request->notes,
            ]);
            return redirect()->route('expense.index')->with('message', 'Expense updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('expense.index')->with('error', 'Failed to update expense. Please try again.');
        }
    }



    public function destroy($id)
    {

DB::table('expenses')->where('id',$id)->delete();
return redirect()->route('expense.index')->with('success','expenses is deleted');

    }
}
