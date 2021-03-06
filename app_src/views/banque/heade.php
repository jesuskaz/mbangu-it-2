<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <?php
  $bank  = $this->db->where('idbanque', (int)  $this->session->bank_session)->get('banque')->result();
  $nom = '';
  if (count($bank)) {
    $bank = $bank[0];
    $nom = $bank->denomination;
  }

  ?>
  <title>Banque <?= $nom  ?></title>
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/app.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/bundles/owlcarousel2/dist/assets/owl.carousel.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/bundles/owlcarousel2/dist/assets/owl.theme.default.min.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/style.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/components.css'; ?>">
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/custom.css'; ?>">
  <link rel='shortcut icon' type='image/x-icon' href="<?php echo base_url() . 'assets/img/favicon.ico'; ?>" />

  <link rel="stylesheet" href="<?php echo base_url() . 'assets/bundles/fullcalendar/fullcalendar.min.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/bundles/jquery-selectric/selectric.css'; ?>">

  <link rel='shortcut icon' type='image/x-icon' href="<?php echo base_url() . 'assets/img/favicon.ico'; ?>" />
  <style>
    .page-item.active .page-link {
      color: #fff !important;
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
    }
    .page-link {
      color: #ffc107 !important;
      background-color: #fff !important;
      border: 1px solid #dee2e6 !important;
    }

    .page-link:hover {
      color: #fff !important;
      background-color: #ffc107 !important;
      border-color: #ffc107 !important;
    }
  </style>
</head>