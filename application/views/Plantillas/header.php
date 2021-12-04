<!DOCTYPE html>
<html lang="en">

<head>        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="<?= isset($icon) ? base_url("/assets/img/") . $icon : base_url("/assets/img/") . "/logoagr.png" ?>">

    <title><?= isset($sysname) ? $sysname : "" ?> - <?= isset($titulo) ? $titulo : "Dashboard" ?></title>
    
    <script src="<?= base_url() ?>/assets/vendor/jquery/jquery.min.js"></script>
    
    <!-- Bootstrap 5.0.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Fin Bootstrap -->

    <!-- animate.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- AOS Animate On Scroll Library-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/mensajes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>/assets/css/estilosPrincipales.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/carousel.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
</head>

<body id="page-top">
    
    <!-- Boton flotante - Ir al principio de la página -->
    <a class="ir-arriba" tittle="Volver arriba">
        <span class="fa-stack">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-angle-up fa-stack-1x fa-inverse"></i>
        </span>
    </a> 

    <!-- Header -->
    <header class="text-white fixed-top" style="height: 50px;" !important>
        <nav class="barraNav navbar navbar-expand-xl navbar-dark bg-dark my-auto" aria-label="Sixth navbar example">
            <div class="container-fluid">
            
                <button class="btn  btn-outline-info me-4" id="btn" type="button">
                    <i class="fas fa-bars"></i>
                </button>

                <a id="nomHome" href="<?=site_url() ?>" class="col-auto text-secondary d-none d-lg-inline">Centro de Agronegocios - USO</a>
                <a id="nomHome" href="<?=site_url() ?>" class="col-auto text-secondary d-inbline d-sm-inline d-lg-none">AGRO - USO</a>

                <img class="ms-3 me-auto my-1" style=" height: 35px; width: 45px;" src="<?= base_url("/assets/img/logoagr.png")?>" alt="AFP">
                <?php if(!$userNombre){?>
                <button class="navbar-toggler btn btn-outline-info btnLogin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample06" aria-controls="navbarsExample06" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="far fa-user-circle"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample06">
                
                    <form id="frmLogin"  class="row navbar-nav ms-auto me-1 mb-em-0"  !important method="POST">
                        <div class="offset-sm-3 offset-lg-4 col-sm-6 col-lg-4 divbtnLeft" !important>
                            <input type="" class="form-control mt-1 inputLogin" id="correo" name="correo" type="text" placeholder="Correo" required autofocusaria-label="Correo">  
                        </div>
                        <div class="offset-sm-3 offset-lg-4 col-sm-6 col-lg-4 divbtnLeft" !important>
                            <input type="password" class="form-control inputLogin mt-1" id="password" name="password" type="password" placeholder="Contraseña" aria-label="Password" required >
                        </div>
                        <div class="offset-sm-3 offset-lg-4 col-sm-6 col-lg-4 row divbtnLeft" !important>
                            <div class="col-6 divbtnLeft " >
                                <input onclick="iniciarSesion()" type="button" id="btnIniciar" class=" btn btn-outline-primary btnIngresar col-sm-6 my-1 " value="Ingresar">
                            </div>

                            <div class="col-6 ms-auto divbtnLeft" !important>
                                <input onclick="registrarse()" type="button" id="btnRegistrar" class="btn  btnRegistrar my-1" value="Registrar">
                            </div>                    
                        </div>
                    </form>
                <?php } else{ ?>
                    <form class="me-1 ms-auto my-auto" action="" id="frmLogout" ">
                        
                        <li class="nav-item dropdown no-arrow" style="color: #11101D !important; text-align:center;">

                            <a  id="posicionDatos"class="nav-link dropdown-toggle my-auto order-2" style="display:inline; text-align:center; color: #6c757d!important;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="nomHome" class="mr-2 text-secondary d-none d-lg-inline text-gray-600 small me-3 "><?= isset($userNombre) ? $userNombre : "" ?></span>
                                <span id="nomHome" class="mr-2 text-secondary d-none d-lg-inline text-gray-600 small me-3 "><?= isset($nomPerfil) ? $nomPerfil : "" ?></span>
                                <img class="img-profile rounded-circle" style="display: inline-block; text-align: center; width: 35px; height: 35px;" src="<?= base_url() ?>/assets/img/undraw_profile.svg">
                            </a>
                    
                        
                        <!-- Dropdown - User Information -->
                        <div  id="posicionCerrarSesion" class="dropdown-menu dropdown-menu-right shadow animated--grow-in order-1" aria-labelledby="userDropdown" style="padding: 4px !important; border-top: 0px !important;" >
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </form>
            <?php } ?>

                </div>
            </div>
        </nav>
    </header>
    <!-- Header -->

    <!-- Sidebar - Menu -->
    <div class="sidebar">
        <!--
        <div class="logo-details">
            <i class="fas fa-home"></i>
            <div class="logo_name">TBSA</div>
        </div>
        -->

        <ul class="nav-list">
            <li>
                <a href="<?= site_url("GestionEmpresarial/IrPrincipal")?>" title='Gestión empresarial'>
                    <i class="fas fa-chart-line"></i>
                    <span class="links_name">Gestión empresarial</span>
                </a>
                <span class="tooltip">Gestión empresarial</span>
            </li>
            <li>
                <a href="<?= site_url("AsistenciasTecnicas/IrPrincipal")?>" title='Asistencia técnica'>
                    <i class="fas fa-hands-helping"></i>
                    <span class="links_name">Asistencia técnica</span>
                </a>
                <span class="tooltip">Asistencia técnica</span>
            </li>
            <li>
                <a href="<?= site_url("PlanesNegocio/IrPrincipal")?>" title='Planes, modelos y ruedas de negocio'>
                    <i class="fas fa-business-time"></i>
                    <span class="links_name">Planes de negocio</span>
                </a>
                <span class="tooltip">Planes, modelos y ruedas de negocio</span>
            </li>
                <li>
                <a href="<?= site_url("Capacitaciones/IrPrincipal")?>" title='Capacitaciones'>
                    <i class="fas fa-people-carry"></i>
                    <span class="links_name">Capacitaciones</span>
                </a>
                <span class="tooltip">Capacitaciones</span>
            </li>
            <li>
                <a href="<?= site_url("GestionAmbiental/IrPrincipal")?>" title='Gestión ambiental'>
                    <i class="fas fa-tree"></i>
                    <span class="links_name">Gestión ambiental</span>
                </a>
                <span class="tooltip">Gestión ambiental</span>
            </li>
            <li>
                <a href="<?= site_url("PreciosProductos/IrPrincipal")?>" title='Precios de productos'>
                    <i class="fas fa-money-check-alt"></i>
                    <span class="links_name">Precios de Productos</span>
                </a>
                <span class="tooltip">Precios de Productos</span>
            </li>
            <li>
                <a href="<?= site_url("Galeria/IrPrincipal")?>" title='Galería'>
                    <i class="fas fa-film"></i>
                    <span class="links_name">Galería</span>
                </a>
                <span class="tooltip">Galería</span>
            </li>
            <?php if ($this->session->userdata("acceso9")!=null){ ?>
            <li>
                <a href="<?= site_url("GuiasTecnicas/IrPrincipal")?>" title='Guías técnicas'>
                    <i class="fas fa-paste"></i>
                    <span class="links_name">Guías técnicas</span>
                </a>
                <span class="tooltip">Guías técnicas</span>
            </li>
            <?php } ?>
            <?php if ($this->session->userdata("nombre")!=null){ ?>
            <li>
                <a href="<?= site_url("Solicitudes/consultar")?>" title='Solicitudes'>
                    <i class="fas fa-folder"></i>
                    <span class="links_name">Solicitudes</span>
                </a>
                <span class="tooltip">Solicitudes</span>
            </li>
            <?php } ?>
            <?php if ($this->session->userdata("acceso8")!=null){ ?>
            <li>
                <a href="<?= site_url("Noticias/consultar")?>" title='Noticias'>
                    <i class="fas fa-newspaper"></i>
                    <span class="links_name">Noticias</span>
                </a>
                <span class="tooltip">Noticias</span>
            </li>
            <?php } ?>
            <?php if ($this->session->userdata("acceso7")!=null){ ?>
            <li>
                <a href="<?= site_url("Usuarios/consultar")?>" title='Usuarios'>
                    <i class="fas fa-users"></i>
                    <span class="links_name">Usuarios</span>
                </a>
                <span class="tooltip">Usuarios</span>
            </li>
            <li>
                <a href="<?= site_url("Perfiles/consultar")?>" title='Perfiles'>
                    <i class="fas fa-id-card"></i>
                    <span class="links_name">Perfiles</span>
                </a>
                <span class="tooltip">Perfiles</span>
            </li>
            <li>
                <a href="<?= site_url("Roles/consultar")?>" title='Roles'>
                    <i class="fas fa-user-tag"></i>
                    <span class="links_name">Roles</span>
                </a>
                <span class="tooltip">Roles</span>
            </li>
            <?php } ?>
            <li>
                <div><br><br></div>
            </li>
        </ul>
    </div>
    <!-- Sidebar - Menu -->

    <!-- Home - section -->
    <section class="home-section">

        <!-- Content Wrapper --> 
        <div class="container-fluid" id="content-wrapper">  
            
<script>
    $(function() {
        $( document ).ready(function() {
            enSession();
        });
        
        $("#correo").keypress(function(e) {
            if(e.which == 13) {
                
                iniciarSesion();
            }
        });

        $("#password").keypress(function(e) {
            if(e.which == 13) {
                iniciarSesion();
            }
        });      
    })

    function enSession() { 
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Login/inSesion") ?>",
            success: function(data) {
            }, complete: function() {}
        });
    }

    function registrarse(){
        setTimeout(() => {
            location.href = "<?= site_url("Registro/Nuevo") ?>"
        }, 100);
    }

    function iniciarSesion() {      
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Login/index") ?>",
            data: $("#frmLogin").serialize(),
            success: function(data) {
                if (data.errorLogin) {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: data.errormsg
                    })
                }else{
                    Swal.fire({
                        icon: 'success',
                        title: 'Bienvenido '+data.userNombre,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(() => {
                        location.reload()  
                    }, 1500);
                }
            }, 
            complete: function() {               
            }
        });
    }
</script>