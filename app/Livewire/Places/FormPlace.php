<?php

namespace App\Livewire\Places;

use App\Models\Place;
use Livewire\Component;

class FormPlace extends Component
{
    public $places;
    public $name, $code, $serial_number, $address, $localization, $status, $region_id;
    public $placeId;
    public $isEditing = false;


    protected $rules = [
        'name' => 'required|min:3',
        'code' => 'required',
        'serial_number' => 'required',
        'address' => 'required',
        'localization' => 'required',
        'status' => 'required',
        'region_id' => 'required|exists:regions,id',
    ];


    public function mount()
    {
        $this->loadPlaces();
    }


    public function loadPlaces()
    {
        $this->places = Place::latest()->get();
    }


    public function store()
    {
        $this->validate();


        Place::create([
            'name' => $this->name,
            'code' => $this->code,
            'serial_number' => $this->serial_number,
            'address' => $this->address,
            'localization' => $this->localization,
            'status' => $this->status,
            'region_id' => $this->region_id,
        ]);


        $this->resetForm();
        $this->loadPlaces();
    }


    public function edit($id)
    {
        $place = Place::findOrFail($id);
        $this->placeId = $id;
        $this->name = $place->name;
        $this->code = $place->code;
        $this->serial_number = $place->serial_number;
        $this->address = $place->address;
        $this->localization = $place->localization;
        $this->status = $place->status;
        $this->region_id = $place->region_id;
        $this->isEditing = true;
    }


    public function update()
    {
        $this->validate();


        Place::find($this->placeId)->update([
            'name' => $this->name,
            'code' => $this->code,
            'serial_number' => $this->serial_number,
            'address' => $this->address,
            'localization' => $this->localization,
            'status' => $this->status,
            'region_id' => $this->region_id,
        ]);


        $this->resetForm();
        $this->loadPlaces();
    }


    public function delete($id)
    {
        Place::destroy($id);
        $this->loadPlaces();
    }


    public function resetForm()
    {
        $this->name = '';
        $this->code = '';
        $this->serial_number = '';
        $this->address = '';
        $this->localization = '';
        $this->status = '';
        $this->region_id = null;
        $this->placeId = null;
        $this->isEditing = false;
    }
    public function render()
    {
        return view('livewire.places.form-place');
    }
}
