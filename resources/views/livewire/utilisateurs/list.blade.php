<div class="row p-4 pt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fas fa-users"></i> Liste des utilisateurs</h3>
                <div class="card-tools d-flex align-items-center">
                    <a class="btn btn-link text-white mr-4 d-block" wire:click.prevent='goToAddUser'><i class="fas fa-user-plus"></i> Nouvel utilisateur</a>
                    <div class="input-group input-group-md" style="width: 200px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0 table-striped">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:5%;"></th>
                            <th style="width:30%;">Utilisateur</th>
                            <th class="text-center" style="width:25%;">Roles</th>
                            <th class="text-center" style="width:20%;">Ajouté</th>
                            <th class="text-center" style="width:20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    @if($user->sexe === "F")
                                        <img src="{{ asset('images/femme.png') }} " width="24" />
                                    @else
                                        <img src="{{ asset('images/homme.png') }} " width="24" />
                                    @endif
                                </td>
                                <td>{{ $user->prenom }} {{ $user->nom }}</td>
                                <td class="text-center">{{ $user->allRolesNames }}</td>
                                <td class="text-center"><span class="tag tag-success">{{ $user->created_at->diffForHumans() }}</span></td>
                                <td class="text-center">
                                    <a class="btn btn-success" wire:click.prevent="goToEditUser( {{$user->id }})"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" wire:click.prevent ="confirmDeleteUser('{{ str_replace("'","\'",$user->prenom) }} {{ str_replace("'","\'",$user->nom) }}', {{ $user->id }})"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4">
                                    <div class="items-center">
                                        <img src="{{asset('images/empty.svg')}}" alt="" width="50px" height="60px">
                                        <div>Aucun élément n'a été trouvé</div> 
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
        
        </div>
    
    </div>
</div>