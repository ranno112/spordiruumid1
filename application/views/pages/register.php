<?php // echo validation_errors(); ?>
<div class="container">
	<div class="container-s mx-auto">
		<div class="vert-center form-bg">
			<div class="d-flex mb-5">
                <ul class="nav nav-tabs nav-justified col-12 bg-grey p-0">
                    <li class="nav-item p-0"><a class="nav-link link txt-lg single-tab active pl-5" data-toggle="tab">Registreeri</a></li>
                    <li class="nav-item p-0"></li>
                </ul>
            </div>
			<?php echo form_open('users/registerSelf'); ?>
				<div class="m-15">
					<div class="form-label-group py-0 pl-0">
					<label>Ees- ja perekonnanimi* <?php echo form_error('name',  '<small class="text-danger">','</small>'); ?></label>
						<input type="text" class="form-control" name="name" value="<?php if(!empty($postdata['name'])){echo $postdata['name'];}?>" required>
					</div>
					<div class="form-label-group py-0 pl-0">
						<label>Email* <?php echo form_error('email',  '<small class="text-danger">','</small>'); ?></label>
						<input type="" class="form-control" name="email" value="<?php if(!empty($postdata['name'])){echo $postdata['email'];}?>" required>
					</div>
					<div class="form-label-group py-0 pl-0">
						<label>Telefoni number* <?php echo form_error('phone',  '<small class="text-danger">','</small>'); ?></label>
						<input type="phone" class="form-control" name="phone" value="<?php if(!empty($postdata['name'])){echo $postdata['phone'];}?>" required>
					</div>
					<div class="form-label-group pt-1 pl-0">
						<hr>
						<label>Parool* <?php if($this->session->flashdata('password')){  echo $this->session->flashdata('password');} ?></label>
						<input id="password-field" type="password" class="form-control" name="password" value="<?php if(!empty($postdata['name'])){echo $postdata['password'];}?>" required>
						<i id="login-icon" toggle="#password-field" class="far fa-eye-slash field-icon toggle-password">&#128065;</i>
					</div>
					<div class="form-label-group pt-1 pb-4 pl-0">
						<label>Parool uuesti* <?php echo form_error('password2',  '<small class="text-danger">','</small>'); ?></label>
						<input id="password-field2" type="password" class="form-control" name="password2" value="" required>
						<i id="login-icon" toggle="#password-field" class="far fa-eye-slash field-icon toggle-password"></i>
					</div>
						<div class="form-label-group pt-1 pb-4 pl-0 text-center">
						<button type="submit" class="mx-auto btn-width-lg btn btn-custom txt-lg text-white btn-block mb-2">Registreeri</button>
					</div>
				
				</div>
			<?php echo form_close(); ?>
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
