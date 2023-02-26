<div class="row p-4 pt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fa fa-user-graduate"></i> Liste des stagiaires</h3>
                <div class="card-tools d-flex align-items-center">
                    <a class="btn btn-link text-white mr-4 d-block" wire:click.prevent='showAddStagiaireModal'><i class="fas fa-user-plus" ></i> Nouveau stagiaire</a>
                    <div class="input-group input-group-md" style="width: 200px;">
                        <input type="text" name="table_search" wire:model.debounce="search" class="form-control float-right" placeholder="Recherche">
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
                            <th class="text-center">Photo</th>
                            <th class="text-center">Matricule</th>
                            <th>Stagiaire</th>
                            <th class="text-center" style="width:5%;">Sexe</th>
                            <th class="text-center">Lieu de naissance</th>
                            <th class="text-center">Téléphone 1</th>
                            <th class="text-center">Téléphone 2</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stagiairestList as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->photo->photo != "" || $item->photo->photo != null)
                                        <img src="{{asset('storage/'.$item->photo->photo)}}" alt="" width="50" height="50" >
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->matricule }}</td>
                                <td>{{ $item->prenom }} {{ $item->nom }} {{ $item->postnom }}</td>
                                <td class="text-center">
                                    @if($item->sexe === "F")
                                        <img src="{{ asset('images/femme.png') }} " width="24" />
                                    @else
                                        <img src="{{ asset('images/homme.png') }} " width="24" />
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->lieu_naissance }}</td>
                                <td class="text-center">{{ $item->telephone1 }}</td>
                                <td class="text-center">{{ $item->telephone2 }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success" wire:click="editStagiaire({{ $item->id }})"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" wire:click="confirmDeleteStagiaire('{{ str_replace("'","\'",$item->prenom) }} {{ str_replace("'","\'",$item->nom) }} {{ str_replace("'","\'",$item->postnom) }}', {{ $item->id }})"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center p-4">
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
                    {{ $stagiairestList->links() }}
                </div>
            </div>
        
        </div>
    
    </div>
</div>