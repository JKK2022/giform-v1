<?php

namespace App\Http\Livewire\Filieres;

use Carbon\Carbon;
use App\Models\Filiere;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class FiliereList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $filtreService = "";
    public $newFiliere = [];
    public $editFiliere = [];
    public $editOldValues = [];
    public $editHasChanged = false;
    public $customerErrorMessages = [];

    function showUpdateButton()
    {
        if(
            $this->editOldValues['nom'] != $this->editFiliere['nom'] ||
            $this->editOldValues['service_id'] != $this->editFiliere['service_id']
        ){
            $this->editHasChanged = true;
        }
    }

    public function showAddFiliereModal()
    {
        $this->newFiliere = [];
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showModal", []);
    }

    public function addFiliere()
    {
        $validatedDatas =  [
            'newFiliere.nom' => 'required|string|unique:filieres,nom',
            'newFiliere.service_id' => 'required|integer',
        ];

        $datas = $this->validate($validatedDatas, $this->customerErrorMessages);

        Filiere::create($datas['newFiliere']);

        $this->closeModal();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Filière ajoutée avec succès"]);
    }

    public function editFiliere($filiere_id)
    {
        $this->editFiliere = Filiere::with('service')->find($filiere_id)->toArray();

        $this->editOldValues = $this->editFiliere;
        $this->dispatchBrowserEvent("showEditModal");
    }

    public function updateFiliere()
    {
        $datas = $this->validate([
            'editFiliere.nom' => ['required','string',Rule::unique("filieres","nom")->ignore($this->editFiliere['id'])],
            'editFiliere.service_id' => ['required','integer'],
        ]);
        // dd($datas);
        Filiere::find($this->editFiliere['id'])->update($datas['editFiliere']);

        $this->closeEditModal();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Filière mise à jour avec succès !"]);
    }

    public function confirmDeleteFiliere($name,$id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des filières. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["filiere_id" => $id]
        ]]);
    }

    public function deleteFiliere(Filiere $filiere)
    {
        $filiere->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Filière supprimée avec succès"]);
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

    public function resetField()
    {
        $this->newFiliere = [];
        $this->editHasChanged = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        Carbon::setlocale("fr");

        $filieresQuery = Filiere::query();
        if($this->search != "")
        {
            $filieresQuery->where("nom","like","%" . $this->search . "%");
        }

        if($this->filtreService != "")
        {
            $filieresQuery ->where("service_id",$this->filtreService );
        }

        $datas = [
            "filieresList" => $filieresQuery->latest()->paginate(5),
            "servicesList" => Service::Where("estFormation","1")->orderBy("nom","ASC")->get()
        ];

        if($this->editFiliere != []){
            $this->showUpdateButton();
        }

        return view('livewire.filieres.index', $datas)
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
