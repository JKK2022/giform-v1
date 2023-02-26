<div class="modal fade " id="editModal"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Edition des filières</h5>
            </div>
            <form wire:submit.prevent="updateFiliere">
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
                                    <label for="editFiliere.nom">Nom</label>
                                    <input id="editFiliere.nom" type="text" class="form-control @error('editFiliere.nom') is-invalid @enderror" wire:model="editFiliere.nom">
                                </div>

                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editFiliere.service_id">Service</label>
                                    <select id="editFiliere.service_id" class="form-control @error('editFiliere.service_id')
                                    is-invalid @enderror" wire:model="editFiliere.service_id">
                                        <option value="">--- Choirir le service ---</option>
                                        @foreach ($servicesList as $item)
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
                            <button type="submit" class="btn btn-success">Metrre à jour</button>
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