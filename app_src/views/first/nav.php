<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<nav class="fh5co-nav" role="navigation">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <div id="fh5co-logo">
                        <a href="<?= site_url() ?>">
                            <img alt="image" src="<?= base_url('first/images/bangu.png') ?>" class="header-logo" />
                            Mbangu
                        </a>
                    </div>
                </div>
                <div class="col-xs-8 text-right menu-1">
                    <ul>
                        <li class="active"><a href="<?= site_url(); ?>">Accueil</a></li>
                        <li><a href="<?= site_url('index/about'); ?>">A Propos </a></li>
                        <li><a href="<?= site_url('index/process'); ?>">Comment ça marche</a></li>
                        <li><a href="#">Information</a></li>
                        <li><a href="<?= base_url('index/contact'); ?>">Contact</a></li>
                        <li class="btn-cta"><a href="<?= site_url('index/login') ?>"><span>Login</span></a></li>
                        <li class="btn-cta"><a href="#"><span>Crée un compte</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>