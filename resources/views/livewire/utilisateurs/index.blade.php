
<div wire:ignore.self>

    @if ($currentPage == PAGE_CREATE_FORM)
        @include('livewire.utilisateurs.create')
    @endif

    @if ($currentPage == PAGE_EDIT_FORM)
        @include('livewire.utilisateurs.edit')
    @endif

    @if ($currentPage == PAGE_LIST)
        @include('livewire.utilisateurs.list') 
    @endif

</div>

<script>
    window.addEventListener("showSuccessMessage", event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: event.detail.message || "Opération effectuée avec succès",
            showConfirmButton: false,
            timer: 3000
        })
    })
</script>


<script>
    window.addEventListener("showConfirmMessage", event => {
        Swal.fire({
                title: event.detail.message.title,
                text: event.detail.message.text,
                icon: event.detail.message.type,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, continuer !',
                cancelButtonText:'Annuler'
            }).then((result) => {
            if (result.isConfirmed) {
                if(event.detail.message.data){
                    @this.deleteUser(event.detail.message.data.user_id);
                }else{
                    @this.resetPassword();
                }

            }

        });

    });
</script>