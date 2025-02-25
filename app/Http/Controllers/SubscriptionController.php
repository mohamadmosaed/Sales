<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{

    public function index()
    {
        $business=Subscription::all();
      return view('subscription.index',compact('business'));
    }
    public function create()
    {
        return view('subscription.create');
    }

    public function store(Request $request)
    {



        Subscription::create([
            'name' => $request->input('name'),
            'tax_number_1' => $request->input('tax_number_1'),
            'tax_number_2' => $request->input('tax_number_2'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);


        return redirect()->route('subscrpition.index')->with('success', 'Data successfully inserted!');
    }
    public function show()
    {
        //
    }
    public function edit($id)
    {
        $business=Subscription::findOrFail($id);
        return view('subscrpition.edit',compact('business'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'tax_number_1' => 'required|string|max:255',
            'tax_number_2' => 'required|string|max:50',
        ]);
        try {

            $expense = Subscription::findOrFail($id);
            $expense->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'tax_number_2' => $request->tax_number_2,
                'tax_number_1' => $request->tax_number_1,
            ]);
            return redirect()->route('subscrpition
            .index')->with('message', 'subscription
             updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('subscrpition
            .index')->with('error', 'Expense not found.');
        } catch (\Exception $e) {
            return redirect()->route('subscrpition
            .index')->with('error', 'Failed to update expense. Please try again.');
        }
    }
    public function destroy($id)
    {
        DB::table('subscriptions')->where('id',$id)->delete();
        return redirect()->route('subscrpition.index')->with('success', 'Data successfully deleted!');

    }
}
