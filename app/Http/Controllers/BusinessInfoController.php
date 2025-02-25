<?php

namespace App\Http\Controllers;

use App\Models\BusinessInfo;
use Illuminate\Http\Request;

class BusinessInfoController extends Controller
{

    public function index()
    {
        $setting=BusinessInfo::get();
        return view('businessInfo.index',compact('setting'));
    }
    public function create()
    {

        return view('businessInfo.create');
    }

    public function store(Request $request)
    {


        $user = auth()->user(); // Get the current logged-in user
        $subscription_id = $user->subscription_id; // Access the subscription_id



       /* $request->validate([
            'name' => 'required|string|max:255|unique:business_infos,name',
            'landmark' => 'required|numeric|unique:business_infos,landmark',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'country_en' => 'required|string',
            'state_en' => 'required|string',
            'city_en' => 'required|string',
            'zip_code_en' => 'required|numeric',
            'mobile' => 'required|numeric|digits_between:10,15',
            'alternate_number' => 'nullable|numeric|digits_between:10,15',
            'email' => 'required|email|unique:business_infos,email',
            'website' => 'nullable',
        ]);

*/
     try {

            $businessInfo = new BusinessInfo([
                'business_id' =>  $subscription_id,
                'name' => $request->input('name'),
                'landmark' => $request->input('landmark'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'name_en' => $request->input('name_en'),
                'country_en' => $request->input('country_en'),
                'state_en' => $request->input('state_en'),
                'city_en' => $request->input('city_en'),
                'zip_code_en' => $request->input('zip_code_en'),
                'mobile' => $request->input('mobile'),
                'alternate_number' => $request->input('alternate_number'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
            ]);


            $businessInfo->save();


            return redirect()->route('businesssettings.index')->with('success', 'Setting inserted successfully');

        } catch (\Exception $e) {

            \Log::error("Error storing business info: " . $e->getMessage());


           return redirect()->route('businesssettings.index')->with('error', 'An error occurred while saving the settings. Please try again.');
        }
    }

    public function show(BusinessInfo $businessInfo)
    {
        //
    }


    public function edit(BusinessInfo $businessInfo)
    {
        //
    }


    public function update(Request $request, BusinessInfo $businessInfo)
    {
        //
    }
    public function destroy(BusinessInfo $businessInfo)
    {
        //
    }
}
