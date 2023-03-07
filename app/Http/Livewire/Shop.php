<?php

namespace App\Http\Livewire;

use App\Models\Genre;
use App\Models\Record;
use Http;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use withPagination;

    public $perPage = 6;
    public $loading = 'Please wait...';
    public $name;
    public $genre = '%';
    public $price;
    public $selectedRecord;
    public $priceMin, $priceMax;
    public $showModal = false;

    public function showTracks(Record $record)
    {
        $this->selectedRecord = $record;
        $url = "https://musicbrainz.org/ws/2/release/{$record->mb_id}?inc=recordings&fmt=json";
        $response = Http::get($url)->json();
        $this->selectedRecord['tracks'] = $response['media'][0]['tracks'];
        //dd($this->selectedRecord->toArray());
        $this->showModal = true;
        // dump($this->selectedRecord->toArray());
    }

    public function mount()
    {
        $this->priceMin = ceil(Record::min('price'));
        $this->priceMax = ceil(Record::max('price'));
        $this->price = $this->priceMax;
    }

    public function render()
    {
        $allGenres = Genre::has('records')->withCount('records')->get();
        $records = Record::orderBy('artist')->orderBy('title')
            ->searchTitleOrArtist($this->name)
            ->maxPrice($this->price)
            ->where('genre_id', 'like', $this->genre)
            ->paginate($this->perPage);

        return view('livewire.shop', compact('records', 'allGenres'))
            ->layout('layouts.vinylshop', [
                'description' => 'Shop',
                'title' => 'Shop'
            ]);
    }


}
