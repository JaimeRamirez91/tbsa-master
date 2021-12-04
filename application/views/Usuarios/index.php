<style>
    .whiteText{
        color: white !important;
        background-color: #adaeb8 !important;
    }
    .whiteText>.sorting_1{
        color: white !important;
        background-color: inherit !important;
    }
</style>

<div class="container-fluid" id="PadreContenido"> 
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="">
                <h4 class="m-0 font-weight-bold">Usuarios</h4>
            </div>

        </div>
        
        <div class="card-body">


            <div class="container d-flex flex-wrap">
                <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" method="post" action="Consultar">
                    <div class="input-group">   
                        <input class="form-control" type="search" id="buscar" name="buscar" placeholder="Búsqueda" value="<?= isset($buscar)  ? $buscar : "" ?>" aria-label="Búsqueda">
                        <button type="submit" class="btn btn-success" value="Buscar"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </form>
                
                <div class="text-end">
                    <a href="<?= site_url("Usuarios/Nuevo") ?>" class="btn btn-primary"><i class="fas fa-plus"></i> <span>Agregar</span></a>
                </div>
            </div>

            <br>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tableUsuarios" name="tableUsuarios">
                    <thead>
                        <tr>
                        <th scope="col"><span class="">Nombre</span></th>
                        <th scope="col"><span class="d-none d-xl-block">Correo</span></th>
                        <th scope="col"><span class="d-none d-md-block">Perfil</span></th>
                        <th scope="col"><span class="d-none d-sm-block">Estado</span></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 0;
                        $pag = 1;
                        $pagValor = $valorPag;
                        foreach ($Usuarios as $d) { ?>
                            <?php 
                            $cont = $cont +1; 
                            if($pag == $pagValor){
                            ?>

                            <tr>
                                <td><span class=""><?= $d["nombre"] ?></span></td>
                                <td><span class="d-none d-xl-block"><?= $d["correo"] ?></span></td>
                                <td><span class="d-none d-md-block"><?= $d["nomPerfil"] ?></span></td>
                                <td><span class="d-none d-sm-block"><?= $d["estado"] ?></span></td>
                                <td class="text-end" style="width:170px">
                                    <button class='btn btn-secondary btn-sm' onclick='verDatos(<?=$d["idUsuario"]?>)' title='Ver Datos'><i class='fas fa-list'></i></button>
                                    <a class='btn btn-primary btn-sm'  href='<?php echo site_url("Usuarios/Editar") ?>/<?= $d["idUsuario"] ?>' title='Editar'><i class='fas fa-edit'></i></a>
                                    <button onclick='ConfirmDel(<?=$d["idUsuario"]?>,"<?=$d["nombre"]?>")' class='btn btn-warning btn-sm' title='Eliminar'><i class='fas fa-window-close'></i></button>
                                    <button onclick='cambiarPassword(<?=$d["idUsuario"]?>,"<?=$d["nombre"]?>")' class='btn btn-info btn-sm' title='Modificar Password'><i class='fas fa-key'></i></button>
                                </td>
                            </tr>
                            
                        <?php 
                            }
                            if($cont%10 == 0){ $pag = $pag + 1; }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="container d-flex flex-wrap">
                    <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
                        <span>Mostrando <?php 
                        if($pagValor>1){
                            echo ($pagValor*10)-9;}
                        else{
                            if($cont>0){
                                echo 1;
                            }else{
                                echo 0;
                            }}?> 
                        al <?php 
                        if(($pagValor)*10 > $cont){ 
                            echo $cont;}
                        else{echo ($pagValor)*10;}?> 
                        de <?=$cont?> registros</span>
                    </div>
                    <div>
                        <ul class="pagination">
                            <?php if ($pagValor > 1){ ?>
                            <form  id="frmEnviar" class="text-end" method="post" action="Consultar" >
                                <input type="hidden" id="buscar" name="buscar" value="<?= isset($buscar)  ? $buscar : "" ?>">
                                <input type="hidden" id="valor" name="valor" value='<?=$pagValor-2 ?>'>

                                    <li ><input class="page-item page-link" value="Anterior"  type="submit"></li>  

                            </form>
                                <?php } ?>

                                    <li class="page-item"><label class="form-control" for="" id="labelPagina" name="labelPagina">pág <?=$pagValor ?> de <?=$pag ?></label></li>

                                <?php if ($pagValor < $pag){ ?>
                            <form  id="frmEnviar" class="text-end" method="post" action="Consultar" >
                                    <input type="hidden" id="buscar" name="buscar" value="<?= isset($buscar)  ? $buscar : "" ?>">
                                    <input type="hidden" id="valor" name="valor" value='<?=$pagValor ?>'>
                                    
                                    <li ><input class="page-item page-link" value="Siguiente"  type="submit"></li>
                            </form>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UsuariosModal" tabindex="-1" role="dialog" aria-labelledby="UsuariosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UsuariosModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="frm">
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 mb-3 mb-sm-0">
                                    <label for="Nombre">Nombre:</label>                                
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 mb-3 mb-sm-0">
                                    <label style="font-weight:bold;" id="Nombre" name="Nombre">Nombre</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-xs-9 mb-3 mb-sm-0">
                                    <label for="Correo">Correo:</label>
                                    
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 mb-3 mb-sm-0">
                                    <label style="font-weight:bold;" id="Correo" name="Correo">Correo</label>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-3 mb-sm-0">
                                    <label for="Estado">Estado:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9  mb-3 mb-sm-0">
                                    <strong id="Estado" name="Estado">Estado</strong>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-3 mb-sm-0">
                                    <label for="Telefono">Teléfono:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9  mb-3 mb-sm-0">
                                    <strong id="Telefono" name="Telefono">Telefono</strong>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="ccol-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-3 mb-sm-0">
                                    <label for="Perfil">Perfil:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9  mb-3 mb-sm-0">
                                    <strong id="Perfil" name="Perfil">Perfil</strong>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 mb-sm-0">
                                    <label for="NIT">NIT:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9  mb-3 mb-sm-0">
                                    <strong id="NIT" name="NIT">NIT</strong>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-3 mb-sm-0">
                                    <label for="DUI">DUI:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 mb-3 mb-sm-0">
                                    <strong id="DUI" name="DUI">DUI</strong>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-3 mb-sm-0">
                                    <label for="Direccion">Dirección:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 mb-3 mb-sm-0">
                                    <strong id="Direccion" name="Direccion">Direccion</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3  mb-sm-0">
                                    <label for="Mercaderia">Productos que ofrece:</label>
                                </div>
                                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9  mb-0 mt-auto mb-sm-0">
                                    <strong id="Mercaderia" name="Mercaderia">Mercaderia</strong>
                                </div> 
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button onclick="salir()" class="btn btn-danger" type="button" >Salir</button>
                    <!--<button onclick="guardar()" class="btn btn-primary" type="button">Guardar</button>-->
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="CambiarPasswordModal" tabindex="-1" role="dialog" aria-labelledby="CambiarPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CambiarPasswordModalLabel"></h5>
                </div>
                <div class="modal-body">
                    <form id="frmPassword">
                        <input type="hidden" name="idUsuario" id="idUsuario">
                        <div class="form-group col">
                            <div class="row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="usuarioP">Usuario:</label>
                                    <strong id="usuarioP" name="usuarioP">Usuario</strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <div class="row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="password">Nueva Contraseña:</label>
                                    <input class="form-control" type="password" id="password" name="password">
                                </div>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="password2">Confirmar Contraseña:</label>
                                    <input class="form-control" type="password" id="password2" name="password2">
                                </div>
                                
                                
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="guardarPassword()" class="btn btn-primary" type="button">Guardar</button>
                    <button onclick="salir2()" class="btn btn-danger" type="button" >Salir</button>
                </div>
            </div>
        </div>
    </div>

</div>



<script>

    $(function() {

        

    })


    function guardarPassword() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Usuarios/guardarPassword") ?>",
            data: $("#frmPassword").serialize(),
            success: function(data) {
                if (data.Error) {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: data.Value
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: data.Value,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#CambiarPasswordModal").modal("toggle")
                }
            },
            complete: function() {


                cargarDetalle(true);
            }
        });
    }

    function ConfirmDel(idUsuario, nombre) {
        setTimeout(() => {    
            Swal.fire({
                title: '¿Desea eliminar el usuario "' +nombre+'"  ?',
                icon: 'warning',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminar el usuario'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(idUsuario);
                }
            })
        }, 500);  
    }

    function eliminar(idUsuario) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Usuarios/eliminar") ?>",
            data: {
                idUsuario: idUsuario
            },
            success: function(data) {
                if (data.Error) {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: data.Value
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: data.Value,
                        showConfirmButton: false,
                        timer: 1500
                    })

                    setTimeout(() => {
                        location.href = "<?= site_url("Usuarios/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function cambiarPassword(idUsuario, nombre) {
        setTimeout(() => {
            $("#CambiarPasswordModalLabel").html("Modificar Password");
            $("#idUsuario").val(idUsuario);
            $("#usuarioP").html(nombre);
            $("#password").val("");
            $("#password2").val("");
            $("#CambiarPasswordModal").modal("show");
        }, 500);
    }

    function verDatos(idUsuario) {  
       $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Usuarios/getSingle") ?>",
                data: {
                    idUsuario: idUsuario
                },
                success: function(data) {
                    $("#UsuariosModalLabel").html("Datos Usuario");
                    $("#Nombre").html(data[0].nombre);
                    $("#Correo").html(data[0].correo);
                    $("#Perfil").html(data[0].nomPerfil);
                    $("#Telefono").html(data[0].telefono);
                    $("#DUI").html(data[0].dui);
                    $("#NIT").html(data[0].nit);
                    $("#Telefono").html(data[0].telefono);
                    $("#Estado").html(data[0].estado);
                    $("#estadoFondo").html(data[0].estado);
                    $("#Direccion").html(data[0].direccion + ", "+data[0].nomMunicipio+", "+data[0].nomDepartamento);
                    $("#Mercaderia").html(data[0].mercaderia + ".");
                    $("#UsuariosModal").modal("show");
                },
            }); 

    }
    function salir() {
        $("#UsuariosModal").modal("toggle");
    }

    function salir2() {
        $("#CambiarPasswordModal").modal("toggle");
    }
</script>