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
            <li class="breadcrumb-item active" aria-current="page">Perfiles</li>

        </ol>
    </nav>

    <center>
        <div class="card shadow mb-4 col-lg-6 col-sm-12">
            <div class="card-header py-3 d-flex">
                <div class="">
                <h4 class="m-0 font-weight-bold">Perfiles</h4>
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
                    <button onclick="agregarPerfil()" class="btn btn-primary"><i class="fas fa-plus"></i> <span>Agregar</span></button>
                    </div>
                </div>

                <br>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tableUsuarios" name="tableUsuarios">
                <thead>
                    <tr>
                    <th scope="col">Perfil</th>
                    <th scope="col"><span class="d-none d-sm-block">Mostrar</span></th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                
                    <tbody>
                        <?php
                        $cont = 0;
                        $pag = 1;
                        $pagValor = $valorPag;
                        foreach ($perfiles as $d) { ?>
                            <?php 
                            $cont = $cont +1; 
                            if($pag == $pagValor){
                            ?>

                            <tr>
                                <td><?= $d["nomPerfil"] ?></td>
                                <td><span class="d-none d-sm-block"><?= $d["mostrar"] ?></span></td>
                                <td class="text-end">
                                    <button class='btn btn-secondary btn-sm' onclick='verDetalles(<?=$d["idPerfil"]?>)' title='Detalles'><i class='fas fa-list'></i></button>
                                    <button class='btn btn-primary btn-sm'  onclick='editar(<?=$d["idPerfil"]?>)' title='Editar'><i class='fas fa-edit'></i></button>
                                    <button onclick='ConfirmDel(<?=$d["idPerfil"]?>,"<?=$d["nomPerfil"]?>")' class='btn btn-warning btn-sm' title='Eliminar'><i class='fas fa-window-close'></i></button>
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

    <div class="modal fade" id="AgregarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="AgregarPerfilModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AgregarPerfilModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="frmAgregarPerfil">
                        <input type="hidden" name="idPerfil" id="idPerfil" value="<?= isset($Perfil["idPerfil"]) ? $Perfil["idPerfil"] : 0?>">
                        <div class="form-group col">
                            <div class="form-group row">
                                 <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="nomPerfil">Perfil:</label>
                                    <input class="form-control mb-2" type="" placeholder="Nombre" id="nomPerfil" name="nomPerfil">
                                </div>
                            </div>          
                                 
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="mostrar">Mostrar público:</label>
                                <select class="form-select mb-2" name="mostrar" id="mostrar">
                                    <option value="2">Seleccionar</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col">
                            <div class="row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="">Roles:</label>
                                    </div>
                            </div>
                            <div class="col">
                                <?php
                                    foreach($roles as $r){  ?>
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="checkbox" class="checar" name="rol<?= $r["idRol"]?>" id="idRol<?= $r["idRol"]?>" value="<?= $r["idRol"]?>">
                                        <strong><label for="idRol<?= $r["idRol"]?>"><?=$r["nomRol"]?></label></strong>
                                    </div>
                                <?php }
                                
                                ?>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="guardarPerfil()" class="btn btn-primary" id="btnGuardar" type="button">Guardar</button>
                        <button onclick="salirPerfil()" class="btn btn-danger" type="button" >Salir</button>
                    </div>
                </div>                
            </div>
    </div>

</div>
<script>

    var valor = 0;
    $(function() {

        

    })


  

    function guardarPerfil() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Perfiles/guardarPerfil") ?>",
            data: $("#frmAgregarPerfil").serialize(),
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
                    $("#AgregarPerfilModal").modal("toggle")

                    setTimeout(() => {
                        location.href = "<?= site_url("Perfiles/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function ConfirmDel(idPerfil, nomPerfil) {
        setTimeout(() => {    
            Swal.fire({
                title: '¿Desea eliminar el perfil "'+ nomPerfil +'" ?',
                icon: 'warning',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminar el perfil'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(idPerfil);
                }
            })
        }, 500);  
    }

    function eliminar(idPerfil) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Perfiles/eliminar") ?>",
            data: {
                idPerfil: idPerfil
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
                        location.href = "<?= site_url("Perfiles/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }


    function agregarPerfil() {
        setTimeout(() => {
            $("#AgregarPerfilModalLabel").html("Agregar Perfil");
            $(".checar").removeAttr("disabled");
            $("#nomPerfil").removeAttr("disabled");
            $("#mostrar").removeAttr("disabled");
            $("#btnGuardar").show();
            $("#nomPerfil").val("");
            $("#idPerfil").val("0");
            $("#mostrar").val(2);
            $(".checar").prop("checked", false);
            $("#AgregarPerfilModal").modal("show");
        }, 500);
    }

    function verDetalles(idPerfil) {  
       $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Perfiles/verDetalles") ?>",
                data: {
                    idPerfil: idPerfil
                },
                success: function(data) {
                    $("#AgregarPerfilModalLabel").html("Detalles perfil");
                    $("#nomPerfil").val(data[0].nomPerfil);
                    $("#mostrar").val(data[0].mostrar);
                    $("#idPerfil").val(data[0].idPerfil);
                    
                    $(".checar").prop("checked", false);
                    
                    for (var i = 0; i < data.length; i++) {
                        $("#idRol"+data[i].idRol).prop('checked', true);
                    }

                    $(".checar").attr("disabled", 'disabled');
                    $("#nomPerfil").attr("disabled", 'disabled');
                    $("#mostrar").attr("disabled", 'disabled');
                    $("#btnGuardar").hide();
                    $("#AgregarPerfilModal").modal("show");
                },
            }); 

    }

    function editar(idPerfil){
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Perfiles/verDetalles") ?>",
                data: {
                    idPerfil: idPerfil
                },
                success: function(data) {
                    $("#AgregarPerfilModalLabel").html("Editar perfil");
                    $(".checar").removeAttr("disabled");
                    $("#nomPerfil").removeAttr("disabled");
                    $("#mostrar").removeAttr("disabled");
                    $("#btnGuardar").show();
                    if (data[0].nomPerfil == "Director CA" || data[0].nomPerfil == "Técnico CA"){
                        $("#nomPerfil").attr("disabled", 'disabled');
                        $("#mostrar").attr("disabled", 'disabled');
                    }
                    $("#nomPerfil").val(data[0].nomPerfil);
                    $("#mostrar").val(data[0].mostrar);
                    $("#idPerfil").val(data[0].idPerfil);
                    
                    $(".checar").prop("checked", false);
                    
                    for (var i = 0; i < data.length; i++) {
                        $("#idRol"+data[i].idRol).prop('checked', true);
                    }
                    $("#AgregarPerfilModal").modal("show");
                },
            }); 
    }

    function salirPerfil() {
        $("#AgregarPerfilModal").modal("toggle");
    }
</script>