<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light" style="font-size: 1.3em;"><b>GIFORM</b></span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/images/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ userFullName() }}</a>
                <small class="text-white-50">{{ getRolesName() }}</small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ setMenuActive('home') }}"><i class="nav-icon fas fa-home"></i>
                        <p>Accueil</p>
                    </a>
                </li>
                
                {{-- Manager --}}
                @can("manager")
                    <li class="nav-item">
                        <a href="" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Tableau de bord</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link active">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Vue globale</p>
                                </a>
                            </li>
                        </ul>
                    </li>  
                @endcan

                {{-- Administrateur --}}
                @can("admin")
                    <li class="nav-item {{ setMenuClass('admin.habilitations.', 'menu-open') }}">

                        <a href="" class="nav-link {{ setMenuClass('admin.habilitations.', 'active') }}"><i class="nav-icon fas fa-user-shield"></i>
                            <p>Habilitations</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.habilitations.users.index') }}" class="nav-link {{ setMenuActive('admin.habilitations.users.index') }}">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>Utilisateurs</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.habilitations.roles.index') }}" class="nav-link {{ setMenuActive('admin.habilitations.roles.index') }}">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>Rôles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.habilitations.permissions.index') }}" class="nav-link {{ setMenuActive('admin.habilitations.permissions.index') }}">
                                    <i class="nav-icon fas fa-fingerprint"></i>
                                    <p>Permissions</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                @endcan

                {{-- Conseillers --}}
                @can("conseiller")

                    <li class="nav-item">
                        <a href="{{ route('conseillers.parametres.services.index') }}" class="nav-link {{ setMenuActive('conseillers.parametres.services.index') }}">
                            <i class="nav-icon fas fa-window-restore"></i>
                            <p>Services</p>
                        </a>
                    </li>

                    {{-- Gestion des formations --}}
                    <li class="nav-item {{ setMenuClass('conseillers.gestformations.', 'menu-open') }}">
                        <a href="" class="nav-link {{ setMenuClass('conseillers.gestformations.', 'active') }}"><i class="fas fa-th"></i>
                            <p>Gestion formations</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.gestformations.filieres.index') }}" class="nav-link {{ setMenuActive('conseillers.gestformations.filieres.index') }}">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Filières</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.gestformations.typesformations.index') }}" class="nav-link {{ setMenuActive('conseillers.gestformations.typesformations.index') }}">
                                    <i class="nav-icon fa fa-tasks"></i>
                                    <p>Type formation</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.gestformations.metiers.index') }}" class="nav-link {{ setMenuActive('conseillers.gestformations.metiers.index') }}">
                                    <i class="nav-icon fas fa-list-ol"></i>
                                    <p>Métiers</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.gestformations.modules.index') }}" class="nav-link {{ setMenuActive('conseillers.gestformations.modules.index') }}">
                                    <i class="nav-icon fas fa-th-list"></i>
                                    <p>Modules</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Gestion des stagiaires --}}
                    <li class="nav-item {{ setMenuClass('conseillers.geststagiaires.', 'menu-open') }}">
                        <a href="" class="nav-link {{ setMenuClass('conseillers.geststagiaires.', 'active') }}"><i class="fas fa-graduation-cap"></i>
                            <p>Gestion stagiaires</p>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.geststagiaires.stagiaires.index') }}" class="nav-link {{ setMenuClass('conseillers.geststagiaires.stagiaires.index', 'active') }}"><i class="fa fa-user-graduate"></i>
                                    <p>Stagiaires</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('conseillers.geststagiaires.typestagiaires.index') }}" class="nav-link {{ setMenuClass('conseillers.geststagiaires.typestagiaires.index', 'active') }}"><i class="fas fa-users"></i>
                                    <p>Type stagiaire</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('conseillers.gestpaiements.motifs.index') }}" class="nav-link {{ setMenuClass('conseillers.gestpaiements.motifs.index', 'active') }}"><i class="nav-icon fas fa-coins"></i>
                            <p>Motifs de paiement</p>
                        </a>
                    </li>
                @endcan

            </ul>
        </nav>

    </div>

</aside>