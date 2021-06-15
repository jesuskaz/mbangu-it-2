<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="#"> <img alt="image" src="<?php echo base_url() . 'assets/img/bangu.png' ?>" class="header-logo" /> <span class="logo-name">MBANGU PAY</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown">
      <a href="<?php echo site_url('banquee'); ?>" class="nav-link"><i data-feather="monitor"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url('Index'); ?>" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Univercité</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/universite'); ?>">Liste des universités</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Impression</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="#">Liste de facturette</a></li>
        <li><a class="nav-link" href="<?php echo site_url('banquee/paiement'); ?>">Journal de paiement</a></li>
        <li><a class="nav-link" href="#">Historique de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/etudiantListe'); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url('Index'); ?>" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Se déconnecter</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('Index/deconnexion'); ?>">déconnexion</a></li>
      </ul>
    </li>
  </ul>
</aside>