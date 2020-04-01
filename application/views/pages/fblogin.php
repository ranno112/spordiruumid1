<!-- Display login button / Facebook profile information -->
<?php if(!empty($authURL)){ ?>
	<h2>CodeIgniter Facebook Login</h2>
    <a href="<?php echo $authURL; ?>"><img src="<?php echo base_url('assets/images/fb-login-btn.png'); ?>"></a>
<?php }else{ ?>
    <h2>Facebook Profile Details</h2>
    <div class="ac-data">
    
        <p><b>Facebook ID:</b> <?php echo $userData['login_oauth_uid']; ?></p>
        <p><b>Name:</b> <?php echo $userData['userName']; ?></p>
        <p><b>Email:</b> <?php echo $userData['email']; ?></p>
        <p><b>Logout from <a href="<?php echo $logoutURL; ?>">Logi välja</a></p>
    </div>
<?php } ?>
