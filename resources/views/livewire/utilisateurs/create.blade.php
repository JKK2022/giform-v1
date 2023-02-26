<div class="card card-primary p-4 pt-5">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus"></i> Formulaire de création d'un nouvel utilisateur</h3>
    </div>
    <form role="form" wire:submit.prevent='addUser'>
        <div class="card-body">

            <div class="d-flex">

                <div class="form-group flex-grow-1 mr-2">
                    <label>Nom</label>
                    <input type="text" class="form-control @error('newUser.nom') is-invalid @enderror" wire:model="newUser.nom">
                    @error('newUser.nom')
                        <span class="text-danger">{{ $message }}</span>    
                    @enderror
                </div>

                <div class="form-group flex-grow-1 mr-2">
                    <label>Prénom</label>
                    <input type="text" class="form-control @error('newUser.prenom') is-invalid @enderror" wire:model="newUser.prenom">
                    @error('newUser.prenom')
                        <span class="text-danger">{{ $message }}</span>    
                    @enderror
                </div>

                <div class="form-group flex-grow-1">
                    <label>Sexe</label>
                    <select wire:model="newUser.sexe" class="form-control @error('newUser.sexe') is-invalid @enderror">
                        <option value="">---------</option>
                        <option value="H">Homme</option>
                        <option value="F">Femme</option>
                    </select>
                    @error('newUser.sexe')
                        <span class="text-danger">{{ $message }}</span>    
                    @enderror
                </div>

            </div>
            
            <div class="form-group">
                <label>Adresse em-mail</label>
                <input type="email" class="form-control @error('newUser.email') is-invalid @enderror" wire:model="newUser.email">
                @error('newUser.email')
                    <span class="text-danger">{{ $message }}</span>    
                @enderror
            </div>

            <div class="d-flex">

                <div class="form-group flex-grow-1 mr-2">
                    <label>Téléphone 1</label>
                    <input type="text" class="form-control @error('newUser.telephone1') is-invalid @enderror" wire:model="newUser.telephone1">
                    @error('newUser.telephone1')
                        <span class="text-danger">{{ $message }}</span>    
                    @enderror
                </div>

                <div class="form-group flex-grow-1">
                    <label>Téléphone 2</label>
                    <input type="text" class="form-control" wire:model="newUser.telephone2">
                </div>

            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="text" class="form-control" placeholder="Password" disabled>
            </div>

        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <button type="button" class="btn btn-danger" wire:click='goToListUser'>Retourner à la liste des utilisateurs</button>
        </div>
    </form>
</div>