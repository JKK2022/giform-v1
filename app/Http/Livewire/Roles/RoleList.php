<?php

namespace App\Http\Livewire\Roles;

use Carbon\Carbon;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class RoleList extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $search;
    public $isAddRole = false;
    public $newRoleName = "";
    public $newValueRole = "";
    public $selectedRole ;

    public function render()
    {
        Carbon::setlocale("fr");

        $rolesList = Role::where("nom","like","%" . $this->search . "%")->latest()->paginate(8);

        return view('livewire.roles.index', compact("rolesList"))
                    ->extends("layouts.master")
                    ->section("contenu");
    }

    public function toggleShowAddRoleForm()
    {
        $this->newRoleName = "";
        $this->isAddRole = ! $this->isAddRole;
        $this->resetErrorBag();
    }

    public function addNewRole()
    {
        $datas = $this->validate(["newRoleName" => "required|unique:roles,nom"]);

        Role::create(["nom" => $datas["newRoleName"]]);

        $this->toggleShowAddRoleForm();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Rôle ajouté avec succès !"]);
    }

    public function editRole(Role $role)
    {
        $this->dispatchBrowserEvent("showEditForm", ["role" => $role]);
    }

    public function updateRole(Role $role, $ValueFromJS)
    {
        $this->newValueRole = $ValueFromJS;
        $datas = $this->validate([
            "newValueRole" => ["required",Rule::unique("roles","nom")->ignore($role)]
        ]);
        $role->update(["nom" => $datas["newValueRole"]]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Rôle mis à jour avec succès !"]);
    }

    public function confirmDeleteRole($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des rôles. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["role_id" => $id]
        ]]);
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Rôle supprimé avec succès"]);
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
