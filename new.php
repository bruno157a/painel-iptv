
<?php 
require_once("pages/system/seguranca.php");

 if(isset($_GET["p"])){
	 
	 if($_GET["p"]=="admin"){
		$id_owner  = 0;				 
	 }else{
		$SQLUsuario = "select * from usuario where token_user = '".$_GET['p']."' ";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
		
	    if(($SQLUsuario->rowCount()) > 0){
		   $usuario = $SQLUsuario->fetch();
		   $id_owner  = $usuario['id_usuario'];
  
		}else{
		   echo '<script type="text/javascript">';
		   echo 	'alert("Nao encontrado!");';
		   echo	'window.location="login.php";';
		   echo '</script>'; 
		   exit;
			
		}	 

        $SQLSrv = "select * from servidor where demo='1' LIMIT 1";
        $SQLSrv = $conn->prepare($SQLSrv);
        $SQLSrv->execute();
				
	    if(($SQLSrv->rowCount()) < 0){
			echo '<script type="text/javascript">';
		   echo 	'alert("Nao disponivel!");';
		   echo	'window.location="login.php";';
		   echo '</script>'; 
		   exit;
			
		}else{
			$servidor = $SQLSrv->fetch();
		}
		   
	   
		 
		 
	 }
	
   }else{
	   
	    echo '<script type="text/javascript">';
		echo	'window.location="login.php";';
		echo '</script>'; 
		exit;
   }

   function geraSenha(){
				

					$salt = "a1b3c2H1";
					srand((double)microtime()*1000000); 

					$i = 0;
                    $pass = 0;
					while($i <= 7){

						$num = rand() % 10;
						$tmp = substr($salt, $num, 1);
						$pass = $pass . $tmp;
						$i++;

					}
					
					
					

					return $pass;

				}
	
    function geraLoginSSH(){
				

					$salt = "superssh1020";
					srand((double)microtime()*1000000); 

					$i = 0;
                    $pass = 0;
					while($i <= 7){

						$num = rand() % 10;
						$tmp = substr($salt, $num, 1);
						$pass = $pass . $tmp;
						$i++;

					}
					
					
					

					return $pass;

				}
	
$login_ssh = geraLoginSSH();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@SuperSSH | Nova Conta </title>
  <!-- Telegram @SuperSSH -->
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="login.php">@<b>Super</b>SSH</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Dados do sistema</p>
   
    <form action="new_afiliado.php" method="post">
	
	<input type="hidden" class="form-control"  id="p" name="p" value="<?php echo $_GET['p'];?>">
	<input type="hidden" class="form-control"  id="owner" name="owner" value="<?php echo $id_owner;?>">
	<?php if($_GET['p']!="admin"){?>
	<div class="form-group has-feedback">
        <input required="required" type="text" disabled class="form-control" value="<?php echo $usuario['login'];?>"  >
       
      </div>
	<?php } ?>
	 
      <div class="form-group has-feedback">
        <input required="required" type="text" class="form-control" placeholder="Nome e sobre nome" id="nome" name="nome" > 
      </div>
	  
	   <div class="form-group has-feedback">
        <input required="required" type="text" class="form-control" placeholder="Informe o login sem espaço" id="login_sistema" name="login_sistema">
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control"  placeholder="Entre com a senha do sistema" id="senha_sistema" name="senha_sistema">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>		
      </div>
	  
	  <div class="form-group has-feedback">
        <input required="required" type="text" class="form-control" placeholder="Ex: 19997156542" id="celular" name="celular"  min="11">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
		
      </div>
	  <?php if($_GET['p']=="admin"){?>
	   <div class="form-group">
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal" checked  value="revenda">
				  Revendedor SSH
                </label>
				<br>
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal" value="vpn">
				  Usuário SSH  
                </label>
                
        </div>
		<?php }else{ ?>
	  <input type="hidden" name="tipo" id="tipo"   value="vpn">
	    <?php } ?>
		<hr>
	   <p class="login-box-msg">Dados de conexão "APP" </p>
	   <div class="form-group has-feedback">
        <input required="required" type="text" class="form-control" placeholder="Login" id="login_ssh" name="login_ssh" value="<?php echo $login_ssh;?>">
        <span class="glyphicon glyphicon-user form-control-feedback" ></span>
      </div>
	   <div class="form-group has-feedback">
        <input type="password" class="form-control"  disabled placeholder="A Senha será enviada via SMS" >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	  
	  
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
         <center> <button type="submit" class="btn btn-primary btn-block btn-flat">Criar Agora</button></center>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
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
