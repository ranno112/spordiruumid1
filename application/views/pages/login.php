<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/et_EE/sdk.js#xfbml=1&version=v6.0&appId=320472512246850&autoLogAppEvents=1"></script>
 


<div class="container">
	<div class="container-sm h-100 mx-auto">
		<div class="vert-center form-bg">
			<div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><div class="d-flex"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab">Sisselogimine  <span data-tooltip="admin@admin.ee, juht@juht.ee, haldur@haldur.ee. Parool kõigil sama: admin"><img id="tool" class="mr-5" src="<?php echo base_url(); ?>assets/img/icon-info.svg"></span></a></div></li>
                    <li class="nav-item p-0"></li>
                </ul>
            </div>
			<?php echo form_open('users/login'); ?>
				<div class="m-15">
					<div class="form-label-group py-0 pl-0">
                        <label for="contact">Email</label>
                        <input type="text" type="email" name="email" class="form-control" required autofocus>
					</div>
					<div class="form-label-group pt-1 pb-4 pl-0">
                        <label for="contact">Parool</label>
						<!-- <input type="password" id="password" name="password" class="form-control" data-toggle="password" required> -->

						<input id="password-field" type="password" class="form-control" name="password">
						<i id="login-icon" toggle="#password-field" class="far fa-eye-slash field-icon toggle-password"></i>
					</div>

					<div class="form-label-group pt-1 pb-4 pl-0 text-center">
						<button type="submit" class="mx-auto btn-width-lg btn btn-custom txt-lg text-white btn-block mb-2">Logi sisse</button>
						<a class="link-deco align-self-center mt-2 pb-0" href="#">Unustasid parooli?</a>
					</div>
				
				</div>
			<?php echo form_close(); ?>
			
			 <?php
   if(!isset($login_button))
   {

    $user_data = $this->session->userdata('user_data');
    echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
  //  echo '<img src="'.$user_data['profile_picture'].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>Name : </b>'.$user_data["userName"]. '</h3>';
    echo '<h3><b>Email :</b> '.$user_data['email'].'</h3>';
    echo '<h3><a href="'.base_url().'login/logout">Logout</h3></div>';
   }
   else
   {
    echo '<div align="center">'.$login_button . '</div>';
   }
	 ?>
	<div align="center"> <div class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="true" data-use-continue-as="false"></div></div>
</br>
		</div>
	</div>
</div>

<script>
$(".toggle-password").click(function() {

	$(this).toggleClass("fa-eye fa-eye-slash");
	var input = $($(this).attr("toggle"));
	if (input.attr("type") == "password") {
	input.attr("type", "text");
	} else {
	input.attr("type", "password");
	}
});
</script>
