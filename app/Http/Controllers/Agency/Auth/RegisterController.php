<?php

namespace App\Http\Controllers\Agency\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewAgencyRegistrationNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'mobile' => ['nullable', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'agency',
            'verification_status' => false,
        ]);
    }

    public function showRegistrationForm()
    {
        return view('agency.auth.register');
    }

    protected function registered(Request $request, $user)
    {
        $adminUsers = User::query()
            ->where(function ($query) {
                $query->where('user_type', 'admin')
                    ->orWhereHas('roles', function ($roleQuery) {
                        $roleQuery->whereIn('title', ['Admin', 'admin']);
                    });
            })
            ->get();

        foreach ($adminUsers as $adminUser) {
            $adminUser->notify(new NewAgencyRegistrationNotification($user));
        }

        Auth::logout();

        return redirect()->route('login')->with('message', trans('global.yourAccountNeedsAdminApproval'));
    }
}
