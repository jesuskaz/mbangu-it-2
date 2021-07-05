<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo site_url('banquee'); ?>"> <img alt="image" src="<?php echo base_url() . 'assets/img/bangu.png' ?>" class="header-logo" /> <span class="logo-name">MBANGUPAY</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown">
      <a href="<?php echo site_url('banquee'); ?>" class="nav-link"><i class="fa fa-home"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Univercité</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/universite'); ?>">Liste des universités</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Impression</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="#">Liste de facturette</a></li>
        <li><a class="nav-link" href="<?php echo site_url('banquee/paiement'); ?>">Journal de paiement</a></li>
        <li><a class="nav-link" href="#">Historique de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-user-graduate"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/etudiantListe'); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class=" fa fa-cog"></i><span>Paramètres</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banquee/profil"); ?>">Profil</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-sign-out-alt"></i><span>Se déconnecter</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('Index/deconnexion'); ?>">déconnexion</a></li>
      </ul>
    </li>
  </ul>
</aside>