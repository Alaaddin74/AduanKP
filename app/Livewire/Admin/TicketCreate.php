<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Faculty;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class TicketCreate extends Component
{
    use WithFileUploads;

    public $ticket_number;
    // #[Validate('required|exists:categories,id')]
    public $category;
    public $name;
    public $no_hp;
    public $site_link;
    public $email;
    public $faculty_id;
    public $attachment;
    public $description;
    public $faculties;
    public $categories;

    public function mount()
    {
        $this->ticket_number = 'TCK-' . strtoupper(uniqid());
        $this->faculties = Faculty::all();
        $this->categories = Category::all()->pluck('name', 'id')->toArray();
    }

    public function save()
    {
        $this->validate([
            'category' => 'required|exists:categories,id',
            'site_link' => 'required|url',
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|regex:/^[0-9]+$/|max:15',
            'email' => 'required|email|max:255',
            'faculty_id' => 'nullable|exists:faculties,id',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB max
            'description' => 'required|string|max:1000',
        ]);

        if ($this->attachment) {
            $path = $this->attachment->storePublicly('attachments', 'public');
        }
        // $path = $this->attachment ? $this->attachment->store('attachments', 'public') : null;
        Ticket::create([
            'ticket_number' => $this->ticket_number,
            'user_id' => Auth::id(),
            'name' => $this->name,
            'no_hp' => $this->no_hp,
            'category_id' => $this->category,
            'site_link' => $this->site_link,
            'faculty_id' => $this->faculty_id,
            'email' => $this->email,
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
