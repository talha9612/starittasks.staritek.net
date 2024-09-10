<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class register_new_company extends Controller
{
    public function showRegisterNewCompanyForm(Request $request)
    {
       // dd($request->file('c_image'));
        // Handle file upload
       // dd($request->all());
        if ($request->hasFile('c_image')) {
            $avatar = $request->file('c_image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(100, 100)->save(public_path('/uploads/company_logos/' . $filename));
            $companyLogoPath = 'uploads/company_logos/' . $filename;
        } else {
            $companyLogoPath = null;
        }

        // Return the register_new_company view with all request data
        return view('register_new_company')->with([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'c_name' => $request->input('c_name'),
            'c_phone' => $request->input('c_phone'),
            'address' => $request->input('address'),
            'c_image' => $companyLogoPath,  // Pass the stored file path
        ]);
    }
}
