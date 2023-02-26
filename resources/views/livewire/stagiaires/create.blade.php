<div class="modal fade " id="modalAdd"  data-bs-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-users"></i> Ajout des stagiaires</h5>
            </div>
            <form wire:submit.prevent="addStagiaire" enctype="multipart/form-data">
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
                                    <label for="newStagiaire.nom">Nom</label>
                                    <input id="newStagiaire.nom" type="text" class="form-control @error('newStagiaire.nom') is-invalid @enderror" wire:model="newStagiaire.nom">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.postnom">Post-nom</label>
                                    <input id="newStagiaire.postnom" type="text" class="form-control @error('newStagiaire.postnom') is-invalid @enderror" wire:model="newStagiaire.postnom">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="newStagiaire.prenom">Prénom</label>
                                    <input id="newStagiaire.prenom" type="text" class="form-control @error('newStagiaire.prenom') is-invalid @enderror" wire:model="newStagiaire.prenom">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.sexe">Sexe</label>
                                    <select id="newStagiaire.sexe" class="form-control @error('newStagiaire.sexe')
                                    is-invalid @enderror" wire:model="newStagiaire.sexe">
                                        <option value="">--- Tous ---</option>
                                        <option value="H">Homme</option>
                                        <option value="F">Femme</option>
                                    </select>
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.lieuNaissance">Lieu de naissance</label>
                                    <input id="newStagiaire.lieuNaissance" type="text" class="form-control @error('newStagiaire.lieuNaissance') is-invalid @enderror" wire:model="newStagiaire.lieuNaissance">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="newStagiaire.dateNaissance">Date de naissance</label>
                                    <input id="newStagiaire.dateNaissance" type="date" class="form-control @error('newStagiaire.dateNaissance') is-invalid @enderror" wire:model="newStagiaire.dateNaissance">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.email">E-mail</label>
                                    <input id="newStagiaire.email" type="text" class="form-control @error('newStagiaire.email')is-invalid @enderror" wire:model="newStagiaire.email">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.telephone1">Téléphone 1</label>
                                    <input id="newStagiaire.telephone1" type="text" class="form-control @error('newStagiaire.telephone1') is-invalid @enderror" wire:model="newStagiaire.telephone1">
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.telephone2">Téléphone 2</label>
                                    <input id="newStagiaire.telephone2" type="text" class="form-control @error('newStagiaire.telephone2') is-invalid @enderror" wire:model="newStagiaire.telephone2">
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.adresse">Adresse</label>
                                    <textarea wire:model="newStagiaire.adresse" id="newStagiaire.adresse" rows="3" class="form-control @error('newStagiaire.adresse') is-invalid @enderror"></textarea>
                                </div>
                                <div class="form-group flex-grow-1 mr-3">
                                    <label for="newStagiaire.nomPere">Noms du père</label>
                                    <input id="newStagiaire.nomPere" type="text" class="form-control @error('newStagiaire.nomPere')
                                    is-invalid @enderror" wire:model="newStagiaire.nomPere">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label for="newStagiaire.nomMere">Noms du mère</label>
                                    <input id="newStagiaire.nomMere" type="text" class="form-control @error('newStagiaire.nomMere')
                                    is-invalid @enderror" wire:model="newStagiaire.nomMere">
                                </div>
                            </div>
        
                        </div>

                        <div class="p-4 col-4">
                            <div class="form-group">
                                <input type="file" wire:model='newPhoto' class="form-control @error('newPhoto')
                                is-valid @enderror" id="image{{$fileInputIterator}}">
                            </div>
                            Photo du stagiaire:
                            <div style="border: 1px solid #d0d1d3;border-radius:20px;height:200px;width:200px;overflow: hidden;">
                                @if ($newPhoto)
                                    <img src="{{ $newPhoto->temporaryUrl() }}" width="292px" style="border: 1px solid #d0d1d3;border-radius:20px;width:200px; height:200px;">
                                @endif
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

