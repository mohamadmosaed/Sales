<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchName;
use App\Models\TypeStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchNameController extends Controller
{

    public function index()
    {
    $branchName=BranchName::get();
    return view('branchName.index',compact('branchName'));
    }


    public function create()
    {
       return view('branchName.create');
    }

    public function store(Request $request)
    {


        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'name.*' => 'required|string|max:255',
            'location.*' => 'required|string|max:255',
        ]);

        // إدخال البيانات في قاعدة البيانات
        foreach ($validatedData['name'] as $index => $brandAr) {
            BranchName::create([
                'name' => $brandAr,
                'location' => $validatedData['location'][$index],
            ]);
        }

        return redirect()->route('branchName.index')->with('success', 'تمت التحويل بنجاح!');
    }




    public function show($id)
    {

         $branch=Branch::where('store_id',$id)->get();

        return view('branchName.show',compact('branch'));
    }


    public function edit($id)
    {
        $branch=BranchName::findOrFail($id);

        return view('branchName.edit',compact('branch'));

    }


    public function update(Request $request, $id)
    {
        $brand = BranchName::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('branchName.index')->with('success', 'تم تحديث الفرع بنجاح');
    }
    public function destroy( $id)
    {
$brand= DB::table('branch_names')->where('id',$id);

$brand->delete();
return redirect()->route('branchName.index')->with('success','branch is deleted ');
  }

}
