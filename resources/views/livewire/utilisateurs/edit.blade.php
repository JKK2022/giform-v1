<div class="row p-4 pt-5">
    <div class="col col-md-6">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus"></i> Formulaire de création d'un nouvel utilisateur</h3>
            </div>
            <form role="form" wire:submit.prevent='updateUser()'>
                <div class="card-body">

                    <div class="d-flex">

                        <div class="form-group flex-grow-1 mr-2">
                            <label>Nom</label>
                            <input type="text" class="form-control @error('editUser.nom') is-invalid @enderror" wire:model="editUser.nom">
                            @error('editUser.nom')
                                <span class="text-danger">{{ $message }}</span>    
                            @enderror
                        </div>

                        <div class="form-group flex-grow-1 mr-2">
                            <label>Prénom</label>
                            <input type="text" class="form-control @error('editUser.prenom') is-invalid @enderror" wire:model="editUser.prenom">
                            @error('editUser.prenom')
                                <span class="text-danger">{{ $message }}</span>    
                            @enderror
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Sexe</label>
                        <select wire:model="editUser.sexe" class="form-control @error('editUser.sexe') is-invalid @enderror">
                            <option value="">---------</option>
                            <option value="H">Homme</option>
                            <option value="F">Femme</option>
                        </select>
                        @error('editUser.sexe')
                            <span class="text-danger">{{ $message }}</span>    
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Adresse em-mail</label>
                        <input type="email" class="form-control @error('editUser.email') is-invalid @enderror" wire:model="editUser.email">
                        @error('editUser.email')
                            <span class="text-danger">{{ $message }}</span>    
                        @enderror
                    </div>

                    <div class="d-flex">

                        <div class="form-group flex-grow-1 mr-2">
                            <label>Téléphone 1</label>
                            <input type="text" class="form-control @error('editUser.telephone1') is-invalid @enderror" wire:model="editUser.telephone1">
                            @error('editUser.telephone1')
                                <span class="text-danger">{{ $message }}</span>    
                            @enderror
                        </div>

                        <div class="form-group flex-grow-1">
                            <label>Téléphone 2</label>
                            <input type="text" class="form-control" wire:model="editUser.telephone2">
                        </div>

                    </div>

                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Appliquer les modifications</button>
                    <button type="button" class="btn btn-danger" wire:click='goToListUser'>Retourner à la liste des utilisateurs</button>
                </div>
            </form>
        </div>

    </div>

    <div class="col col-md-6">
        <div class="row">
            <div class="col col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-key"></i> Réinitialisation du mot de passe</h3>
                    </div>

                    <div class="card-body">
                        <ul>
                            <li>
                                <a href="" wire:click.prevent="confirmPwdReset">Réinitialiser le mot de passe </a> <span>(par défaut : "password")</span>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col col-md-12 mt-4">

                <div class="card card-primary">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title flex-grow-1"><i class="fas fa-fingerprint"></i> Rôles & permissions</h3>
                        <button class="btn bg-gradient-success text-white" wire:click="updateRolesAndPermissions"><i class="fas fa-check"></i> Appliquer les modifications</button>
                    </div>

                    <div class="card-body">
                        <h3>Rôles</h3>
                        <div class="accordion">
                            @foreach ($rolesPermissions['roles'] as $role)
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4 class="card-title flex-grow-1">
                                            <a data-parent="#accordion" href="#" aria-expanded="true">{{$role['role_nom']}}</a>
                                        </h4>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" wire:model.lazy="rolesPermissions.roles.{{$loop->index}}.active" @if ($role['active']) checked @endif id="customSwitch{{$role['role_id']}}">
                                            <label for="customSwitch{{$role['role_id']}}" class="custom-control-label">
                                                {{ $role['active'] ? 'Activé' : 'Désactivé' }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div>
                            <h3>Permissions</h3>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h4 class="card-title flex-grow-1">
                                        <a wire:ignore.self data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Liste des permissions
                                        </a>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    @foreach ($rolesPermissions['permissions'] as $permission)
                                                        <tr>
                                                            <td>{{$permission['permission_nom']}}</td>
                                                            <td>
                                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                    <input type="checkbox" class="custom-control-input"  wire:model.lazy="rolesPermissions.permissions.{{$loop->index}}.active" @if ($permission['active']) checked @endif id="customSwitchPermission{{$permission['permission_id']}}">
                                                                    <label for="customSwitchPermission{{$permission['permission_id']}}" class="custom-control-label">{{ $permission['active'] ? 'Activé' : 'Désactivé' }}</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            {{-- <table class="table table-bordered">
                                <thead>
                                    <th>Permissions</th>
                                </thead>
                                <tbody>
                                    @foreach ($rolesPermissions['permissions'] as $permission)
                                        <tr>
                                            <td>{{$permission['permission_nom']}}</td>
                                            <td>
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input"  wire:model.lazy="rolesPermissions.permissions.{{$loop->index}}.active" @if ($permission['active']) checked @endif id="customSwitchPermission{{$permission['permission_id']}}">
                                                    <label for="customSwitchPermission{{$permission['permission_id']}}" class="custom-control-label">{{ $permission['active'] ? 'Activé' : 'Désactivé' }}</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
  
                            </table> --}}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>