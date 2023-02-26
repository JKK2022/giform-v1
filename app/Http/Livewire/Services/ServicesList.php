<?php

namespace App\Http\Livewire\Services;

use Carbon\Carbon;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ServicesList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search;
    public $isAddService = false;
    public $newServiceName = "";

    public function toggleShowAddServiceForm()
    {
        $this->newServiceName = "";
        $this->isAddService = ! $this->isAddService;
        $this->resetErrorBag();
    }

    public function addNewService()
    {
        $datas = $this->validate(["newServiceName" => "required|unique:services,nom"]);

        Service::create(["nom" => $datas["newServiceName"]]);

        $this->toggleShowAddServiceForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Service ajouté avec succès !"]);
    }

    public function editService(Service $service)
    {
        $this->dispatchBrowserEvent("showEditForm", ["service" => $service]);
    }

    public function updateService(Service $service, $ValueFromJS)
    {
        $this->newServiceName = $ValueFromJS;
        $datas = $this->validate([
            "newServiceName" => ["required",Rule::unique("services","nom")->ignore($service)]
        ]);
        $service->update(["nom" => $datas["newServiceName"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Service mis à jour avec succès !"]);
    }

    public function confirmDeleteService($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des services. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["service_id" => $id]
        ]]);
    }

    public function deleteService(Service $service)
    {
        $service->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Service supprimé avec succès"]);
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

        $ServicesList = Service::where("nom","like","%" . $this->search . "%")->latest()->paginate(6);
        return view('livewire.services.index',compact('ServicesList'))
                    ->extends("layouts.master")
                    ->section("contenu");
    }
}
