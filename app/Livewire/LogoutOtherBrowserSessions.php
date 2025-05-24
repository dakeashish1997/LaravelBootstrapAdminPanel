<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Livewire\Component;
use Livewire\Attributes\On;

class LogoutOtherBrowserSessions extends Component
{
    protected $sessions = [];
    public $password = '';
    public $alert = '';

    public function render()
    {
        $this->sessions = $this->getSessions();
        return view('livewire.logout-other-browser-sessions', ['sessions' => $this->sessions]);
    }

    public function confirmSessionLogout()
    {
        $this->password = '';
        $this->alert = '';
//        $this->dispatch('passwordUpdated');
        $this->js("$('#modal-logout-other-browser-sessions').modal('show');");
    }

    public function logoutOtherSessions()
    {
        if (!Hash::check($this->password, Auth::user()->password)) {
            $this->alert = 'This password does not match our records.';
            return;
        }

        Auth::logoutOtherDevices($this->password);
        $this->deleteOtherSessionRecords();

//        $this->dispatch('otherBrowserSessionsRemoved');
        $this->js("$('#modal-logout-other-browser-sessions').modal('hide');");
    }

    private function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    private function getSessions()
    {
        return DB::table('sessions')
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) {
                return (object)[
                    'agent' => $this->createAgent($session),
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === request()->session()->getId(),
                    'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                ];
            });
    }

    #[On('passwordUpdated')]
    public function deleteOtherSessionRecords()
    {
        DB::table( 'sessions')
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
