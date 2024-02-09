<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Menu Principal</span>
                </li>
                
                <li class="nav-item">
                    <a href="{{route('accueil')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Tableau de Bord</span>
                    </a>
                </li>

                @if (Session::get('role_name') === 'Super Admin')
                <li class="submenu {{set_active(['liste/utilisateurs'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-shield-alt"></i>
                        <span>Utilisateurs</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.users') }}" class="{{set_active(['liste/utilisateurs'])}} {{ (request()->is('view/user/edit/*')) ? 'active' : '' }}">Liste des utilisateurs</a></li>
                        <li><a href="{{ route('add.user') }}">Ajouter un utilisateur</a></li>
                    </ul>
                </li>
                @endif

               
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span>Productions</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="#">Productions</a></li>
                        <li><a href="#">Ajouter production</a></li>
                        @if (Session::get('role_name') === 'Super Admin')
                        <li><a href="#">Détails de production</a></li>
                        @endif
                    </ul>
                </li> -->

                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span> Sinistres AT & RD</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="#">Sinistres AT & RD</a></li>
                        <li><a href="#">Ajoutr sinistre AT & RD</a></li>
                        @if (Session::get('role_name') === 'Super Admin')
                        <li><a href="#">Détails de sinistre AT&RD</a></li>
                        @endif
                    </ul>
                </li> -->

                
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span>Réglements/chèque</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.reglement-cheques') }}">Réglements</a></li>
                        <li><a href="{{ route('add.reglement-cheque') }}">Ajouter Réglement</a></li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-clipboard"></i>
                        <span>Chéques Débits</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.checks-debit') }}">Chéques débits</a></li>
                        <li><a href="{{ route('add.check-debit') }}">Ajouter chéque</a></li>
                       
                    </ul>
                </li>
                @if (Session::get('role_name') === 'Super Admin')
                
                <li class="menu-title">
                    <span>Gestion</span>
                </li>

                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Chéquiers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.checkbooks') }}">chéquiers</a></li>
                        <li><a href="{{ route('add.checkbook') }}">Ajouter chéquier</a></li>
                    </ul>
                </li> -->
                
                <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Paramètres/chèques</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.checkbooks') }}">chéquiers</a></li>
                        <!-- <li><a href="{{ route('add.checkbook') }}">Ajouter chéquier</a></li> -->
                        <li><a href="{{ route('all.compagnies') }}">Compagnies</a></li>
                        <!-- <li><a href="{{ route('add.compagnie') }}">Ajouter compagnie</a></li> -->
                        <li><a href="{{ route('all.banks') }}">Banques</a></li>
                        <!-- <li><a href="{{ route('add.bank') }}">Ajouter Banque</a></li> -->
                        <li><a href="{{ route('all.services') }}">Services</a></li>
                        <!-- <li><a href="{{ route('add.service') }}">Ajouter Service</a></li> -->
                        <li><a href="{{ route('all.courtiers') }}">Courtiers</a></li>
                        <!-- <li><a href="{{ route('add.courtier') }}">Ajouter Courtier</a></li> -->
                        <li><a href="{{ route('all.affectations') }}">Affectations</a></li>
                        <!-- <li><a href="{{ route('add.affectation') }}">Ajouter Affectation</a></li> -->
                        <li><a href="{{ route('all.sous-comptes') }}">Sous comptes</a></li>
                        <!-- <li><a href="{{ route('add.sous-compte') }}">Ajouter Sous compte</a></li> -->
                        <li><a href="{{ route('all.compte-depenses') }}">Compte de dépenses</a></li>
                        <!-- <li><a href="{{ route('add.compte-depense') }}">Ajouter Compte de dépense</a></li> -->
                        <li><a href="{{ route('all.bene-comptes') }}">Bénéficiaires par comptes</a></li>
                        <!-- <li><a href="{{ route('add.bene-compte') }}">Ajouter Bénéficiaire par compte</a></li> -->
                        
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Paramètres/Effets</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.carnets-effets') }}">Carnets Effets</a></li>
                        <!-- <li><a href="{{ route('add.carnet-effet') }}">Ajouter Effet</a></li> -->

                        <!-- <li><a href="{{ route('all.compagnies') }}">Compagnies</a></li> -->
                        <!-- <li><a href="{{ route('add.compagnie') }}">Ajouter compagnie</a></li> -->

                        <!-- <li><a href="{{ route('all.banks') }}">Banques</a></li> -->
                        <!-- <li><a href="{{ route('add.bank') }}">Ajouter Banque</a></li> -->

                        <!-- <li><a href="{{ route('all.effet-services') }}">Services</a></li> -->
                        <!-- <li><a href="{{ route('add.effet-service') }}">Ajouter Service</a></li> -->

                        <!-- <li><a href="{{ route('all.courtiers') }}">Courtiers</a></li> -->
                        <!-- <li><a href="{{ route('add.courtier') }}">Ajouter Courtier</a></li> -->

                        <li><a href="{{ route('all.effet-affectations') }}">Affectations</a></li>
                        <li><a href="{{ route('add.effet-affectation') }}">Ajouter Affectation</a></li>

                        <!-- <li><a href="{{ route('all.sous-comptes') }}">Sous comptes</a></li> -->
                        <!-- <li><a href="{{ route('add.sous-compte') }}">Ajouter Sous compte</a></li> -->

                        <!-- <li><a href="{{ route('all.compte-depenses') }}">Compte de dépenses</a></li> -->
                        <!-- <li><a href="{{ route('add.compte-depense') }}">Ajouter Compte de dépense</a></li> -->

                        <!-- <li><a href="{{ route('all.bene-comptes') }}">Bénéficiaires par comptes</a></li> -->
                        <!-- <li><a href="{{ route('add.bene-compte') }}">Ajouter Bénéficiaire par compte</a></li> -->
                       
                        
                    </ul>
                </li>
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Compagnies</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                    <li><a href="{{ route('all.compagnies') }}">Compagnies</a></li>
                        <li><a href="{{ route('add.compagnie') }}">Ajouter compagnie</a></li>
                    </ul>
                </li> -->
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Banques</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.banks') }}">Banques</a></li>
                        <li><a href="{{ route('add.bank') }}">Ajouter Banque</a></li>
                    </ul>
                </li> -->
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Services</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.services') }}">Services</a></li>
                        <li><a href="{{ route('add.service') }}">Ajouter Service</a></li>
                    </ul>
                </li> -->
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Courtiers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.courtiers') }}">Courtiers</a></li>
                        <li><a href="{{ route('add.courtier') }}">Ajouter Courtier</a></li>
                    </ul>
                </li> -->
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Affectations</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.affectations') }}">Affectations</a></li>
                        <li><a href="{{ route('add.affectation') }}">Ajouter Affectation</a></li>
                    </ul>
                </li> -->
                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Sous comptes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.sous-comptes') }}">Sous comptes</a></li>
                        <li><a href="{{ route('add.sous-compte') }}">Ajouter Sous compte</a></li>
                    </ul>
                </li> -->

                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Compte de dépenses</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.compte-depenses') }}">Compte de dépenses</a></li>
                        <li><a href="{{ route('add.compte-depense') }}">Ajouter Compte de dépense</a></li>
                    </ul>
                </li> -->

                <!-- <li class="submenu">
                    <a href="#"><i class="fas fa-cog"></i>
                        <span>Bénéficiaires par comptes</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('all.bene-comptes') }}">Bénéficiaires par comptes</a></li>
                        <li><a href="{{ route('add.bene-compte') }}">Ajouter Bénéficiaire par compte</a></li>
                    </ul>
                </li> -->
                
                @endif
            </ul>
        </div>
    </div>
</div>