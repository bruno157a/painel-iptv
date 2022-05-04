<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PainelV5 | MeuSite.com </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
   <!-- painelv5 -->
  <link rel="stylesheet" href="painelv5.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">

<div class="page-loader"><a href="javascript:;"><img src="logo.png" class="img-responsive center-block" alt=""/></a><span class="text-uppercase">Carregando...</span></div><script>var resizefunc = [];</script> <script src="scripts/assets/jquery.min.js"></script> <script src="scripts/assets/bootstrap.min.js"></script> <script src="scripts/assets/loader.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<div class="se-pre-con"></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-envelope-o"></i> Recuperar Acesso</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="recupera" action="recuperando.php" method="post">

              <div class="form-group">
                <label for="exampleInputPassword1">Digite o E-mail</label>
                <input type="text" class="form-control" name="email" placeholder="Digite...">
              </div>



		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Confirmar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3">
  			<div id="iosBlurBg">
  				<div id="whiteBg"></div>
  			</div>
  			<div id="bottomEnter"></div>
  			<div id="bottomBlurBg"></div>
  			<!-- Login Form -->

  			<div class="loginForm">
  				<div class="title">
  					<p>Painel V5<br><span>Acesso ao Sistema</span></p>
  					<hr>
  					<hr class="short">
  				</div>
  				<form method="post" action="logando.php">
  					<div class="col-3">
			        	<input class="effect-2" type="text" name="login" placeholder="Login...">
			            <span class="focus-border"></span>

			            <input class="effect-2" type="password" name="senha" placeholder="Senha...">
			            <span class="focus-border"></span>
			        </div>

			        <div class="forget">
			        	<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm">Esqueceu a Senha?</button>
			        </div>
                    <div class="juniorrios">@JuniorRios</div>

  			</div>
  			<a href="#">
  				<div class="enterButton">
	  				<button name="botaologin" style="background: transparent;border: none !important;" type="submit">
	  				<i class="fa fa-lock fa-2x text-white"></i><br>
	  				<span class="enterText text-white">Entrar</button></span>
	  			</div>
  			</a>
  			</form>
		</div>
	</div>
</div>

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
