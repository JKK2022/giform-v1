<div class="modal fade " id="modalAdd"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Ajout des modules de formation</h5>
            </div>
            <form wire:submit.prevent="addModule">
                @csrf
                <div class="modal-body">
                        <div class="my-2 bg-gray-light p-2">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Erreurs !</h5>
                                    @foreach ($errors->all() as $error)
                                        <ul>
                                            <li>{{$error}}</li>
                                        </ul>
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newModule.nom">Nom</label>
                                    <input id="newModule.nom" type="text" class="form-control @error('newModule.nom') is-invalid @enderror" wire:model="newModule.nom">
                                </div>

                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newModule.filiere_id">Filière</label>
                                    <select id="newModule.filiere_id" class="form-control @error('newModule.filiere_id')
                                    is-invalid @enderror" wire:model="newModule.filiere_id">
                                        <option value="">--- Choirir la filière ---</option>
                                        @foreach ($filieresList as $item)
                                            <option value={{$item->id}}>{{$item->nom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ajouter</button>
                    <button type="button" class="btn btn-danger" wire:click="closeModal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>