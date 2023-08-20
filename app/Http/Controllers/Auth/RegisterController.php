<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\EventGuest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user->hasRole(Role::findByName('user'))) {
            return route('gallery');
        }

        return RouteServiceProvider::HOME;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {

        $user = User::where('email', $data['email'])->first();
        
        if(!$user){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
    
            // Assign the default role to the user
            $role = Role::where('name', 'user')->first();
            $user->assignRole($role);
        }

        $event = Event::where('invitaion_key', $data['invitation_key'])->first();

        if($event){
            $guest = new EventGuest();
            $guest->event_id = $event->id;
            $guest->guest_id = $user->id;
            $guest->save();
        }



        return $user;
    }
}
