<?php

namespace App\Http\Controllers\Agency\Auth;

use App\Http\Controllers\Controller;
use App\Models\AgencyProfile;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:30'],
            'company_name' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'company_name' => $data['company_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_AGENCY,
            'user_type' => User::ROLE_AGENCY,
            'status' => User::STATUS_ACTIVE,
            'verification_status' => true,
        ]);

        AgencyProfile::create([
            'user_id' => $user->id,
            'company_name' => $data['company_name'],
            'contact_person' => $data['name'],
            'phone' => $data['mobile'],
            'website' => $data['website'] ?? null,
        ]);

        if (\App\Models\Role::query()->whereKey(2)->exists()) {
            $user->roles()->sync([2]);
        }

        return $user;
    }

    public function showRegistrationForm()
    {
        return view('agency.auth.register');
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->route('verification.notice')->with('message', 'Registration successful. Please verify your email.');
    }
}
