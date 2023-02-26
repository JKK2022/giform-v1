<?php

namespace App\Http\Livewire\Typesformations;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TypeFormation;
use Illuminate\Validation\Rule;

class TypeFormationList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $isAddTypeFormation = false;
    public $newTypeFormationName = "";
    
    public function toggleShowAddTypeFormationForm()
    {
        $this->newTypeFormationName = "";
        $this->isAddTypeFormation = ! $this->isAddTypeFormation;
        $this->resetErrorBag();
    }

    public function addNewTypeFormation()
    {
        $datas = $this->validate(["newTypeFormationName" => "required|unique:type_formations,nom"]);

        TypeFormation::create(["nom" => $datas["newTypeFormationName"]]);

        $this->toggleShowAddTypeFormationForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type formation ajouté avec succès !"]);
    }

    public function editTypeFormation(TypeFormation $typeFormation)
    {
        $this->dispatchBrowserEvent("showEditForm", ["typeFormation" => $typeFormation]);
    }

    public function updateTypeFormation(TypeFormation $typeFormation, $ValueFromJS)
    {
        $this->newTypeFormationName = $ValueFromJS;
        $datas = $this->validate([
            "newTypeFormationName" => ["required",Rule::unique("type_formations","nom")->ignore($typeFormation)]
        ]);
        $typeFormation->update(["nom" => $datas["newTypeFormationName"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type formation mis à jour avec succès !"]);
    }

    public function confirmDeleteTypeFormation($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des types des formations. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["type_formation_id" => $id]
        ]]);
    }

    public function deleteTypeFormation(TypeFormation $typeFormation)
    {
        $typeFormation->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Type formation supprimé avec succès"]);
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("closeModal",[]);
    }

    public function closeEditModal()
    {
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("closeEditModal",[]);
    }

    public function render()
    {
        Carbon::setlocale("fr");
        
        $typeFormationList = TypeFormation::where("nom","like","%" . $this->search . "%")->latest()->paginate(8);
                    
        return view('livewire.typesformations.index', compact("typeFormationList"))
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
