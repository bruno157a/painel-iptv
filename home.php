<?php


require_once("pages/system/seguranca.php");
require_once("pages/system/config.php");
require_once("pages/system/classe.ssh.php");

protegePagina("user");






		$quantidade_ssh = 0;
		$quantidade_ssh_user =0;
		$quantidade_ssh_sub =0;
		$quantidade_sub = 0;
		$all_ssh_susp_qtd = 0;

		$SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
        $usuario = $SQLUsuario->fetch();
        // avatares
        switch($usuario['avatar']){
        case 1:$avatarusu="avatar1.png";break;
        case 2:$avatarusu="avatar2.png";break;
        case 3:$avatarusu="avatar3.png";break;
        case 4:$avatarusu="avatar4.png";break;
        case 5:$avatarusu="avatar5.png";break;
        default:$avatarusu="boxed-bg.png";break;
        }


        if($usuario['tipo']=='revenda'){
        $tipouser='Revendedor';
        }elseif($usuario['tipo']=='vpn'){
        $tipouser='Usuário VPN';
        }

        $datacad=$usuario['data_cadastro'];

         $partes = explode("-", $datacad);
         $ano = $partes[0];
         $mes = $partes[1];

         $Mes = muda_mes($mes);
         $Meses = muda_mes2($mes);




		$SQLUsuario_ssh = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
        $SQLUsuario_ssh = $conn->prepare($SQLUsuario_ssh);
        $SQLUsuario_ssh->execute();
        $quantidade_ssh += $SQLUsuario_ssh->rowCount();

		$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' and  status='2' and apagar='0' ";
        $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
        $SQLUsuario_sshSUSP->execute();
        $all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

		$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];

        $total_acesso_ssh_online = 0;
	    $SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$_SESSION['usuarioID']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];




		$SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
        $SQLAcesso = $conn->prepare($SQLAcesso);
        $SQLAcesso->execute();
        $acesso_servidor = $SQLAcesso->rowCount();


        //Arquivos download
        $SQLArquivos= "select * from  arquivo_download";
        $SQLArquivos = $conn->prepare($SQLArquivos);
        $SQLArquivos->execute();
        $todosarquivos = $SQLArquivos->rowCount();
        if($usuario['id_mestre']==0){
        // Faturas
        $SQLfaturas= "select * from  fatura where status='pendente' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLfaturas = $conn->prepare($SQLfaturas);
        $SQLfaturas->execute();
        $faturas = $SQLfaturas->rowCount();
        }else{
        // Faturas
        $SQLfaturas= "select * from  fatura_clientes where status='pendente' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLfaturas = $conn->prepare($SQLfaturas);
        $SQLfaturas->execute();
        $faturas = $SQLfaturas->rowCount();
        }
        if($usuario['tipo']=='revenda'){
        // Faturas
        $SQLfaturas2= "select * from  fatura_clientes where status='pendente' and id_mestre='".$_SESSION['usuarioID']."'";
        $SQLfaturas2 = $conn->prepare($SQLfaturas2);
        $SQLfaturas2->execute();
        $faturas_clientes = $SQLfaturas2->rowCount();
        }
        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();
        // Notificações Contas
        $SQLnoti1= "select * from  notificacoes where lido='nao' and tipo='conta' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti1= $conn->prepare($SQLnoti1);
        $SQLnoti1->execute();
        $totalnoti_contas = $SQLnoti1->rowCount();

        // Notificações fatura
        $SQLnoti2= "select * from  notificacoes where lido='nao' and tipo='fatura' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti2= $conn->prepare($SQLnoti2);
        $SQLnoti2->execute();
        $totalnoti_fatura = $SQLnoti2->rowCount();

        if($usuario['tipo']=='revenda'){
        // Notificações Revenda
        $SQLnoti3= "select * from  notificacoes where lido='nao' and tipo='revenda' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti3= $conn->prepare($SQLnoti3);
        $SQLnoti3->execute();
        $totalnoti_revenda = $SQLnoti3->rowCount();

        //Todos os chamados subRevendedores e usuarios do revendedor
        $SQLchamadoscli2= "select * from  chamados where status='resposta' and id_mestre='".$_SESSION['usuarioID']."'";
        $SQLchamadoscli2= $conn->prepare($SQLchamadoscli2);
        $SQLchamadoscli2->execute();
        $all_chamados_clientes += $SQLchamadoscli2->rowCount();
        //Todos os chamados subRevendedores e usuarios do revendedor
        $SQLchamadoscli= "select * from  chamados where status='aberto' and id_mestre='".$_SESSION['usuarioID']."'";
        $SQLchamadoscli= $conn->prepare($SQLchamadoscli);
        $SQLchamadoscli->execute();
        $all_chamados_clientes += $SQLchamadoscli->rowCount();

        //subrevendedores
        $SQLsbrevenda = "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='sim' ";
        $SQLsbrevenda = $conn->prepare($SQLsbrevenda);
        $SQLsbrevenda->execute();
        $quantidade_sub_revenda = $SQLsbrevenda->rowCount();
        }

        //Todos os chamados meus 1
        $SQLchamados= "select * from  chamados where status='aberto' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLchamados= $conn->prepare($SQLchamados);
        $SQLchamados->execute();
        $all_chamados += $SQLchamados->rowCount();
        //Todos os chamados meus 2
        $SQLchamados2= "select * from  chamados where status='resposta' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLchamados2= $conn->prepare($SQLchamados2);
        $SQLchamados2->execute();
        $all_chamados += $SQLchamados2->rowCount();
        // Notificações chamados
        $SQLnotichama= "select * from  notificacoes where lido='nao' and tipo='chamados' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnotichama= $conn->prepare($SQLnotichama);
        $SQLnotichama->execute();
        $totalnoti_chamados = $SQLnotichama->rowCount();
        // Notificações Outros
        $SQLnoti4= "select * from  notificacoes where lido='nao' and tipo='outros' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti4= $conn->prepare($SQLnoti4);
        $SQLnoti4->execute();
        $totalnoti_outros = $SQLnoti4->rowCount();

        if($usuario['id_mestre']<>0){
        // Notificações users
        $SQLnoti5= "select * from  notificacoes where lido='nao' and tipo='usuario' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti5= $conn->prepare($SQLnoti5);
        $SQLnoti5->execute();
        $totalnoti_users = $SQLnoti5->rowCount();


        }


		if($usuario['tipo']=="revenda"){
			$SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='nao'";
            $SQLSub = $conn->prepare($SQLSub);
            $SQLSub->execute();


			if (($SQLSub->rowCount()) > 0) {

                while($row = $SQLSub->fetch()) {

					$SQLSubSSH= "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'  ";
                    $SQLSubSSH = $conn->prepare($SQLSubSSH);
                    $SQLSubSSH->execute();
                    $quantidade_ssh += $SQLSubSSH->rowCount();

                    $sshsub=$SQLSubSSH->rowCount();

					$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and status='2' and apagar='0' ";
                    $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
                    $SQLUsuario_sshSUSP->execute();
                    $all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

					$SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                    $SQLAcessoSSH->execute();
	             	$SQLAcessoSSH = $SQLAcessoSSH->fetch();
                    $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


	                $SQLAcessoSSHon = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSHon = $conn->prepare($SQLAcessoSSHon);
                    $SQLAcessoSSHon->execute();
		            $SQLAcessoSSHon = $SQLAcessoSSHon->fetch();
                    $total_acesso_ssh_online += $SQLAcessoSSHon['quantidade'];

		        }


		    }
		 $quantidade_sub += $SQLSub->rowCount();


			//Calcula os dias restante
		$data_atual = date("Y-m-d ");
		$data_validade = $usuario['validade'];

		$data1 = new DateTime( $data_validade );
        $data2 = new DateTime( $data_atual );

        $diferenca = $data1->diff( $data2 );
        $ano = $diferenca->y * 364 ;
		$mes = $diferenca->m * 30;
		$dia = $diferenca->d;
        $dias_acesso = $ano + $mes + $dia;

		$quantidade_ssh += 	 $quantidade_ssh_sub+$quantidade_ssh_user;

		if($usuario['ativo']==2){
				echo '<script type="text/javascript">';
			                 echo 	'alert("Sua conta  esta suspensa!");';
			                 echo	'window.location="pages/suspenso.php";';
			                 echo '</script>';
							 exit;

			}

		}







	?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PServers SSH | Painel </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Select 2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <link rel="stylesheet" href="plugins/iCheck/all.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="painelmods.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut('slow');;
	});
</script>
<script>
function usuariosonline()
{

	// Requisição
	$.post('pages/ssh/online_home.php?requisicao=1',
	function (resposta) {
	        //Adiciona Efeito Fade
	        $("#usuarioson").fadeOut("slow").fadeIn('slow');
			// Limpa
			$('#usuarioson').empty();
			// Exibe
			$('#usuarioson').append(resposta);
	});
}
// Intervalo para cada Chamada
setInterval("usuariosonline()", 30000);

// Após carregar a Pagina Primeiro Requisito
$(function() {
		// Requisita Função acima
		usuariosonline();
});
</script>
<script>
function atualizar()
{
		// Fazendo requisição AJAX
		$.post('pages/ssh/online_home.php?requisicao=2',
		function (online) {
				// Exibindo frase
				$('#online_nav').html(online);
				$('#online').html(online);

		}, 'JSON');
}
// Definindo intervalo que a função será chamada
setInterval("atualizar()", 10000);
// Quando carregar a página
$(function() {
		// Faz a primeira atualização
		atualizar();
});
</script>

<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-red-light sidebar-mini">
	<!-- Paste this code after body tag -->
	<div class="se-pre-con"></div>
	<!-- Ends -->
<!-- Site wrapper -->
<div class="wrapper">

<div class="modal fade" id="flaggeral" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="lineModalLabel"><i class="fa fa-flag"></i> Alertar Todos!</h3>
		</div>
		<div class="modal-body">

            <!-- content goes here -->
			 <form name="editaserver" action="pages/usuario/notificar_home.php" method="post">
			 <div class="form-group">
                <label for="exampleInputEmail1">Tipo de Notificação </label>
                <?php if(($usuario['tipo']=='revenda') and ($usuario['subrevenda']=='nao')){?>
                <select size="1" name="clientes" class="form-control select2">
                <option value="1" selected=selected>Todos</option>
                <option value="2">Revendedores</option>
                <option value="3" >Clientes</option>
                </select>
                <?php }else{ ?>
                <select size="1" name="clientes" class="form-control select2" disabled>
                <option value="1" selected=selected>Todos Clientes</option>
                </select>
                <?php } ?>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Mensagem</label>
                <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
              </div>

              </div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal" role="button">Cancelar</button>
				</div>
				<div class="btn-group" role="group">
					<button class="btn btn-default btn-hover-green">Confirmar</button>

				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
</div>


  <header class="main-header">
          <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SSH</b></span>
				<span class="logo-lg"><b>Pservers</b>SSH</span>
    </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">

         <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
      </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications: style can be found in dropdown.less -->

               <?php if($usuario['tipo']=='revenda'){?>
               <li class="dropdown notifications-menu">


                <a data-toggle="modal" href="#flaggeral" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-warning"></span>
                </a>
                </li>
                <?php } ?>

                  <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-rocket"></i>
							<span class="label label-success" id="online_nav"><?php echo $total_acesso_ssh_online; ?></span>
						</a>
							<ul class="dropdown-menu">
	              <li class="header"><center>Usuários Online</center></li>
	              <li>
	                <!-- inner menu: contains the actual data -->
	                <ul class="menu" id="usuarioson">

	                </ul>
	              </li>
	              <li class="footer"><a href="home.php?page=ssh/online" >Ver Todos</a></li>
	            </ul>
          </li>

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"><?php echo $totalnoti;?></span>
                </a>
                <ul class="dropdown-menu">
                 <?php if($totalnoti==0){?>
                 <li class="header">Você não possui novas notificações</li>
                 <?php }else{ ?>
                 <li class="header">Você possui <?php echo $totalnoti;?> nova<?php if($totalnoti>1){ echo "s";}?> <?php if($totalnoti<=1){ echo "notificação";}else { echo "notificações";}?></li>
                  <?php }?>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=accs">
                          <i class="fa fa-user text-purple"></i> <?php echo $totalnoti_contas;?> Em Contas
                        </a>
                      </li>
                      <?php
                       if($usuario['subrervenda']=='nao'){
                       if($usuario['id_mestre']<>0){ ?>
                       <li>
                        <a href="?page=notificacoes/notificacoes&ler=usuario">
                          <i class="fa fa-user text-blue"></i> <?php echo $totalnoti_users;?> Em Usuário
                        </a>
                      </li>
                      <?php }}
                       if($usuario['tipo']=='revenda'){ ?>
                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=reve">
                          <i class="fa fa-users text-aqua"></i> <?php echo $totalnoti_revenda;?> Em Revendas
                        </a>
                      </li>
                      <?php } ?>
                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=others">
                          <i class="fa fa-info-circle"></i> <?php echo $totalnoti_outros;?> Em Outros
                        </a>
                      </li>
                      <li>
                        <a href="?page=notificacoes/notificacoes&ler=fatu">
                          <i class="fa fa-usd text-green"></i> <?php echo $totalnoti_fatura;?> Em Faturas
                        </a>
                      </li>
                       <li>
                        <a href="?page=notificacoes/notificacoes&ler=chamados">
                          <i class="fa fa-ticket"></i> <?php echo $totalnoti_chamados;?> Em Chamados
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="?page=notificacoes/notificacoes&ler=all">Ver Todos</a></li>
                </ul>
              </li>
                <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li>
            <a href="sair.php" ><i class="fa fa-power-off"></i> </a>
          </li>
        </ul>
      </div>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/<?php echo $avatarusu;?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"> Painel - <?php echo ucfirst($usuario['nome']);?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/<?php echo $avatarusu;?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo strtoupper($usuario['nome']);?> - <?php echo $tipouser;?>
                      <small>Membro desde <?php echo $Mes;?>. <?php echo $ano;?></small>
                    </p>
                  </li>
                  <!-- Menu Body
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Contas SSH</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Online</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li> -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="home.php?page=admin/dados" class="btn btn-default btn-flat">Meu Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="sair.php" class="btn btn-default btn-flat">Desconectar</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">

        <div class="pull-left image">

         <img src="dist/img/<?php echo $avatarusu;?>" class="img-circle" alt="User Image">

        </div>

        <div class="pull-left info">
          <p><?php echo strtoupper($usuario['nome']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
	  <li class="header">NAVEGAÇÃO PRINCIPAL</li>
		   <li>
          <a href="home.php">
            <i class="fa fa-home"></i> <span>INÍCIO</span>
          </a>
        </li>


        <li class="treeview ">
          <a href="#">
            <i class="fa fa-terminal"></i>
            <span>CONTAS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"> <?php echo $quantidade_ssh; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
		   <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
            <li><a href="?page=ssh/adicionar"><i class="fa fa-circle-o"></i>Nova conta SSH</a></li>
			<?php }?>
            <li ><a href="?page=ssh/contas"><i class="fa fa-circle-o"></i>Listar contas SSH</a></li>
			<li ><a href="?page=ssh/online"><i class="fa fa-circle-o"></i>Contas SSH Online</a></li>


          </ul>
        </li>


       <?php if($usuario['tipo']=="revenda") {?>
	    <li class="treeview ">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>CLIENTES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $quantidade_sub; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=usuario/adicionar"><i class="fa fa-circle-o"></i>Novo usuário</a></li>

            <li><a href="?page=usuario/listar"><i class="fa fa-circle-o"></i>Usuários SSH</a></li>
            <?php if($usuario['subrevenda']<>'sim'){ ?>
            <li><a href="?page=subrevenda/revendedores"><i class="fa fa-circle-o"></i>SubRevendedores
            <span class="pull-right-container">
            <small class="label pull-right bg-green">Novo</small>
            </span>
            </a></li>
             <?php } ?>
          </ul>
        </li>
        <?php if($usuario['subrevenda']<>'sim'){ ?>
        <li class="treeview ">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>SUBREVENDA</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $quantidade_sub_revenda; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=subrevenda/adicionar"><i class="fa fa-circle-o"></i>ADD Servidor</a></li>

            <li><a href="?page=subrevenda/revendedores"><i class="fa fa-circle-o"></i>Revendedores</a></li>

            </a></li>

          </ul>
        </li>
         <?php } ?>
		 <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>



		 <li class="treeview ">
          <a href="#">
            <i class="fa fa-server"></i>
            <span>SERVIDORES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $acesso_servidor; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=servidor/listar"><i class="fa fa-circle-o"></i>Listar servidores</a></li>

         <?php if($usuario['subrevenda']<>'sim'){?><li><a href="?page=subrevenda/alocados"><i class="fa fa-circle-o"></i>Servidores Alocados</a></li><?php } ?>
          </ul>
        </li>
		<?php }?>

	   <?php }?>


           <?php if($usuario['id_mestre']==0){?>
		 <li class="treeview ">
          <a href="#">
            <i class="fa fa-usd"></i>
            <span>MINHAS FATURAS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $faturas; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=faturas/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=faturas/pagas"><i class="fa fa-circle-o"></i>Pagas</a></li>
            <li><a href="?page=faturas/canceladas"><i class="fa fa-circle-o"></i>Canceladas</a></li>
          </ul>
        </li>
        <?php }else{ ?>
         <li class="treeview ">
          <a href="#">
            <i class="fa fa-usd"></i>
            <span>MINHAS FATURAS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $faturas; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=faturasclientes/minhas/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=faturasclientes/minhas/pagas"><i class="fa fa-circle-o"></i>Pagas</a></li>
            <li><a href="?page=faturasclientes/minhas/canceladas"><i class="fa fa-circle-o"></i>Canceladas</a></li>
          </ul>
        </li>
        <?php }?>
            <?php
            if($usuario['tipo']=='revenda'){ ?>
            <li class="treeview ">
            <a href="#">
            <i class="fa fa-usd"></i>
            <span>FATURAS CLIENTES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $faturas_clientes; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="?page=faturasclientes/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=faturasclientes/pagas"><i class="fa fa-circle-o"></i>Pagas</a></li>
            <li><a href="?page=faturasclientes/canceladas"><i class="fa fa-circle-o"></i>Canceladas</a></li>
            <li><a href="?page=faturasclientes/comprovantes"><i class="fa fa-circle-o"></i>Comprovantes</a></li>
            <li><a href="?page=faturasclientes/cpfechados"><i class="fa fa-circle-o"></i>CP Fechados</a></li>
          </ul>
        </li>
            <li class="treeview ">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>CHAMADOS CLIENTES</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $all_chamados_clientes; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=chamadosclientes/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=chamadosclientes/respondidos"><i class="fa fa-circle-o"></i>Respondidas</a></li>
            <li><a href="?page=chamadosclientes/encerrados"><i class="fa fa-circle-o"></i>Encerradas</a></li>
          </ul>
        </li>
        <?php } ?>
         <li class="treeview ">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>MEUS CHAMADOS</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $all_chamados; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=chamados/abrir"><i class="fa fa-circle-o"></i>Abrir um Chamado</a></li>
            <li><a href="?page=chamados/abertas"><i class="fa fa-circle-o"></i>Abertas</a></li>
            <li><a href="?page=chamados/respondidos"><i class="fa fa-circle-o"></i>Respondidas</a></li>
            <li><a href="?page=chamados/encerrados"><i class="fa fa-circle-o"></i>Encerradas</a></li>
          </ul>
        </li>
		<li class="treeview ">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>CONFIGURAÇÕES</span>
            <span class="pull-right-container">

            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=admin/dados"><i class="fa fa-circle-o"></i>Minhas Informações</a></li>

          </ul>
        </li>
        <?php if($usuario['tipo']=="revenda") {?>
        <li>
          <a href="?page=email/enviaremail">
            <i class="fa fa-tty"></i> <span>EMAIL</span>
             <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php } ?>
        <li>
          <a href="?page=downloads/downloads">
            <i class="fa fa-cloud-download"></i> <span>NUVEM</span>
             <span class="pull-right-container">
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
     <?php

				if($usuario['atualiza_dados']==1){
					if(isset($_GET["page"])){
					$page = $_GET["page"];
					if($page and file_exists("pages/".$page.".php")) {
					include("pages/".$page.".php");
					} else {
					include("./pages/inicial.php");
				  }
				}else{
					include("./pages/inicial.php");
				}
			}else{
				include("./pages/admin/dados.php");
			}




			?>



    <!-- /.content -->
  </div>




</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- page script -->

</body>
</html>
