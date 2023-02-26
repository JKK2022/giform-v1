<?php

namespace App\Http\Livewire\Modules;

use Carbon\Carbon;
use App\Models\Module;
use App\Models\Filiere;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TypeFormation;
use Illuminate\Validation\Rule;

class ModuleList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $filtreFiliere;
    public $typeformation_id;
    public $newModule = [];
    public $editModule = [];
    public $editOldValues = [];
    public $editHasChanged = false;
    public $customerErrorMessages = [];

    function showUpdateButton()
    {
        if(
            $this->editOldValues['nom'] != $this->editModule['nom'] ||
            $this->editOldValues['filiere_id'] != $this->editModule['filiere_id'] ||
            $this->editOldValues['type_formation_id'] != $this->editModule['type_formation_id']
        ){
            $this->editHasChanged = true;
        }
    }

    public function showAddModuleModal()
    {
        $this->newModule = [];
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showModal", []);
    }

    public function addModule()
    {
        $query = Typeformation::where("nom","formation continue")->first();
        $this->typeformation_id = $query->id;
        $validatedDatas =  [
            'newModule.nom' => 'required|string|unique:modules,nom',
            'newModule.filiere_id' => 'required|integer',
        ];
        
        $this->validate($validatedDatas, $this->customerErrorMessages);

        Module::create([
            "nom" => $this->newModule['nom'],
            "filiere_id" => $this->newModule['filiere_id'],
            "type_formation_id" => $this->typeformation_id
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Module de formation ajouté avec succès"]);
    }

    public function editModuleFormation($module_id)
    {
        $this->editModule = Module::with(['filiere_module','typeformation_module'])->find($module_id)->toArray();

        $this->editOldValues = $this->editModule;
        $this->dispatchBrowserEvent("showEditModal");
    }

    public function updateModule()
    {
        $datas = $this->validate([
            'editModule.nom' => ['required','string',Rule::unique("modules","nom")->ignore($this->editModule['id'])],
            'editModule.filiere_id' => ['required','integer'],
        ]);

        Module::find($this->editModule['id'])->update($datas['editModule']);

        $this->closeEditModal();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Module de formation mis à jour avec succès !"]);
    }

    public function confirmDeleteModule($name,$id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des modules de formation. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["module_id" => $id]
        ]]);
    }

    public function deleteModule(Module $module)
    {
        $module->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Module de formation supprimé avec succès"]);
    }

    public function resetField()
    {
        $this->newModule = [];
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

        $modulesQuery = Module::query();
        if($this->search != "")
        {
            $modulesQuery->where("nom","like","%" . $this->search . "%");
        }

        if($this->filtreFiliere != "")
        {
            $modulesQuery ->where("filiere_id",$this->filtreFiliere );
        }

        $datas = [
            "modulesList" => $modulesQuery->latest()->paginate(5),
            "filieresList" => Filiere::orderBy("nom","ASC")->get()
        ];

        if($this->editModule != []){
            $this->showUpdateButton();
        }

        return view('livewire.modules.index', $datas)
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
