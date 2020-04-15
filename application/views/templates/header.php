<!-- Hello 
You can download this project on https://github.com/Viiskorda/spordiruumid
GPLv3
Under the GPL license, you may use Scheduler and this project without charge. You may even modify its source code and redistribute it under the same license. However, there is one big caveat. Any project that leverages Scheduler must be open source!
-->
<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>Pärnu Spordikeskuste Andmebaas</title>

    <!-- Styles -->
    
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-clockpicker.min.css" type="text/css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">  
    <link href="<?php echo base_url(); ?>assets/css/calendar.css" rel="stylesheet">
    
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
 	
 
  
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery-clock-timepicker.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    
</head>

<body>

<!-- Navigation -->
    <header>
        <nav class="navbar navbar-expand-md p-0 nav-bg">
            <div class="container p-0">
   

                <div class="navbar-header pr-lg-5 pr-md-3 pr-sm-1 pl-0">
                <a class="navbar-brand mr-1 py-1" href="<?php echo base_url(); ?>"><img class="logo" src="<?php echo base_url(); ?>assets/img/plv_vapp_blue.svg" alt="logo"></a>
                    <a class="navbar-brand align-middle p-0 text-white" href="<?php echo base_url(); ?>">Pärnu Linnavalitsus</a>
                </div>
                <!-- <button >"Logi sisse"</button> -->

               
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto mt-lg-0 pl-lg-3 pl-md-2 pl-sm-1">
								
									<?php if(array_key_exists('building',$this->session->userdata())){?>
											<?php if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'):?>
													<!-- <li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="#"><strong>Kõik ruumid</strong></a></li> -->
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>fullcalendar?roomId=<?php echo $this->session->userdata('room');?>">Kalender </a></li>
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>allbookings/">Broneeringud 	<?php if(isset($unapprovedBookings)){echo '<span class="badge badge-danger">'.$unapprovedBookings.'</span>';}; ?></a></li>
											<?php endif; ?>
											<?php if($this->session->userdata('roleID')==='1'):?>
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>building/view/">Asutused</a></li>
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>region/view/">Piirkonnad</a></li>
											<?php endif; ?>
											<?php if( $this->session->userdata('roleID')==='1' || $this->session->userdata('roleID')==='2' ||$this->session->userdata('roleID')==='3'):?>
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>manageUsers">Kasutajad</a></li>
											<?php endif; ?>
											<?php if($this->session->userdata('roleID')==='2' || $this->session->userdata('roleID')==='3'):?>
													<li class="nav-item"><a class="nav-link text-white py-0 pr-lg-5 pr-md-2 pr-sm-1 mr-lg-0 mr-md-0 mr-sm-0" href="<?php echo base_url(); ?>building/view/<?php  print_r($this->session->userdata['building']);  ?>">Asutuse sätted</a></li>
											<?php endif; ?>
										
									<?php ;}  if(!empty($this->session->userdata('userID'))){?>
												<li class="nav-item"><a class="nav-link text-white py-0" href="<?php echo base_url(); ?>profile/view/<?php echo $this->session->userdata('userID');?>"><?php echo $this->session->userdata('userName');?> profiil 	<?php if(isset($requestFromBuilding)){if($requestFromBuilding['requestFromBuilding']=='1'){echo '<span class="badge badge-danger">1</span>';}} ?></a></li>
									<?php ;}?>

									</ul>
										
                  <?php if($this->session->userdata('session_id')) : ?>
										<ul class="nav navbar-nav navbar-right p-0">
									
												<li class="nav-item"><a class="nav-link text-white p-0" href="<?php echo base_url(); ?>users/logout" ><u>Logi välja</u></a></li>
										</ul>
                  <?php endif; ?>
                </div>
                <?php if(!$this->session->userdata('session_id')) : ?>
      
                <a class="nav-link text-white p-0" href="<?php echo base_url(); ?>login"><u>Logi sisse</u></a>
                <?php endif; ?>

            </div>
        </nav>
  
    </header>


<!-- Navigation -->
<script>
 $(document).ready(function() {

                window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 8000);});
 </script>


    <?php if($this->session->flashdata('user_registered')): ?>
            <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('user_registered').'</p>'; ?>
        <?php endif; ?>


      <?php if($this->session->flashdata('user_loggedin')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('user_loggedin').'</p>'; ?>
      <?php endif; ?>

       <?php if($this->session->flashdata('user_loggedout')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('user_loggedout').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('success')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('success').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_created')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('post_created').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_updated')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('post_updated').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('category_created')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('category_created').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('post_deleted')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('post_deleted').'</p>'; ?>
      <?php endif; ?>

      <?php if($this->session->flashdata('access_deniedToUrl')): ?>
        <?php echo '<p class="alert alert-danger text-center">'.$this->session->flashdata('access_deniedToUrl').'</p>'; ?>
      <?php endif; ?>
      
      <?php if($this->session->flashdata('building_deleted')): ?>
        <?php echo '<p class="alert alert-success text-center">'.$this->session->flashdata('building_deleted').'</p>'; ?>
      <?php endif; ?>

			<?php if($this->session->flashdata('validationErrorMessage')): ?>
        <?php echo '<p class="alert alert-danger text-center">'.$this->session->flashdata('validationErrorMessage').'</p>'; ?>
      <?php endif; ?>
      
      <?php if($this->session->flashdata('login_failed')): ?>
        <?php echo '<p class="alert alert-danger text-center">'.$this->session->flashdata('login_failed').'</p>'; ?>
			<?php endif; ?>
			
			<?php if($this->session->flashdata('errors')): ?>
        <?php echo '<p class="alert alert-danger text-center">'.$this->session->flashdata('errors').'</p>'; ?>
      <?php endif; ?>
		
			<?php if($this->session->flashdata('data')): ?>
        <?php echo '<p class="alert alert-danger text-center">hello'.print_r($this->session->flashdata('data')).'hello</p>'; ?>
			<?php endif; ?>
					
			<?php if($this->session->flashdata('message')): ?>
        <?php echo '<p class="alert alert-danger text-center">'.$this->session->flashdata('message').'</p>'; ?>
      <?php endif; ?>
 
			<div id="textMessageToUser" ></div>


		<?php //print_r($this->session->userdata);?>
