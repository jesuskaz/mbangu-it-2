<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo site_url('banquee'); ?>"> <img alt="image" src="<?php echo base_url() . 'assets/img/bangu.png' ?>" class="header-logo" /> <span class="logo-name">MBANGUPAY</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="dropdown">
      <a href="<?php echo site_url('banquee'); ?>" class="nav-link"><i class="fa fa-home"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Université</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/universite'); ?>">Liste d'universités</a></li>
        <li><a class="nav-link" href="<?php echo site_url('banquee/etudiantListe'); ?>">Liste d'Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Ecole</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/ecole'); ?>">Liste d'Ecoles</a></li>
        <li><a class="nav-link" href="<?php echo site_url('banquee/eleve'); ?>">Liste d'Elèves</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Impression</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('banquee/paiement'); ?>">Journal de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-tag"></i><span>Annonces</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banquee/annonces"); ?>">Nos annonces</a></li>
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