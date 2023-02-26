<?php

namespace App\Http\Livewire\Metiers;

use Carbon\Carbon;
use App\Models\Metier;
use App\Models\Filiere;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TypeFormation;
use Illuminate\Validation\Rule;

class MetierList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $filtreFiliere;
    public $typeformation_id;
    public $newMetier = [];
    public $editMetier = [];
    public $editOldValues = [];
    public $editHasChanged = false;
    public $customerErrorMessages = [];

    function showUpdateButton()
    {
        if(
            $this->editOldValues['nom'] != $this->editMetier['nom'] ||
            $this->editOldValues['filiere_id'] != $this->editMetier['filiere_id'] ||
            $this->editOldValues['type_formation_id'] != $this->editMetier['type_formation_id']
        ){
            $this->editHasChanged = true;
        }
    }

    public function showAddMetierModal()
    {
        $this->newMetier = [];
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showModal", []);
    }

    public function addMetier()
    {
        $query = Typeformation::where("nom","Formation qualifiante")->first();
        $this->typeformation_id = $query->id;
        $validatedDatas =  [
            'newMetier.nom' => 'required|string|unique:metiers,nom',
            'newMetier.filiere_id' => 'required|integer',
        ];

        $this->validate($validatedDatas, $this->customerErrorMessages);

        Metier::create([
            "nom" => $this->newMetier['nom'],
            "filiere_id" => $this->newMetier['filiere_id'],
            "type_formation_id" => $this->typeformation_id
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Métier ajouté avec succès"]);
    }

    public function editMetier($metier_id)
    {
        $this->editMetier = Metier::with(['filiere_metier','typeformation_metier'])->find($metier_id)->toArray();

        $this->editOldValues = $this->editMetier;
        $this->dispatchBrowserEvent("showEditModal");
    }

    public function updateMetier()
    {
        $datas = $this->validate([
            'editMetier.nom' => ['required','string',Rule::unique("metiers","nom")->ignore($this->editMetier['id'])],
            'editMetier.filiere_id' => ['required','integer'],
        ]);
        // dd($datas);
        Metier::find($this->editMetier['id'])->update($datas['editMetier']);

        $this->closeEditModal();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Métier mis à jour avec succès !"]);
    }

    public function confirmDeleteMetier($name,$id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des métiers. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["metier_id" => $id]
        ]]);
    }

    public function deleteMetier(Metier $metier)
    {
        $metier->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Métier supprimé avec succès"]);
    }

    public function resetField()
    {
        $this->newMetier = [];
        $this->editHasChanged = false;
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent("closeModal",[]);
    }

    public function closeEditModal()
    {
        $this->resetField();
        $this->dispatchBrowserEvent("closeEditModal",[]);
    }

    public function render()
    {
        Carbon::setlocale("fr");

        $metiersQuery = Metier::query();
        if($this->search != "")
        {
            $metiersQuery->where("nom","like","%" . $this->search . "%");
        }

        if($this->filtreFiliere != "")
        {
            $metiersQuery ->where("filiere_id",$this->filtreFiliere );
        }

        $datas = [
            "ListeMmetiers" => $metiersQuery->latest()->paginate(5),
            "filieresList" => Filiere::orderBy("nom","ASC")->get(),
        ];

        if($this->editMetier != []){
            $this->showUpdateButton();
        }

        return view('livewire.metiers.index', $datas)
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
