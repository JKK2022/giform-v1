<div class="row p-4 pt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fas fa-list"></i> Liste des filières</h3>
                <div class="card-tools d-flex align-items-center">
                    <a class="btn btn-link text-white mr-4 d-block" wire:click.prevent='showAddFiliereModal'><i class="fas fa-plus" ></i> Nouvelle filière</a>
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

                <div class="d-flex justify-content-end p-2 bg-indigo">
                    <div class="form-group mr-3">
                        <label for="filtreService">Filtrer par service</label>
                        <select id="filtreService" wire:model="filtreService" class="form-control">
                            <option value="">--- Tous ---</option>
                            @foreach ($servicesList as $item) 
                                <option value={{ $item->id }}>{{ $item->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>Filière</th>
                            <th>Service</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filieresList as $item)
                            <tr>
                                <td>{{ $item->nom }}</td>
                                <td>{{ $item->service->nom }}</td>
                                <td class="text-center">
                                    <a class="btn btn-success" wire:click="editFiliere({{ $item->id }})"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-danger" wire:click="confirmDeleteFiliere('{{ str_replace("'","\'",$item->nom) }}', {{ $item->id }})"><i class="far fa-trash-alt"></i></a>
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
                    {{ $filieresList->links() }}
                </div>
            </div>
        
        </div>
    
    </div>
</div>
