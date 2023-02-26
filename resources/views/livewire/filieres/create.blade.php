<div class="modal fade " id="modalAdd"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Ajout des filières</h5>
            </div>
            <form wire:submit.prevent="addFiliere">
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
                                    <label for="newFiliere.nom">Nom</label>
                                    <input id="newFiliere.nom" type="text" class="form-control @error('newFiliere.nom') is-invalid @enderror" wire:model="newFiliere.nom">
                                </div>

                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newFiliere.service_id">Service</label>
                                    <select id="newFiliere.service_id" class="form-control @error('newFiliere.service_id')
                                    is-invalid @enderror" wire:model="newFiliere.service_id">
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
                    <button type="submit" class="btn btn-success">Ajouter</button>
                    <button type="button" class="btn btn-danger" wire:click="closeModal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>