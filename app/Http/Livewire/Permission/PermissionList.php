<?php

namespace App\Http\Livewire\Permission;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class PermissionList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $isAddPermission = false;
    public $newPermissionName = "";
    public $newValuePermission = "";
    public $selectedPermission ;

    public function render()
    {
        Carbon::setlocale("fr");

        $searchCriteria = "%" . $this->search . "%";
        $permissionsLis = Permission::where("nom","like",$searchCriteria)->latest()->paginate(8);

        return view('livewire.permissions.index', compact("permissionsLis"))
                    ->extends("layouts.master")
                    ->section("contenu");
    }

    public function toggleShowAddPermissionForm()
    {
        $this->newPermissionName = "";
        $this->isAddPermission = ! $this->isAddPermission;
        $this->resetErrorBag();
    }

    public function addNewPermission()
    {
        $datas = $this->validate(["newPermissionName" => "required|unique:permissions,nom"]);

        Permission::create(["nom" => $datas["newPermissionName"]]);

        $this->toggleShowAddPermissionForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Permission ajoutée avec succès !"]);
    }

    public function editPermission(Permission $permission)
    {
        $this->dispatchBrowserEvent("showEditForm", ["permission" => $permission]);
    }

    public function updatePermission(Permission $permission, $ValueFromJS)
    {
        $this->newValuePermission = $ValueFromJS;
        $datas = $this->validate([
            "newValuePermission" => ["required",Rule::unique("permissions","nom")->ignore($permission)]
        ]);
        $permission->update(["nom" => $datas["newValuePermission"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Permission mise à jour avec succès !"]);
    }

    public function confirmDeletePermission($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des permissions. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["permission_id" => $id]
        ]]);
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Permission supprimée avec succès"]);
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
