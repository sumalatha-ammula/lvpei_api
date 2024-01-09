<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LV Prasad Eye Hospital - Ravi</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?= $this->Html->css(['summernote-lite.min', 'adminlte.min','umespace']); ?>
  <?php echo $this->Html->script(['jquery.min', 'bootstrap.bundle.min','jquery.validate.min', 'additional-methods.min','summernote-lite.min', 'adminlte']); ?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?= $this->Html->css(['owl.carousel.min', 'bootstrap.min','select2.min']); ?> <!-- Include CSS files -->
    <?= $this->Html->css('font/style.css'); ?>
    <?= $this->Html->css('bootstrap/select2-bootstrap4.min.css'); ?>
    <?= $this->Html->script(['jquery-3.3.1.min', 'popper.min','bootstrap.min','main','lc_switch','select2.full.min']); ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/css/dataTables.bootstrap4.min.css" />
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
  var baseURL = "<?php echo $this->Url->build('/', array('fullBase'=>true)); ?>";
  </script>
<style>
.card-header .card-tools {
	float: none;
}

.card-header .card-tools a.btn-block {
	float: right;
	width: auto;
	display: inline-block;
}
</style>
</head>
<div class="wrapper">
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
		</ul>
		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<!-- Navbar Search -->
			</a>
			<div class="navbar-search-block">
				<form class="form-inline">
					<div class="input-group input-group-sm">
						<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-navbar" type="submit">
								<i class="fas fa-search"></i>
							</button>
							<button class="btn btn-navbar" type="button" data-widget="navbar-search">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
				</form>
			</div>
			</li>
			<!-- Messages Dropdown Menu -->
			<!-- Notifications Dropdown Menu -->
			<li class="nav-item dropdown"><a class="nav-link" data-toggle="dropdown" href="#"> <i class="far fa-bell"></i> <span class="badge badge-warning navbar-badge">15</span>
			</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
					<span class="dropdown-item dropdown-header">15 Notifications</span>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item"> <i class="fas fa-envelope mr-2"></i> 4 new messages <span class="float-right text-muted text-sm">3 mins</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item"> <i class="fas fa-users mr-2"></i> 8 friend requests <span class="float-right text-muted text-sm">12 hours</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item"> <i class="fas fa-file mr-2"></i> 3 new reports <span class="float-right text-muted text-sm">2 days</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div></li>
			<li class="nav-item"><a class="nav-link" data-widget="fullscreen" href="#" role="button"> <i class="fas fa-expand-arrows-alt"></i>
			</a></li>
			<li class="nav-item"><a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"> <i class="fas fa-th-large"></i>
			</a></li>
		</ul>
	</nav>
	<!-- /.navbar -->
	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="#" class="brand-link"> <span class="brand-text font-weight-light">RAVIAPP</span>
		</a>
		<div class="sidebar">
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					
					<li class="nav-item "><a href="dashboard" class="nav-link <?php echo ($action == 'dashboard')?'active':''; ?>"> <i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
					</a></li>
					<li class="nav-item">
					<?php
					echo $this->Html->link ( '<i class="nav-icon fas fa-user"></i><p>Feildex Ecutive</p>', [ 
							'controller' => "admin",
							"action" => "feildexecutive" 
					], [ 
							'escape' => false,
							'class' => 'nav-link ' . (($action == 'feildexecutive') ? 'active' : '') 
					] );
					?>
		            </li>
		            <li class="nav-item">
					<?php
					echo $this->Html->link ( '<i class="nav-icon fas fa-user"></i><p>Master Main</p>', [ 
							'controller' => "admin",
							"action" => "mastermain" 
					], [ 
							'escape' => false,
							'class' => 'nav-link ' . (($action == 'mastermain') ? 'active' : '') 
					] );
					?>
		            </li>
		            <li class="nav-item">
					<?php
					echo $this->Html->link ( '<i class="nav-icon fas fa-user"></i><p>Survey Data</p>', [ 
							'controller' => "admin",
							"action" => "rvappsurveydata" 
					], [ 
							'escape' => false,
							'class' => 'nav-link ' . (($action == 'rvappsurveydata') ? 'active' : '') 
					] );
					?>
		            </li>
		           
					<li class="nav-item">
            <?php
												echo $this->Html->link ( '<i class="nav-icon fas fa-sign-in-alt"></i><p>Logout</p>', [ 
														'controller' => "admin",
														"action" => "logout" 
												], [ 
														'escape' => false,
														'class' => 'nav-link' 
												] );
												?>
    		</li>
				</ul>
			</nav>
		</div>
	</aside>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header"></section>
		<div class="content">
			<div class="container-fluid">
    <?= $this->Flash->render() ?>
     <?= $this->fetch('content') ?>
   </div>
		</div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
</body>
</html>
