<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\Setting;
use App\Models\SmtpSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Check if the user has the "super-admin" role
        if ($user->hasRole('super-admin')) {
            $users = User::all()->count();
            $invitations = Invitation::all()->count();
            $events = Event::all()->count();
            return view('home', compact('users', 'invitations', 'events'));
        } else {
            return abort(403, 'Unauthorized');
        }
        ;
    }

    public function settingUpdate(Request $request)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fav_icon' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = Setting::firstOrNew(['id' => 1]);

        // Delete old images if they exist and new images are provided
        if ($request->hasFile('logo') && $settings->logo && Storage::exists($settings->logo)) {
            Storage::delete($settings->logo);
        }

        if ($request->hasFile('fav_icon') && $settings->fav_icon && Storage::exists($settings->fav_icon)) {
            Storage::delete($settings->fav_icon);
        }

        // Upload and save new images
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public');
            $settings->logo = $logoPath;
        }

        if ($request->hasFile('fav_icon')) {
            $favIconPath = $request->file('fav_icon')->store('public');
            $settings->fav_icon = $favIconPath;
        }

        $settings->save();

        return redirect()
            ->back()
            ->withSuccess(__('crud.common.update'));


    }

    public function smtpSetting(){
        $smtpConfiguration = SmtpSetting::findOrFail(1);
        return view('app.settings.smtp-setting', compact('smtpConfiguration'));
    }

    public function smtpUpdate(Request $request)
{
    $request->validate([
        'host' => 'required',
        'port' => 'required|numeric',
        'username' => 'required',
        'password' => 'required',
        'encryption' => 'required',
    ]);

    // Retrieve the existing record or create a new instance
    $smtpConfiguration = SmtpSetting::firstOrNew(['id' => 1]);

    // Update the attributes of the record
    $smtpConfiguration->fill([
        'host' => $request->host,
        'port' => $request->port,
        'username' => $request->username,
        'password' => $request->password,
        'encryption' => $request->encryption,
    ]);

    // Save the record
    $smtpConfiguration->save();

    return redirect()
        ->back()
        ->withSuccess(__('crud.common.update'));
}

}
