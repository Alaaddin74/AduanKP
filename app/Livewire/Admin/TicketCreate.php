<?php

namespace App\Livewire\Admin;

use App\Models\Faculty;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TicketCreate extends Component
{
    use WithFileUploads;

    public $ticket_number;
    public $category;
    public $priority = 'low';
    public $site_link;
    public $email;
    public $faculty_id;
    public $attachment;
    public $description;

    public $faculties;

    public array $categoryOptions = [
        'konten_tidak_pantas' => 'Konten Tidak Pantas',
        'menghapus_index' => 'Menghapus Index',
        'pornografi' => 'Pornografi',
        'judi_online' => 'Judi Online',
        'lainnya' => 'Lainnya',
    ];

    public function mount()
    {
        $this->ticket_number = 'TCK-' . strtoupper(uniqid());
        $this->faculties = Faculty::all();
        $this->categoryOptions;
    }

    public function save()
    {
        $this->validate([
            'category' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'site_link' => 'nullable|url',
            'faculty_id' => 'nullable|exists:faculties,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB max
            'description' => 'required|string|max:1000',
        ]);

        $path = $this->attachment ? $this->attachment->store('attachments', 'public') : null;

        Ticket::create([
            'ticket_number' => $this->ticket_number,
            'user_id' => Auth::id(),
            'category' => $this->category,
            'priority' => $this->priority,
            'site_link' => $this->site_link,
            'faculty_id' => $this->faculty_id,
            'email' => Auth::user()->email,
            'attachment' => $path,
            'description' => $this->description,
            'status' => 'submitted',
        ]);

        session()->flash('success', 'Ticket submitted successfully!');
        return redirect()->route('tickets.index');
    }
    public function render()
    {
        return view('livewire.admin.ticket-create');
    }
}
