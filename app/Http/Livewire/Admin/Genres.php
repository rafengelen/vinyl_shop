<?php

namespace App\Http\Livewire\Admin;

use App\Models\Genre;
use Livewire\Component;

class Genres extends Component
{
    // sort properties
    public $orderBy = 'name';
    public $orderAsc = true;
    public $newGenre;
    public $editGenre = ['id' => null, 'name' => null];

    // validation rules
    public function rules()
    {
        return [
            'newGenre' => 'required|min:3|max:30|unique:genres,name',
            'editGenre.name' => 'required|min:3|max:30|unique:genres,name,' . $this->editGenre['id'],
        ];
    }

    // reset $newGenre and validation
    public function resetNewGenre()
    {
        $this->reset('newGenre');
        $this->resetErrorBag();
    }

    // delete a genre
    public function deleteGenre(Genre $genre)
    {
        $genre->delete();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The genre <b><i>{$genre->name}</i></b> has been deleted",
        ]);
    }

    // edit the value of $editGenre (show inlined edit form)
    public function editExistingGenre(Genre $genre)
    {
        $this->editGenre = [
            'id' => $genre->id,
            'name' => $genre->name,
        ];
    }


    // reset $editGenre and validation
    public function resetEditGenre()
    {
        $this->reset('editGenre');
        $this->resetErrorBag();
    }

    // update an existing genre
    public function updateGenre(Genre $genre)
    {
        $this->validateOnly('editGenre.name');
        $oldName = $genre->name;
        $genre->update([
            'name' => trim($this->editGenre['name']),
        ]);
        $this->resetEditGenre();
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The genre <b><i>{$oldName}</i></b> has been updated to <b><i>{$genre->name}</i></b>",
        ]);
    }

// create a new genre
    public function createGenre()
    {
        // validate the new genre name
        $this->validateOnly('newGenre');
        // create the genre
        $genre = Genre::create([
            'name' => trim($this->newGenre),
        ]);
        // reset $newGenre
        $this->resetNewGenre();
        // toast
        $this->dispatchBrowserEvent('swal:toast', [
            'background' => 'success',
            'html' => "The genre <b><i>{$genre->name}</i></b> has been added",
        ]);
    }

    // resort the genres by the given column
    public function resort($column)
    {
        if ($this->orderBy === $column) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $column;
    }

    public function render()
    {
        $genres = Genre::withCount('records')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();
        return view('livewire.admin.genres', compact('genres'))
            ->layout('layouts.vinylshop', [
                'description' => 'Manage the genres of your vinyl records',
                'title' => 'Genres',
            ]);
    }
}
