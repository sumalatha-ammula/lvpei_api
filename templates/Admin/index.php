<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?= $this->Html->css(['owl.carousel.min', 'bootstrap.min','style','select2.min']); ?> <!-- Include CSS files -->
    <?= $this->Html->css('font/style.css'); ?>
    <?= $this->Html->css('bootstrap/select2-bootstrap4.min.css'); ?>
    <?= $this->Html->script(['jquery-3.3.1.min', 'popper.min','bootstrap.min','main','lc_switch','select2.full.min']); ?>

   <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> -->
  <!-- icheck bootstrap -->
  <!-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> -->


  <script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var baseURL = "<?php echo $this->Url->build('/', array('fullBase'=>true)); ?>";
  </script>
<div class="login-box"  style="
    justify-content: center;
    display: flex;
    /* align-items: center; */
">
	<!-- /.login-logo -->
	<div class="card" style="
    width: 50%;
    top: 30px;
    display: flex;
    /* justify-content: center; */
    align-items: center;
    /* height: 100vh; */
">
		<div class="card-body login-card-body">
			<div class="Login-logo">
        <!--img-->
			<br /> <b>RAVIAPP</b>
			</div>
			<p class="login-box-msg">Sign in to start your session</p>

      <?php
						echo $this->Flash->render ();
						echo $this->Form->create ( null, array (
								'url' => array (
										'controller' => 'Admin',
										'action' => 'index' 
								),
								'enctype' => 'multipart/form-data',
								'id' => 'login' 
						) );
						?>
				<div class="input-group mb-3 form-group">
				
					<input type="email" name="email"  class="form-control" Placeholder="Email"/>
				
				
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
			</div>
			
			<div class="input-group mb-3  form-group">
				<input type="password" name="password" class="form-control" placeholder="Password">
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-8">
					<div class="icheck-primary">
						<input type="checkbox" id="remember"> <label for="remember"> Remember Me </label>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block" style="
    width: 100px;">Sign In</button>
				</div>
				<!-- /.col -->
				<!-- /.col -->
			</div>
					<?php
					echo $this->Form->end ();
					?>
<!-- /.social-auth-links -->
			<!-- <p class="mb-1">
      <?php
						echo $this->Html->link ( "I forgot my password", [ 
								'controller' => 'Login',
								"action" => "index" 
						] );
						?>
      </p> -->
			<!-- /.col -->
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<script>

var validator = $('#login').validate({
    rules: {
    	email: { required: true, email: true,  minlength: 5},
    	password: {required: true, minlength: 5},
      },
    messages: {
    	email: { required: "Please enter login email"},
    	password: { required: "Please enter login password"},
    	
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

</script>