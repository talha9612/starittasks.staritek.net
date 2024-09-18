<?php

namespace App\Http\Controllers;

use App\User;
use App\ThemeSetting;
use App\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function AddCompanyInfo(Request $request)
    {
        // Retrieve the confirmation code from the session
        $sessionConCode = $request->session()->get('confirmation_code');

        // Check if the provided code matches the session code
        if ($request->con_code == $sessionConCode) {
            $user = new User();
            $user->name = $request->name;
            //dd($request->email);
            $user->email = $request->email;
            $user->phone = $request->c_phone;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->department = 1;
            $user->skill = 1;
            $user->gender = 1;
            $user->user_type = 0;
            $user->team_member = 0;
            $user->image = 'default.jpg';
            $user->save();

            $users = User::where('id', $user->id)->first();
            $users->user_type = $user->id;
            $users->team_member = $user->id;
            $users->save();

            // For Theme Setting
            $theme = new ThemeSetting();
            $theme->user_id = $user->id;
            $theme->theme_mode = 0;
            $theme->save();
            // Theme Setting End //

            $setting = new CompanySetting();
            $setting->name = $request->c_name;
            $setting->email = $request->email;
            $setting->address = $request->address;
            $setting->phone = $request->c_phone;
            $setting->logo = $request->c_image;
            $setting->user_id = $user->id;
            if ($request->hasFile('c_image')) {
                $avatar = $request->file('c_image');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(100, 100)->save(public_path('/uploads/company_logos/' . $filename));
                $setting->logo = $filename;
                $setting->save();
            }
            $setting->save();
            return redirect('/login/');
        } else {
            return redirect()->back()->with('error', 'Your Confirmation Code is Not Correct!');
        }
    }

    public function RegisterCompany()
    {
        return view('welcome');
    }

    public function ForLogin(Request $req)
    {
        return view('login');
    }

    public function CheckEmail(Request $req)
    {

        $email = $req->input('email');
        $exists = User::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function generateConfirmationCode(Request $request)
    {
        $email = $request->input('email');

        // Check if the email already exists
        $exists = User::where('email', $email)->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Email already exists.']);
        }
        Log::info('Request data:', $request->all());
        // Generate a unique confirmation code
        $confirmationCode = Str::random(8);
        $request->session()->put('confirmation_code', $confirmationCode);

        try {
            // Send the code to the developer's email
            Mail::raw(
                "A confirmation code has been generated for the company \"{$request->company_name}\". The code is: {$confirmationCode}. Company Email: {$request->email}. Person who is registering the company: {$request->admin_name}. Company Phone Number: {$request->c_phone}. Company address: {$request->address}",
                function ($message) use ($request) {
                    $message->to($request->dev_email)
                        ->subject('Confirmation Code Generated by Admin');
                }
            );

            // Return the generated code as a response
            return response()->json(['success' => true, 'code' => $confirmationCode]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send email.']);
        }
    }
}
