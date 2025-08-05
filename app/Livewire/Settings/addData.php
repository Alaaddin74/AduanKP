<?php
namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\Faculty;
use Livewire\Component;

class AddData extends Component
{
    // Faculty properties
    public $faculties = [];
    public $selectedFacultyId = '';
    public $facultyName = '';
    public $showFacultyConfirmDelete = false;

    // Category properties
    public $categories = [];
    public $selectedCategoryId = '';
    public $categoryName = '';
    public $showCategoryConfirmDelete = false;

    public function mount()
    {
        $this->loadFaculties();
        $this->loadCategories();
    }

    // Faculty methods
    public function updatedSelectedFacultyId($value)
    {
        if ($value) {
            $faculty = Faculty::find($value);
            $this->facultyName = $faculty?->name ?? '';
        } else {
            $this->facultyName = '';
        }
    }

    public function saveFaculty()
    {
        $this->validate([
            'facultyName' => 'required|string|max:255|unique:faculties,name,'.$this->selectedFacultyId,
        ]);

        if ($this->selectedFacultyId) {
            Faculty::find($this->selectedFacultyId)->update([
                'name' => $this->facultyName,
            ]);
            session()->flash('faculty_message', 'Occupation updated successfully');
        } else {
            Faculty::create([
                'name' => $this->facultyName,
            ]);
            session()->flash('faculty_message', 'Occupation created successfully');
        }

        $this->resetFacultyForm();
        $this->loadFaculties();
    }

    public function confirmFacultyDelete()
    {
        $this->showFacultyConfirmDelete = true;
    }

    public function deleteFaculty()
    {
        Faculty::find($this->selectedFacultyId)->delete();
        $this->showFacultyConfirmDelete = false;
        session()->flash('faculty_message', 'Occupation deleted successfully');
        $this->resetFacultyForm();
        $this->loadFaculties();
    }

    private function loadFaculties()
    {
        $this->faculties = Faculty::orderBy('name')->get();
    }

    private function resetFacultyForm()
    {
        $this->selectedFacultyId = '';
        $this->facultyName = '';
    }

    // Category methods
    public function updatedSelectedCategoryId($value)
    {
        if ($value) {
            $category = Category::find($value);
            $this->categoryName = $category?->name ?? '';
        } else {
            $this->categoryName = '';
        }
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255|unique:categories,name,'.$this->selectedCategoryId,
        ]);

        if ($this->selectedCategoryId) {
            Category::find($this->selectedCategoryId)->update([
                'name' => $this->categoryName,
            ]);
            session()->flash('category_message', 'Category updated successfully');
        } else {
            Category::create([
                'name' => $this->categoryName,
            ]);
            session()->flash('category_message', 'Category created successfully');
        }

        $this->resetCategoryForm();
        $this->loadCategories();
    }

    public function confirmCategoryDelete()
    {
        $this->showCategoryConfirmDelete = true;
    }

    public function deleteCategory()
    {
        Category::find($this->selectedCategoryId)->delete();
        $this->showCategoryConfirmDelete = false;
        session()->flash('category_message', 'Category deleted successfully');
        $this->resetCategoryForm();
        $this->loadCategories();
    }

    private function loadCategories()
    {
        $this->categories = Category::orderBy('name')->get();
    }

    private function resetCategoryForm()
    {
        $this->selectedCategoryId = '';
        $this->categoryName = '';
    }

    public function render()
    {
        return view('livewire.settings.addData');
    }
}
