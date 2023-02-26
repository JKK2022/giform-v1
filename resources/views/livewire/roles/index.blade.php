<div>
    
    @include("livewire.roles.list")    

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
    });

    window.addEventListener("showEditForm",function(e){
        Swal.fire({
            title: "Edition d'un rôle",
            input: 'text',
            inputValue: e.detail.role.nom,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Modifier <i class="fa fa-check"></i>',
            cancelButtonText:'Annuler <i class="fa fa-times"></i>',
            inputValidator: (value) => {
                if (!value) {
                    return 'Chamo obligatoire !'
                }
                   
                @this.updateRole(e.detail.role.id, value)

            }
        })
    });

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
                if(event.detail.message.data.role_id){
                    @this.deleteRole(event.detail.message.data.role_id);
                }
            }

        });

    });
</script>

