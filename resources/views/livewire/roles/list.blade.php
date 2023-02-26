<div class="row p-4 pt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fas fa-cog"></i> Liste des types d'articles</h3>
                <div class="card-tools d-flex align-items-center">
                    <a class="btn btn-link text-white mr-4 d-block" wire:click.prevent="toggleShowAddRoleForm"><i class="fas fa-plus"></i> Nouvau rôle</a>
                    <div class="input-group input-group-md" style="width: 200px;">
                        <input type="text" name="table_search" wire:model.debounce="search" class="form-control float-right" placeholder="Recherche"/>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body  p-0 ">
                <table class="table table-head-fixed text-nowrap  table-striped">
                    <thead>
                        <tr>
                            <th>Noms</th>
                            <th class="text-center">Ajouté</th>
                            <th class="text-center" >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($isAddRole)
                            <tr>
                                <td colspan="2">
                                    <input type="text" wire:keydown.enter="addNewRole" wire:model="newRoleName" class="form-control @error('newRoleName') is-invalid @enderror">
                                    @error("newRoleName")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary" wire:click="addNewRole">Valider <i class="fa fa-check"></i></button>
                                    <button type="button" class="btn btn-danger" wire:click="toggleShowAddRoleForm">Annuler <i class="fa fa-times"></i></button>  
                                </td>
                            </tr>
                        @endif
                        @forelse ($rolesList as $item)
                            <tr>
                                <td>{{ $item->nom }}</td>
                                <td class="text-center">{{ optional($item->created_at)->diffForHumans() }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success" wire:click="editRole({{ $item->id }})"><i class="far fa-edit"></i></a>

                                    @if (count($item->users) == 0) 
                                        <a class="btn btn-danger" wire:click="confirmDeleteRole('{{ str_replace("'","\'",$item->nom) }}', {{ $item->id }})"><i class="far fa-trash-alt"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4">
                                    <img src="{{asset('images/empty.svg')}}" alt="" width="50px" height="60px">
                                    <div>Aucun élément n'a été trouvé</div> 
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    {{ $rolesList->links() }}
                </div>
            </div>
        
        </div>
    
    </div>
</div>

