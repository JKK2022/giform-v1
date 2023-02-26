
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GIFORM | Accueil</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            {{-- Barre supérieure --}}
            <x-topnavbar />

           {{-- Menu principal --}}
           <x-menu />

            <div class="content-wrapper">

                <div class="content">
                    <div class="container-fluid">

                        @yield('contenu')

                    </div>
                </div>

            </div>


            {{-- Profil et Déconnexion --}}
            <x-sidebar />

            {{-- Partie pied de page --}}
            <x-footer />
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script> --}}
        
        <!-- JavaScript Bundle with Popper -->

        {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
      
        @livewireScripts
        @stack('script')
    </body>
</html>
