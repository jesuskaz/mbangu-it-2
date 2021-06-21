<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="<?php echo base_url().'assets/img/bangu.png';?>" class="header-logo" /> <span
                class="logo-name">MBANGU PAY</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="<?php echo site_url('Manager');?>" class="nav-link"><i data-feather="monitor"></i><span>Accueil</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Banque</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url("AdmBanque/loadBanque");?>">Liste de Banque</a></li>
                <li><a class="nav-link" href="<?php echo site_url("AdmBanque/addBanque");?>">Ajouter Banque</a></li>
                <li><a class="nav-link" href="<?php echo site_url("AdmCompte/listeCompte");?>">Liste de comptes</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Université</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url("AdmUniversite/loadUniversite");?>">Liste Université</a></li>
                <li><a class="nav-link" href="<?php echo site_url("AdmUniversite/addUniversite");?>">Ajouter Université</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Faculté</span></a>
              <ul class="dropdown-menu">
              <li><a class="nav-link" href="#">Ajouter faculté</a></li>
                <li><a class="nav-link" href="<?php echo site_url("AdmFaculte/listeFaculte"); ?>">Liste de faculté</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Etudiant</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url("AdmEtudiant/listeEtudiant"); ?>">Voir la liste des Etudiants</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Rapport</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url("AdmEtudiant/listePaiement")?>">Liste de paiement</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="<?php  ?>" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Se deconnecter</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url('Index'); ?>">Deconnecter</a></li>
              </ul>
            </li>
          </ul>
        </aside>