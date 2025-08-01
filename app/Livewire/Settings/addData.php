<?php
namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\Faculty;
use Livewire\Component;

class AddData extends Component
{
 public $faculties = [];
    public $selectedFacultyId = '';
    public $facultyName = '';
    public $showConfirmDelete = false;

    public function mount()
    {
        $this->loadFaculties();
    }

    public function updatedSelectedFacultyId($id)
    {
        if ($id) {
            $faculty = Faculty::find($id);
            $this->facultyName = $faculty?->name ?? '';
        } else {
            $this->facultyName = '';
        }
    }

    public function saveFaculty()
    {
        $this->validate([
            'facultyName' => 'required|string|max:255',
        ]);

        if ($this->selectedFacultyId) {
            Faculty::find($this->selectedFacultyId)?->update([
                'name' => $this->facultyName,
            ]);
        } else {
            Faculty::create([
                'name' => $this->facultyName,
            ]);
        }

        $this->resetForm();
        $this->loadFaculties();
    }

    public function confirmDelete()
    {
        if ($this->selectedFacultyId) {
            $this->showConfirmDelete = true;
        }
    }

    public function deleteFaculty()
    {
        Faculty::find($this->selectedFacultyId)?->delete();

        $this->resetForm();
        $this->loadFaculties();
        $this->showConfirmDelete = false;
    }

    private function loadFaculties()
    {
        $this->faculties = Faculty::orderBy('name')->get();
    }

    private function resetForm()
    {
        $this->selectedFacultyId = '';
        $this->facultyName = '';
    }

    public function render()
    {
        return view('livewire.settings.addData', [
            'faculties' => $this->faculties,
            // 'categories' => $this->categories,
        ]);
    }
}
