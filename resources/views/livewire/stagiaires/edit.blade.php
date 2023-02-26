<div class="modal fade " id="editModal"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-users"></i> Edition des stagiaires</h5>
            </div>
            <form wire:submit.prevent="updateStagiaire" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="my-2 bg-gray-light p-2 col-8">
                            
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
                                    <label for="editStagiaire.nom">Nom</label>
                                    <input id="editStagiaire.nom" type="text" class="form-control @error('editStagiaire.nom') is-invalid @enderror" wire:model="editStagiaire.nom">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.postnom">Post-nom</label>
                                    <input id="editStagiaire.postnom" type="text" class="form-control @error('editStagiaire.postnom') is-invalid @enderror" wire:model="editStagiaire.postnom">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="editStagiaire.prenom">Prénom</label>
                                    <input id="editStagiaire.prenom" type="text" class="form-control @error('editStagiaire.prenom') is-invalid @enderror" wire:model="editStagiaire.prenom">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.sexe">Sexe</label>
                                    <select id="editStagiaire.sexe" class="form-control @error('editStagiaire.sexe')
                                    is-invalid @enderror" wire:model="editStagiaire.sexe">
                                        <option value="">--- Tous ---</option>
                                        <option value="H">Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.lieu_naissance">Lieu de naissance</label>
                                    <input id="editStagiaire.lieu_naissance" type="text" class="form-control @error('editStagiaire.lieu_naissance') is-invalid @enderror" wire:model="editStagiaire.lieu_naissance">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="editStagiaire.date_naissance">Date de naissance</label>
                                    <input id="editStagiaire.date_naissance" type="date" class="form-control @error('editStagiaire.date_naissance') is-invalid @enderror" wire:model="editStagiaire.date_naissance">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.email">E-mail</label>
                                    <input id="editStagiaire.email" type="text" class="form-control @error('editStagiaire.email')is-invalid @enderror" wire:model="editStagiaire.email">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.telephone1">Téléphone 1</label>
                                    <input id="editStagiaire.telephone1" type="text" class="form-control @error('editStagiaire.telephone1') is-invalid @enderror" wire:model="editStagiaire.telephone1">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.telephone2">Téléphone 2</label>
                                    <input id="editStagiaire.telephone2" type="text" class="form-control @error('editStagiaire.telephone2') is-invalid @enderror" wire:model="editStagiaire.telephone2">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.adresse">Adresse</label>
                                    <textarea wire:model="editStagiaire.adresse" id="editStagiaire.adresse" rows="3" class="form-control @error('editStagiaire.adresse') is-invalid @enderror"></textarea>
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="editStagiaire.nom_pere">Noms du père</label>
                                    <input id="editStagiaire.nomP_pre" type="text" class="form-control @error('editStagiaire.nom_pere')
                                    is-invalid @enderror" wire:model="editStagiaire.nom_pere">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="editStagiaire.nom_mere">Noms du mère</label>
                                    <input id="editStagiaire.nom_mere" type="text" class="form-control @error('editStagiaire.nom_mere')
                                    is-invalid @enderror" wire:model="editStagiaire.nom_mere">
                                </div>
                            </div>
        
                        </div>

                        <div class="p-4 col-4">
                            <div class="form-group">
                                <input type="file" wire:model='editPhoto' class="form-control @error('editPhoto')
                                is-valid @enderror" id="image{{$fileInputIterator}}">
                            </div>
                            Photo du stagiaire:
                            <div style="border: 1px solid #d0d1d3;border-radius:20px;height:200px;width:200px;overflow: hidden;">
                                @if (isset($editPhoto))
                                    <img src="{{ $editPhoto->temporaryUrl() }}" style="width:200px; height:200px;">
                                @else
                                    <img src="{{ asset('storage/'.$editStagiaire['photo']['photo']) }}" style="width:200px; height:200px;">   
                                @endif
                            </div>
                            @isset($editPhoto)
                                <button type="button" class="p-2 m-2 btn btn-default btn-sm" style="border-radius: 10px;" wire:click="$set('editPhoto',null)">Réinitialiser l'image</button>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        @if ($editHasChanged)
                            <button type="submit" class="btn btn-success">Metrre à jour</button>
                        @endif
                    </div>
                    <button type="button" class="btn btn-danger" wire:click="closeEditModal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
