<?php
namespace App\Livewire\Settings;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class assignFakultas extends Component
{
    public $faculty;
    public $faculties = [];

    public function mount()
    {
        $this->faculties = $this->getEnumValues('users', 'faculty');

        // Load current user's faculty
        $this->faculty = Auth::user()->faculty;
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = ?", [$column])[0]->Type;
        preg_match('/enum\((.*)\)$/', $type, $matches);

        return array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));
    }

    public function save()
{
    $this->validate([
        'faculty' => 'nullable|in:' . implode(',', $this->faculties),
    ]);

    $user = \App\Models\User::find(Auth::id()); // fresh from DB

    if (!$user) {
        abort(403, 'You must be logged in.');
    }

    $user->faculty = $this->faculty;
    $user->save();

    session()->flash('message', 'Faculty updated successfully.');
}


    public function render()
    {
        return view('livewire.settings.assignFakultas');
    }
}
