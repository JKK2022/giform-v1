<?php

namespace App\Http\Livewire\Typestagiaires;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TypeStagiaire;
use Illuminate\Validation\Rule;

class TypeStagiaireList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $isAddTypeStagiaire = false;
    public $newTypeStagiaireName = "";

    public function render()
    {
        Carbon::setlocale("fr");
        
        $typeStagiairesList = TypeStagiaire::where("nom","like","%" . $this->search . "%")->latest()->paginate(8);
                    
        return view('livewire.typestagiaires.index', compact("typeStagiairesList"))
                    ->extends("layouts.master")
                    ->section("contenu");
    }

    public function toggleShowAddTypeStagiaireForm()
    {
        $this->newTypeStagiaireName = "";
        $this->isAddTypeStagiaire = ! $this->isAddTypeStagiaire;
        $this->resetErrorBag();
    }

    public function addNewTypeStagiaire()
    {
        $datas = $this->validate(["newTypeStagiaireName" => "required|unique:type_stagiaires,nom"]);

        TypeStagiaire::create(["nom" => $datas["newTypeStagiaireName"]]);

        $this->toggleShowAddTypeStagiaireForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type stagiaire ajouté avec succès !"]);
    }

    public function editTypeStagiaire(TypeStagiaire $typeStagiaire)
    {
        $this->dispatchBrowserEvent("showEditForm", ["typeStagiaire" => $typeStagiaire]);
    }

    public function updateTypeStagiaire(TypeStagiaire $typeStagiaire, $ValueFromJS)
    {
        $this->newTypeStagiaireName = $ValueFromJS;
        $datas = $this->validate([
            "newTypeStagiaireName" => ["required",Rule::unique("type_stagiaires","nom")->ignore($typeStagiaire)]
        ]);
        $typeStagiaire->update(["nom" => $datas["newTypeStagiaireName"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Type stagiaire mis à jour avec succès !"]);
    }

    public function confirmDeleteTypeStagiaire($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des types stagiaires. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["type_stagiaire_id" => $id]
        ]]);
    }

    public function deleteTypeStagiaire(TypeStagiaire $typeStagiaire)
    {
        $typeStagiaire->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Type stagiaire supprimé avec succès"]);
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
}
