<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Utilisateurs extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    
    public $currentPage = PAGE_LIST;

    public $newUser = [];
    public $editUser = [];
    public $rolesPermissions = [];
    public $search;

    public function render()
    {

        Carbon::setLocale("fr");

        $users = User::where("nom","like","%" . $this->search . "%")
                                ->orwhere("prenom","like","%" . $this->search . "%")
                                ->orwhere("telephone1","like","%" . $this->search . "%")
                                ->orwhere("telephone2","like","%" . $this->search . "%")
                                ->latest()
                                ->paginate(8);
        return view('livewire.utilisateurs.index',compact('users'))
                    ->extends('layouts.master')
                    ->section('contenu');
    }

    //Règles de validation des informations
    public function rules()
    {
        if($this->currentPage == PAGE_EDIT_FORM)
        {
            return [
                'editUser.nom' => 'required',
                'editUser.prenom' => 'required',
                'editUser.email' => ['required','email',Rule::unique('users','email')->ignore($this->editUser['id'])],
                'editUser.sexe' => 'required',
                'editUser.telephone1' => ['required','numeric',Rule::unique('users','telephone1')->ignore($this->editUser['id'])],
                'editUser.telephone2' => 'nullable',
            ];
        }

        return [
            'newUser.nom' => 'required',
            'newUser.prenom' => 'required',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.sexe' => 'required',
            'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
            'editUser.telephone2' => 'nullable',
        ];
    }
    

    //===============================================
    //Affichage de la liste des utilisateurs
    //===============================================
    public function goToListUser()
    {
        $this->editUser = [];
        $this->currentPage = PAGE_LIST;
    }
    //===============================================

    //===============================================
    // Codes relatifs à l'ajout des utilisateurs
    //===============================================
    //Affichage du formulaire d'ajout
    public function goToAddUser()
    {
        $this->currentPage = PAGE_CREATE_FORM;
    }

    //Ajout des utilisateurs
    public function addUser()
    {
        //Vérification des informations envoyées par le formulaire
        $datas = $this->validate();

        $datas['newUser']['password'] = Hash::make('password');

        //Ajouter l'utilisateur
        // dd($datas['newUser']);
       User::create($datas['newUser']);

       $this->newUser = [];

       $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur créé avec succès !"]);
    }
    //=============================================

    //===============================================
    //Codes relatifs à la modification des utilisateurs
    //===============================================
    //Affichage du formulaire d'édition
    public function goToEditUser(User $user)
    {
        $this->editUser = User::find($user->id)->toArray();
        $this->currentPage = PAGE_EDIT_FORM;

        $this->populateRolesPermissions();
    }
    // Fonction pour récupérer tous les roles et toutes les permisssions
    public function populateRolesPermissions()
    {
        $this->rolesPermissions['roles'] = [];
        $this->rolesPermissions['permissions'] = [];

        $mapForCB = function($value){
            return $value["id"];
        };
        // La logique pour charger les roles et permissions
        $roles = array_map($mapForCB,User::find($this->editUser['id'])->roles->toArray());
        $permissions = array_map($mapForCB,User::find($this->editUser['id'])->permissions->toArray());

        foreach (Role::all() as $role) {
            if(in_array($role->id, $roles)){
                array_push($this->rolesPermissions['roles'],["role_id" => $role->id,"role_nom" => $role->nom,"active" => true]);
            }else{
                array_push($this->rolesPermissions['roles'],["role_id" => $role->id,"role_nom" => $role->nom,"active" => false]);
            }
        }

        foreach (Permission::all() as $permission) {
            if(in_array($permission->id, $permissions)){
                array_push($this->rolesPermissions['permissions'],["permission_id" => $permission->id,"permission_nom" => $permission->nom,"active" => true]);
            }else{
                array_push($this->rolesPermissions['permissions'],["permission_id" => $permission->id,"permission_nom" => $permission->nom,"active" => false]);
            }
        }

    }

    // Fonction pour mettre à jour les roles et les permissions
    public function updateRolesAndPermissions()
    {
        DB::table("user_role")->where("user_id", $this->editUser['id'])->delete();
        DB::table("user_permission")->where("user_id", $this->editUser['id'])->delete();

        foreach ($this->rolesPermissions["roles"] as $role) {
            if($role['active']){
                User::find($this->editUser['id'])->roles()->attach($role['role_id']);
            }
        }

        foreach ($this->rolesPermissions["permissions"] as $permission) {
            if($permission["active"]){
                User::find($this->editUser['id'])->permissions()->attach($permission['permission_id']);
            }
        }

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Roles et permissions mis à jour avec succès !"]);
    }

    //Modification des utilisateurs
    public function updateUser()
    {
        $datas = $this->validate();

        User::find($this->editUser['id'])->update($datas['editUser']);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Utilisateur mis à jour avec succès !"]);
    }
    //===============================================
    
    //===============================================
    //Codes relatifs à la suppression des utilisateurs
    //===============================================
    public function confirmDeleteUser($name, $id)
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer [$name] de la liste des utilisateurs. Voulez-vous continuer ?",
            "title" => "Confirmation de suppression",
            "type" => "warning",
            "data" => ["user_id" => $id]
        ]]);
    }

   
    public function deleteUser(User $user)
    {
        $user->delete();
        $this->dispatchBrowserEvent("showSuccessMessage",["message" => "Utilisateur supprimé avec succès"]);
    }
    //===============================================

    //===============================================
    //Codes relatifs à la réinitialisation du mot de passe
    //===============================================
    public function confirmPwdReset()
    {
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateur. Voulez-vous continuer ?",
            "title" => "Confirmation de réinitialisation",
            "type" => "warning"
        ]]);
    }
    
    public function resetPassword()
    {
        User::find($this->editUser["id"])->update(["password" => Hash::make(DEFAULT_PASSWORD)]);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Mot de passe réinitialisé avec succès !"]);
    }
    //===============================================
}
