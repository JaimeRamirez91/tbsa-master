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
            <li class="breadcrumb-item active" aria-current="page">Roles</li>

        </ol>
    </nav>

    <center>
        <div class="card shadow mb-4 col-lg-6 col-sm-12">
            <div class="card-header py-3 d-flex">
                <div class="">
                <h4 class="m-0 font-weight-bold">Roles</h4>
                </div>

            </div>
            
            <div class="card-body">


                <div class="container d-flex flex-wrap">
                    <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" method="post" action="consultar">
                    <div class="input-group">   
                    <input class="form-control" type="search" id="buscar" name="buscar" placeholder="Búsqueda" value="<?= isset($buscar)  ? $buscar : "" ?>" aria-label="Búsqueda">
                    <button type="submit" class="btn btn-success" value="Buscar"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                    </form>
                    
                    <div class="text-end">
                    <button onclick="AgregarRol()" class="btn btn-primary"><i class="fas fa-plus"></i> <span>Agregar</span></button>
                    </div>
                </div>

                <br>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tableUsuarios" name="tableUsuarios">
                <thead>
                    <tr>
                    <th scope="col">Rol</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                
                    <tbody>
                        <?php
                        $cont = 0;
                        $pag = 1;
                        $pagValor = $valorPag;
                        foreach ($roles as $d) { ?>
                            <?php 
                            $cont = $cont +1; 
                            if($pag == $pagValor){
                            ?>

                            <tr>
                                <td><?= $d["nomRol"] ?></td>
                                <td class="text-end">
                                    <button class='btn btn-secondary btn-sm' onclick='verDetalles(<?=$d["idRol"]?>)' title='Detalles'><i class='fas fa-list'></i></button>
                                    <button class='btn btn-primary btn-sm'  onclick='editar(<?=$d["idRol"]?>)' title='Editar'><i class='fas fa-edit'></i></button>
                                    <button onclick='ConfirmDel(<?=$d["idRol"]?>,"<?=$d["nomRol"]?>")' class='btn btn-warning btn-sm' title='Eliminar'><i class='fas fa-window-close'></i></button>
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
                                        al 
                                        <?php 
                                        if(($pagValor)*10 > $cont){ 
                                            echo $cont;}
                                        else{echo ($pagValor)*10;}?> 
                                        de <?=$cont?> registros</span>
                    </div>
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
    </center>

    <div class="modal fade" id="AgregarRolModal" tabindex="-1" role="dialog" aria-labelledby="AgregarRolModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AgregarRolModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="frmAgregarRol">
                        <input type="hidden" name="idRol" id="idRol" value="<?= isset($Perfil["idRol"]) ? $Perfil["idRol"] : 0?>">
                        <div class="form-group col">
                            <div class="form-group row">
                                 <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="nomRol">Rol:</label>
                                    <input class="form-control mb-2" type="" placeholder="Nombre" id="nomRol" name="nomRol">
                                </div>
                            </div>  
                        </div>
                        
                        <div class="form-group col">
                            <div class="row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="">Accesos:</label>
                                    </div>
                            </div>
                            <div class="col">
                                <?php
                                    foreach($accesos as $r){  ?>
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="checkbox" class="checar" name="acceso<?= $r["idAcceso"]?>" id="idAcceso<?= $r["idAcceso"]?>" value="<?= $r["idAcceso"]?>">
                                        <strong><label for="idAcceso<?= $r["idAcceso"]?>"><?=$r["nomAcceso"]?></label></strong>
                                    </div>
                                <?php }
                                
                                ?>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="guardarRol()" class="btn btn-primary" id="btnGuardar" type="button">Guardar</button>
                        <button onclick="salirRol()" class="btn btn-danger" type="button" >Salir</button>
                    </div>
                </div>                
            </div>
    </div>

</div>
<script>

    var valor = 0;
    $(function() {

        

    })


  

    function guardarRol() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Roles/guardarRol") ?>",
            data: $("#frmAgregarRol").serialize(),
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
                    $("#AgregarRolModal").modal("toggle")

                    setTimeout(() => {
                        location.href = "<?= site_url("Roles/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function ConfirmDel(idRol, nomRol) {
        setTimeout(() => {    
            Swal.fire({
                title: '¿Desea eliminar el rol "'+ nomRol +'" ?',
                icon: 'warning',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminar el perfil'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(idRol);
                }
            })
        }, 500);  
    }

    function eliminar(idRol) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Roles/eliminar") ?>",
            data: {
                idRol: idRol
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
                        location.href = "<?= site_url("Roles/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }


    function AgregarRol() {
        setTimeout(() => {
            $("#AgregarRolModalLabel").html("Agregar Rol");
            $(".checar").removeAttr("disabled");
            $("#nomRol").removeAttr("disabled");
            $("#btnGuardar").show();
            $("#nomRol").val("");
            $("#idRol").val("0");
            $(".checar").prop("checked", false);
            $("#AgregarRolModal").modal("show");
        }, 500);
    }

    function verDetalles(idRol) {  
       $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Roles/verDetalles") ?>",
                data: {
                    idRol: idRol
                },
                success: function(data) {
                    $("#AgregarRolModalLabel").html("Detalles Rol");
                    $("#nomRol").val(data[0].nomRol);
                    $("#idRol").val(data[0].idRol);
                    
                    $(".checar").prop("checked", false);
                    
                    for (var i = 0; i < data.length; i++) {
                        $("#idAcceso"+data[i].idAcceso).prop('checked', true);
                    }

                    $(".checar").attr("disabled", 'disabled');
                    $("#nomRol").attr("disabled", 'disabled');
                    $("#btnGuardar").hide();
                    $("#AgregarRolModal").modal("show");
                },
            }); 

    }

    function editar(idRol){
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Roles/verDetalles") ?>",
                data: {
                    idRol: idRol
                },
                success: function(data) {
                    $("#AgregarRolModalLabel").html("Editar Rol");
                    $(".checar").removeAttr("disabled");
                    $("#nomRol").removeAttr("disabled");
                    $("#btnGuardar").show();
                    $("#nomRol").val(data[0].nomRol);
                    $("#idRol").val(data[0].idRol);
                    
                    $(".checar").prop("checked", false);
                    
                    for (var i = 0; i < data.length; i++) {
                        $("#idAcceso"+data[i].idAcceso).prop('checked', true);
                    }
                    $("#AgregarRolModal").modal("show");
                },
            }); 
    }

    function salirRol() {
        $("#AgregarRolModal").modal("toggle");
    }
</script>