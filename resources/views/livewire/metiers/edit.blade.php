<div class="modal fade " id="editModal"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Edition des métiers</h5>
            </div>
            <form wire:submit.prevent="updateMetier">
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
                                    <label for="editMetier.nom">Nom</label>
                                    <input id="editMetier.nom" type="text" class="form-control @error('editMetier.nom') is-invalid @enderror" wire:model="editMetier.nom">
                                </div>

                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editMetier.filiere_id">Filière</label>
                                    <select id="editMetier.filiere_id" class="form-control @error('editMetier.filiere_id')
                                    is-invalid @enderror" wire:model="editMetier.filiere_id">
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
                    <div>
                        @if ($editHasChanged)
                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger" wire:click="closeEditModal">Fermer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>