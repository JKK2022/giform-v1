<?php

namespace App\Http\Livewire\Motifs;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MotifPaiement;
use Illuminate\Validation\Rule;

class MotifPaiementsList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $isAddMotif = false;
    public $newMotifName = "";
    public $newValueMotif= "";
    public $selectedMotif ;

    public function toggleShowAddMotifPaiementForm()
    {
        $this->newMotifName = "";
        $this->isAddMotif = ! $this->isAddMotif;
        $this->resetErrorBag();
    }

    public function addNewMotifPaiement()
    {
        $datas = $this->validate(["newMotifName" => "required|unique:motif_paiements,motif"]);

        MotifPaiement::create(["motif" => $datas["newMotifName"]]);

        $this->toggleShowAddMotifPaiementForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Motif de paiement ajouté avec succès !"]);
    }

    public function editMotifPaiement(MotifPaiement $motifPaiement)
    {
        $this->dispatchBrowserEvent("showEditForm", ["motifPaiement" => $motifPaiement]);
    }

    public function updateMotifPaiement(MotifPaiement $motifPaiement, $ValueFromJS)
    {
        $this->newValueMotif = $ValueFromJS;
        $datas = $this->validate([
            "newValueMotif" => ["required",Rule::unique("motif_paiements","motif")->ignore($motifPaiement)]
        ]);
        $motifPaiement->update(["motif" => $datas["newValueMotif"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Motif de paiement mis à jour avec succès !"]);
    }

    public function confirmDeleteMotifPaiement($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des motifs de paiement. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["motif_paiement_id" => $id]
        ]]);
    }

    public function deleteMotifPaiement(MotifPaiement $motifPaiement)
    {
        $motifPaiement->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Motif de paiement supprimé avec succès"]);
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

        $MotifsList = MotifPaiement::where("motif","like","%" . $this->search . "%")->latest()->paginate(6);
        return view('livewire.motifs.index',compact('MotifsList'))
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
