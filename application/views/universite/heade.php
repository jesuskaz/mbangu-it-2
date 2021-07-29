<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<?php
	$univ  = $this->db->where('iduniversite', (int)  $this->session->universite_session)->get('universite')->result();
	$annee  = $this->db->where(['iduniversite' => (int)  $this->session->universite_session, 'actif' => 1])->get('anneeAcademique')->result();
	$nom = $an = '';
	if (count($univ)) {
		$univ = $univ[0];
		$nom = $univ->nomUniversite;
	}

	if (count($annee)) {
		$annee = $annee[0];
		$an = " | AA - $annee->annee";
	}
	?>
	<title>Université <?= $nom . $an ?></title>
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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