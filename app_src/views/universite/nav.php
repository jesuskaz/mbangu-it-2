<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<nav class="navbar navbar-expand-lg main-navbar sticky">
     <div class="form-inline mr-auto">
         <ul class="navbar-nav mr-3">
             <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg 
              collapse-btn"> <i data-feather="align-justify"></i></a></li>
             <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                     <i data-feather="maximize"></i>
                 </a>
             </li>
         </ul>
     </div>
     <ul class="navbar-nav navbar-right">
         <li class="dropdown">
             <?php
                $img = !empty($i = $univ->logo) ? base_url($i) : base_url('assets/img/bangu.png');
                ?>
             <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                 <span class="text-muted"><i class="fa fa-university"></i> <?= $univ->nomUniversite ?></span>
                 <img alt="image" src="<?= $img ?>" class="user-img-radious-style" width="30" height="30">
                 <span class="d-sm-none d-lg-inline-block"></span>
             </a>
             <div class="dropdown-menu dropdown-menu-right pullDown">
                 <div class="dropdown-title"><?= $univ->nomUniversite ?></div>
                 <a href="<?= site_url('banque/profil') ?>" class="dropdown-item has-icon">
                     <i class="far fa-user"></i> Profil
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="<?= site_url('index/deconnexion') ?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                     Déconnexion
                 </a>
             </div>
         </li>
     </ul>
 </nav>