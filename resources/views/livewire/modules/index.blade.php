<div>
    {{-- Add--}}
    @include("livewire.modules.create")
    
    {{-- Update--}}
    @if ($editModule != [])     
        @include("livewire.modules.edit")
    @endif

    {{-- Liste --}}
    @include("livewire.modules.list")    

</div>

@push('script')
    
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

        window.addEventListener("showEditForm",function(e){
            Swal.fire({
                title: "Edition d'un module",
                input: 'text',
                inputValue: e.detail.module.nom,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Modifier <i class="fa fa-check"></i>',
                cancelButtonText:'Annuler <i class="fa fa-times"></i>',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Chamo obligatoire !'
                    }
                    
                    @this.updateModule(e.detail.module.id, value)

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
                    if(event.detail.message.data.module_id){
                        @this.deleteModule(event.detail.message.data.module_id);
                    }
                }

            });

        });

        window.addEventListener("showModal", event => {
            $("#modalAdd").modal("show");
        })

        window.addEventListener("closeModal", event => {
            $("#modalAdd").modal("hide");
        })

        window.addEventListener("showEditModal", event => {
            $("#editModal").modal("show");
        })

        window.addEventListener("closeEditModal", event => {
            $("#editModal").modal("hide");
        })
    </script>
    
@endpush