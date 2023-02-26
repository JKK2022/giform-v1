<?php

namespace App\Http\Livewire\Stagiaires;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Stagiaire;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\PhotoStagiaire;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class StagiairesList extends Component
{
    use WithPagination,WithFileUploads;

    protected $paginationTheme = "bootstrap";
    
    public $currentPage = PAGE_LIST;

    public $search;
    public $newStagiaire = [];
    public $newPhoto = null;
    public $fileInputIterator = 0;

    public $editStagiaire = [];
    public $editPhoto = null;
    public $editHasChanged;
    public $editStagiaireOldValues = [];
    public $fileEditInputIterator = 0;

    protected function rules(){
        return [
            'editStagiaire.nom' => ['required','string'],
            'editStagiaire.postnom' => ['required','string'],
            'editStagiaire.prenom' => ['nullable'],
            'editStagiaire.sexe' => ['required','string'],
            'editStagiaire.lieu_naissance' => ['required','string'],
            'editStagiaire.date_naissance' => ['required','date'],
            'editStagiaire.telephone1' => ['required','string',Rule::unique("stagiaires","telephone1")->ignore($this->editStagiaire['id'])],
            'editStagiaire.telephone2' => ['nullable'],
            'editStagiaire.email' => ['nullable'],
            'editStagiaire.adresse' => ['required','string'],
            'editStagiaire.nom_pere' => ['required','string'],
            'editStagiaire.nom_mere' => ['required','string'],
            'editPhoto' => 'image|max:1024',
        ];
    }

    function showUpdateButton()
    {
        $this->editHasChanged = false;

        if(
            $this->editStagiaireOldValues['nom'] != $this->editStagiaire['nom'] ||
            $this->editStagiaireOldValues['postnom'] != $this->editStagiaire['postnom'] ||
            $this->editStagiaireOldValues['prenom'] != $this->editStagiaire['prenom'] ||
            $this->editStagiaireOldValues['sexe'] != $this->editStagiaire['sexe'] ||
            $this->editStagiaireOldValues['lieu_naissance'] != $this->editStagiaire['lieu_naissance'] ||
            $this->editStagiaireOldValues['date_naissance'] != $this->editStagiaire['date_naissance'] ||
            $this->editStagiaireOldValues['telephone1'] != $this->editStagiaire['telephone1'] ||
            $this->editStagiaireOldValues['telephone2'] != $this->editStagiaire['telephone2'] ||
            $this->editStagiaireOldValues['email'] != $this->editStagiaire['email'] ||
            $this->editStagiaireOldValues['adresse'] != $this->editStagiaire['adresse'] ||
            $this->editStagiaireOldValues['nom_pere'] != $this->editStagiaire['nom_pere'] ||
            $this->editStagiaireOldValues['nom_mere'] != $this->editStagiaire['nom_mere'] ||
            $this->editPhoto != null
        ){
            $this->editHasChanged = true;
        }
    }

    public function showAddStagiaireModal()
    {
        $this->newStagiaire = [];
        $this->newPhoto = null;
        $this->fileInputIterator++;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showModal", []);
    }

    public function addStagiaire()
    {
        $customerErrorMessages = [];

        // Par défaut notre image est le placeholder
        $imagePath = "images/placeholder.png";

        $validatedDatas =  [
            'newStagiaire.nom' => 'required|string',
            'newStagiaire.postnom' => 'required|string',
            'newStagiaire.prenom' => 'nullable',
            'newStagiaire.sexe' => 'required|string',
            'newStagiaire.lieuNaissance' => 'required|string',
            'newStagiaire.dateNaissance' => 'required|date',
            'newStagiaire.telephone1' => 'required|string|unique',
            'newStagiaire.telephone2' => 'nullable',
            'newStagiaire.email' => 'nullable',
            'newStagiaire.adresse' => 'required|string',
            'newStagiaire.nomPere' => 'required|string',
            'newStagiaire.nomMere' => 'required|string',
            'newPhoto' => 'image|max:1024',
        ];

        $datas = $this->validate($validatedDatas, $customerErrorMessages);

        if($this->newPhoto != null)
        {
            $imagePath = $this->newPhoto->store("upload","public");

            $image = Image::make(public_path("storage/".$imagePath))->fit(200,200);
            $image->save();
        }

        // Ajout des stagiaires
        $stagiaire = Stagiaire::create([
            "matricule" => 'STG' . time(),
            "nom" => $datas['newStagiaire']['nom'],
            "postnom" => $datas['newStagiaire']['postnom'],
            "prenom" => $datas['newStagiaire']['prenom'],
            "sexe" => $datas['newStagiaire']['sexe'],
            "lieu_naissance" => $datas['newStagiaire']['lieuNaissance'],
            "date_naissance" => $datas['newStagiaire']['dateNaissance'],
            "telephone1" => $datas['newStagiaire']['telephone1'],
            "telephone2" => $datas['newStagiaire']['telephone2'],
            "email" => $datas['newStagiaire']['email'],
            "adresse" => $datas['newStagiaire']['adresse'],
            "nom_pere" => $datas['newStagiaire']['nomPere'],
            "nom_mere" => $datas['newStagiaire']['nomMere']
        ]);

        //Enregistrement de la photo
        PhotoStagiaire::create([
            "stagiaire_id" => $stagiaire->id,
            "photo" => $imagePath
        ]);

        $this->closeModal();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Stagiaire ajouté avec succès"]);
    }

    public function editStagiaire($stagiaire_id)
    {
        $this->editStagiaire = Stagiaire::with("photo")->find($stagiaire_id)->toArray();

        $this->editStagiaireOldValues = $this->editStagiaire;
        $this->dispatchBrowserEvent("showEditModal");
    }

    public function updateStagiaire()
    {
        $this->validate();

        $stagiaire = Stagiaire::find($this->editStagiaire['id']);
        $stagiaire->fill($this->editStagiaire);

        if($this->editPhoto != null){
            $imagePath = $this->editPhoto->store("upload","public");

            $image = Image::make(public_path("storage/".$imagePath))->fit(200,200);
            $image->save();

            // 
            $photoStagiaire = PhotoStagiaire::find($this->editStagiaire['id']);

            $filePath = public_path("storage\\" . $photoStagiaire->photo);

            if($photoStagiaire != null || $photoStagiaire != ""){
                if(File::exists($filePath)){
                    File::delete($filePath);
                }
            }
        }

        //Modification de la photo
        PhotoStagiaire::find($stagiaire->id)->update([
            "photo" => $imagePath
        ]);

        $stagiaire->save();

        $this->closeEditModal();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Stagiaire mis à jour avec succès !"]);
    }

    public function confirmDeleteStagiaire($name,$id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des stagiaires. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["stagiaire_id" => $id]
        ]]);
    }

    public function deleteStagiaire(Stagiaire $stagiaire)
    {
        if($stagiaire->photo->photo != null){

            $photoStagiaire = PhotoStagiaire::find($stagiaire->id);

            $filePath = public_path("storage\\" . $photoStagiaire->photo);

            if($photoStagiaire != null || $photoStagiaire != ""){
                if(File::exists($filePath)){
                    File::delete($filePath);
                }
            }
            PhotoStagiaire::find($stagiaire->id)->delete();
        }
        $stagiaire->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Stagiaire supprimé avec succès"]);
    }

    public function closeModal()
    {
        $this->newPhoto = null;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("closeModal",[]);
    }

    public function closeEditModal()
    {
        $this->editPhoto = null;
        // $this->editStagiaire = [];
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("closeEditModal",[]);
    }

    public function render()
    {
        Carbon::setLocale("fr");
        
        $stagiairestList = Stagiaire::with('photo')->where("matricule",'like','%' . $this->search . '%')
                                ->orWhere("nom",'like','%' . $this->search . '%')
                                ->orWhere("postnom",'like','%' . $this->search . '%')
                                ->orWhere("prenom",'like','%' . $this->search . '%')
                                ->latest()
                                ->paginate(5);
                                
        if($this->editStagiaire != []){
            $this->showUpdateButton();
        }

        return view('livewire.stagiaires.index',compact('stagiairestList'))
                                ->extends('layouts.master')
                                ->section('contenu');
    }

    public function cleanupOldUploads(){

        $storage = Storage::disk('local');

        foreach ($storage->allFiles("livewire-tmp") as $fileName) {
            
            if(! $storage->exists($fileName)) continue;

            $fiveSecondsDelete = now()->subSecond(5)->timestamp;

            if($fiveSecondsDelete > $storage->lastModified($fileName)){
                $storage->delete($fileName);
            }
        }
    }
}
