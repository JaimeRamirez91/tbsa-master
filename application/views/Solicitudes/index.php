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
            <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>
        </ol>
    </nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div class="">
                <h4 class="m-0 font-weight-bold">Solicitudes</h4>
            </div>

        </div>
        
        <div class="card-body">


            <div class="row">
                <form class="col-12 col-sm-7 col-lg-5 col-xl-3 mb-2 mb-lg-0 me-lg-auto" method="post" action="Consultar">
                    <div class="input-group">   
                        <input class="form-control" type="search" id="buscar" name="buscar" placeholder="Búsqueda" value="<?= isset($buscar)  ? $buscar : "" ?>" aria-label="Búsqueda">
                        <button type="submit" class="btn btn-success" value="Buscar"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </form>
                
                <div class="col-12 col-lg-4 col-xl-3 col-md-5 col-sm-10 text-end">
                        <form  id="frmEnviar" class="text-end" method="post" action="" >
                                <div class="row">    
                                    <button type="button" onclick="nuevaSolicitud()" class="col btn btn-primary" value="agregar"><i class="fas fa-plus"></i> Agregar</button>
                                    &nbsp
                                    <select class="form-select col" name="tipoSolicitudAgregar" id="tipoSolicitudAgregar">
                                        <option value="0">Tipo Solicitud</option>
                                        <?php if ($this->session->userdata("acceso1")!=null){ ?><option value="1">Agro-mercado</option><?php }?>
                                        <?php if ($this->session->userdata("acceso2")!=null){ ?><option value="2">Capacitación</option><?php }?>
                                        <?php if ($this->session->userdata("acceso3")!=null){ ?><option value="3">Asistencia Técnica</option><?php }?>
                                        <?php if ($this->session->userdata("acceso4")!=null){ ?><option value="4">Gestión Ambiental</option><?php }?>
                                        <?php if ($this->session->userdata("acceso5")!=null){ ?><option value="5">Gestión Empresarial</option><?php }?>
                                        <?php if ($this->session->userdata("acceso6")!=null){ ?><option value="6">Planes de negocio</option><?php }?>
                                    </select>
                                </div>
                        </form>
                </div>
            </div>
                          


            <br>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tableUsuarios" name="tableUsuarios">
                    <thead>
                        <tr>
                        <th scope="col"><span class="">Solicita</span></th>
                        <th scope="col"><span class="d-none d-md-block">Tipo Solicitud</span></th>
                        <th scope="col"><span class="d-none d-xl-block">Fecha Solicitud</span></th>
                        <th scope="col"><span class="d-none d-xl-block">Fecha Evento</span></th>
                        <th scope="col"><span class="d-none d-sm-block">Estado</span></th>
                        <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 0;
                        $pag = 1;
                        $pagValor = $valorPag;
                        foreach ($Solicitudes as $d) { ?>
                            <?php 
                            $cont = $cont +1; 
                            if($pag == $pagValor){
                            ?>

                            <tr>
                                <td><span class=""><?= $d["nombre"] ?></span></td>
                                <td><span class="d-none d-md-block"><?= $d["tipoSolicitud"] ?></span></td>
                                <td><span class="d-none d-xl-block"><?= date_format(date_create($d["fechaSolicitud"]),"d/m/Y") ?></span></td>
                                <?php if($d["fechaHoraEvento"]){?>
                                    <td><span class="d-none d-xl-block"><?= date_format(date_create($d["fechaHoraEvento"]),"d/m/Y H:i") ?></span></td>
                                <?php }else{ ?>
                                    <td><span class="d-none d-xl-block"><?= $d["fechaHoraEvento"] ?></span></td>
                                <?php } ?>
                                <td><span class="d-none d-sm-block"><?= $d["estado"] ?></span></td>
                                <td class="text-end" style="width:190px">
                                    <?php if($this->session->userdata("nomPerfil")=="Director CA"){?>
                                        <?php if($d["estado"]=="PENDIENTE"){?>
                                            <button onclick='aprobarSolicitud(<?=$d["idSolicitud"]?>)' class='btn btn-info btn-sm' title='Aprobar'><i class='fas fa-check'></i></button>
                                            <button onclick='denegarSolicitud(<?=$d["idSolicitud"]?>)' class='btn btn-info btn-sm' title='Denegar'><i class='fas fa-ban'></i></button>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($d["estado"]!="APROBADA"){?>  
                                        <button onclick='ConfirmDel(<?=$d["idSolicitud"]?>,"<?=$d["tipoSolicitud"]?>")' class='btn btn-warning btn-sm' title='Eliminar'><i class='fas fa-window-close'></i></button>
                                    <?php }?>
                                    <?php if($this->session->userdata("nomPerfil")=="Director CA" || $d["estado"]=="PENDIENTE"){?>    
                                        <button class='btn btn-primary btn-sm'  onclick='editar(<?=$d["idSolicitud"]?>)' title='Editar'><i class='fas fa-edit'></i></button>
                                    <?php } ?>
                                        <button class='btn btn-secondary btn-sm' onclick='verDatos(<?=$d["idSolicitud"]?>)' title='Ver Detalles'><i class='fas fa-list'></i></button>
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

    <div class="modal fade" id="SolicitudModal" tabindex="-1" role="dialog" aria-labelledby="SolicitudModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SolicitudModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="frmSolicitud">
                        <input type="hidden" id="tipoSolicitud" name="tipoSolicitud">
                        <input type="hidden" id="idUsuario" name="idUsuario" value=<?= $this->session->userdata("idUsuario") ?>>
                        <input type="hidden" id="idSolicitud" name="idSolicitud" value=0>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="solicitante" id="labelSolicitante">Solicitante:</label>
                                        <input class="form-control mb-2" type="" placeholder="Nombre" id="solicitante" name="solicitante" disabled value="<?= $this->session->userdata("nombre") ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="mercaderia" id="labelMercaderia">Productos que ofrece:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="mercaderia" name="mercaderia" disabled value="<?= $this->session->userdata("mercaderia") ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="area" id="labelArea">Área:</label>
                                        <select class="form-select col mb-2" name="area" id="area">
                                            <option value="0">Selecionar</option>
                                            <option value="1">AGRICOLA</option>
                                            <option value="2">PECUARIA</option>
                                            <option value="3">OTRO</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="areaProductiva" id="labelAreaProductiva">Cantidad área productiva:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="areaProductiva" name="areaProductiva">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="temaCapacitacion" id="labelTema">Tema:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="temaCapacitacion" name="temaCapacitacion">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="servicioSolicitado" id="labelServicio">Área de gestión:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="servicioSolicitado" name="servicioSolicitado">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="fecha" id="labelFecha">Fecha:</label>
                                        <input class="form-control mb-2" type="date" placeholder="" min="<?php $hoy=date("Y-m-d"); echo $hoy;?>" id="fecha" name="fecha">
                                    </div>
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="hora" id="labelHora">Hora:</label>
                                        <input class="form-control mb-2" type="time" placeholder="" id="hora" name="hora">
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="nPersonas" id="labelNPersonas">Cantidad de personas:</label>
                                        <input class="form-control mb-2" type="number" placeholder="" id="nPersonas" name="nPersonas">
                                    </div>
                                    <div class="col-6 mb-3 mb-sm-0">
                                        <label for="otroContacto" id="labelOtroContacto">Teléfono:</label>
                                        <input class="form-control mb-2" type="" maxlength="9" placeholder="" id="otroContacto" name="otroContacto">
                                    </div>
                                </div>  
                                <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label for="direccionEvento" id="labelLugar">Lugar:</label>
                                            <input class="form-control mb-2" type="" placeholder="Dirección" id="direccionEvento" name="direccionEvento">
                                        </div>
                                        <div class="col-6 mb-3 mb-sm-0">
                                            <label for="mostrar">Departamento:</label>
                                            <select class="form-select mb-2" name="idDepartamento" id="idDepartamento">
                                                        <option value="0">Seleccionar</option>
                                                        <?php
                                                        if ($editar) {                                       
                                                            foreach ($departamentos as $c) {
                                                                if($municipioSelec["idDepartamento"] == $c["idDepartamento"]){?>
                                                                <option value="<?= $c["idDepartamento"]?>" selected>                                            
                                                                    <?= $c["nomDepartamento"]?></option>
                                                                <?php
                                                                } else {?>
                                                                    <option value="<?= $c["idDepartamento"]?>">                                            
                                                                    <?= $c["nomDepartamento"]?></option>
                                                                <?php
                                                                }
                                                            }
                                                        } else {
                                                            foreach ($departamentos as $c) {
                                                                ?>
                                                                    <option value="<?= $c["idDepartamento"]?>">
                                                                    <?= $c["nomDepartamento"]?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                        </div>
                                        <div class="col-6 mb-3 mb-sm-0">
                                            <label for="idMunicipio">Municipio:</label>
                                            <select class="form-select mb-2" name="idMunicipio" id="idMunicipio">
                                                <option value="0">Seleccionar</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 mb-3 mb-sm-0">
                                        <label for="cantidadProduccion" id="labelCantidadProduccion">Cantidad que produce (Manzanas):</label>
                                        <input class="form-control mb-2" type="" step=0.25 placeholder="" id="cantidadProduccion" name="cantidadProduccion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 mb-3 mb-sm-0">
                                        <label for="tiempoProduccion" id="labelTiempoProduccion">Años de producción:</label>
                                        <input class="form-control mb-2" type="number" step=0.25 placeholder="" id="tiempoProduccion" name="tiempoProduccion">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="comentario">Comentario:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="comentario" name="comentario">
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="observacionCA" id="labelObservacionCA">Observación Centro de Agronegocios:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="observacionCA" name="observacionCA">
                                    </div>
                                </div>  
                        </form>


                </div>
                <div class="modal-footer">
                
                    <button onclick="guardarSolicitud()" class="btn btn-primary" id="btnGuardar" type="button">Guardar</button>
                    <button onclick="salir()" class="btn btn-danger" type="button" id="btnSalirModal" >Salir</button>
                    <!--<button onclick="guardar()" class="btn btn-primary" type="button">Guardar</button>-->
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="ObservacionModal" tabindex="-1" role="dialog" aria-labelledby="ObservacionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ObservacionModalLabel"></h5>
                    </div>
                    <div class="modal-body">
                        <form id="frmObservacion">
                        <input type="hidden" id="valor" name="valor" value=0>
                        <input type="hidden" id="idSolicitudO" name="idSolicitudO" value=0>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label for="observacionCA2" id="labelObservacionCA2">Observación:</label>
                                        <input class="form-control mb-2" type="" placeholder="" id="observacionCA2" name="observacionCA2" >
                                    </div>
                                </div>
                        </form>


                </div>
                <div class="modal-footer">
                
                    <button onclick="guardarObservacion()" class="btn btn-primary" id="btnGuardarObservacion" type="button">Guardar</button>
                    <button onclick="salirObservacion()" class="btn btn-danger" type="button" id="btnSalirModal2" >Salir</button>
                    <!--<button onclick="guardar()" class="btn btn-primary" type="button">Guardar</button>-->
                </div>
            </div>
        </div>

    </div>



</div>



<script>

    $(function() {
        $("#idDepartamento").on("change", function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: $("#idDepartamento").val()
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                    }
                },
            });
        })

        tam = 0;

        $("#otroContacto").keyup( function(e) {
            if((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8) {
            
                if($("#otroContacto").val().length > tam){
                    if ($("#otroContacto").val().length == 4){ 
                        texto = $("#otroContacto").val();
                        $("#otroContacto").val(texto + "-");
                    }
                }
                else{
                    if ($("#otroContacto").val().length == 4){ 
                        texto = $("#otroContacto").val();
                        $("#otroContacto").val(texto.substring(0, texto.length - 1));
                    }
                }
                tam = $("#otroContacto").val().length;
        } else {
                texto = $("#otroContacto").val();
                $("#otroContacto").val(texto.substring(0, texto.length - 1));
        }
            

})
        

    })

    function guardarSolicitud() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/guardarSolicitud") ?>",
            data: $("#frmSolicitud").serialize(),
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
                    $("#SolicitudModal").modal("toggle");
                    $("#tipoSolicitudAgregar").val(0);
                    setTimeout(() => {
                        location.href = "<?= site_url("Solicitudes/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function nuevaSolicitud() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/NuevaSolicitud") ?>",
            data: $("#frmEnviar").serialize(),
            success: function(data) {
                switch(data){
                    case 1:
                        solicitudAgromercado(data);
                    break;
                    case 2:
                        solicitudCapacitacion(data);
                    break;
                    case 3:
                        solicitudAsistenciaTecnica(data);
                    break;
                    case 4:
                        solicitudGestionAmbiental(data);
                    break;
                    case 5:
                        solicitudGestionEmpresarial(data);
                    break;
                    case 6:
                        solicitudPlanesNegocio(data);
                    break;
                    default:
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: 'Debe seleccionar tipo de solicitud'
                    })
                    break;
                }
            }
        });
    }

    function ConfirmDel(idSolicitud, tipoSolicitud) {
        setTimeout(() => {    
            Swal.fire({
                title: '¿Eliminar la solicitud de "' +tipoSolicitud+'"  ?',
                icon: 'warning',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminar solicitud'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminar(idSolicitud);
                }
            })
        }, 500);  
    }

    function eliminar(idSolicitud) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/EliminarSolicitud") ?>",
            data: {
                idSolicitud: idSolicitud
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
                        location.href = "<?= site_url("Solicitudes/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function verDatos(idSolicitud) {      
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/getSingle") ?>",
            data: {
                idSolicitud: idSolicitud
            },
            success: function(data) {

                switch(data[0].tipoSolicitud){
                    case 'Agro-mercado':
                        verSolicitudAgromercado(data);
                    break;
                    case 'Capacitación':
                        verSolicitudCapacitacion(data);
                    break;
                    case 'Asistencia Técnica':
                        verSolicitudAsistenciaTecnica(data);
                    break;
                    case 'Gestión Ambiental':
                        verSolicitudGestionAmbiental(data);
                    break;
                    case 'Gestión Empresarial':
                        verSolicitudGestionEmpresarial(data);
                    break;
                    case 'Planes de Negocio':
                        verSolicitudPlanesNegocio(data);
                    break;
                    default:
                    break;
                }
            }
        });
    }

    function editar(idSolicitud) {      
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/getSingle") ?>",
            data: {
                idSolicitud: idSolicitud
            },
            success: function(data) {

                switch(data[0].tipoSolicitud){
                    case 'Agro-mercado':
                        editarSolicitudAgromercado(data);
                    break;
                    case 'Capacitación':
                        editarSolicitudCapacitacion(data);
                    break;
                    case 'Asistencia Técnica':
                        editarSolicitudAsistenciaTecnica(data);
                    break;
                    case 'Gestión Ambiental':
                        editarSolicitudGestionAmbiental(data);
                    break;
                    case 'Gestión Empresarial':
                        editarSolicitudGestionEmpresarial(data);
                    break;
                    case 'Planes de Negocio':
                        editarSolicitudPlanesNegocio(data);
                    break;
                    default:
                    break;
                }
            }
        });
    }

    function solicitudAgromercado(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Agro-mercado");
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        $("#fecha").val("");
        $("#fecha").hide();
        $("#labelFecha").hide();
        $("#hora").val("");
        $("#hora").hide();
        $("#labelHora").hide();
        $("#nPersonas").val(0);
        $("#nPersonas").hide();
        $("#labelNPersonas").hide();
        $("#otroContacto").val("");
        $("#otroContacto").hide();
        $("#labelOtroContacto").hide();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de producción:");
        $("#cantidadProduccion").val(0);
        $("#cantidadProduccion").show();
        $("#labelCantidadProduccion").show();
        $("#tiempoProduccion").val(0);
        $("#tiempoProduccion").show();
        $("#labelTiempoProduccion").show();
        $("#comentario").val("");
        $("#mercaderia").show();
        $("#labelMercaderia").show();

        $("#tipoSolicitudAgregar").val(0);

        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");

        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function verSolicitudAgromercado(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Agro-mercado");
        $("#tipoSolicitud").val(1);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        $("#fecha").val("");
        $("#fecha").hide();
        $("#labelFecha").hide();
        $("#hora").val("");
        $("#hora").hide();
        $("#labelHora").hide();
        $("#nPersonas").val(0);
        $("#nPersonas").hide();
        $("#labelNPersonas").hide();
        $("#otroContacto").val("");
        $("#otroContacto").hide();
        $("#labelOtroContacto").hide();
        $("#idDepartamento").val(0);
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        $("#idMunicipio").val(0);
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de producción:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").show();
        $("#labelCantidadProduccion").show();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").show();
        $("#labelTiempoProduccion").show();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").show();
        $("#labelMercaderia").show();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudAgromercado(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Agro-mercado");
        $("#tipoSolicitud").val(1);
        $("#solicitante").val(data[0].nombre);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        $("#fecha").val("");
        $("#fecha").hide();
        $("#labelFecha").hide();
        $("#hora").val("");
        $("#hora").hide();
        $("#labelHora").hide();
        $("#nPersonas").val(0);
        $("#nPersonas").hide();
        $("#labelNPersonas").hide();
        $("#otroContacto").val("");
        $("#otroContacto").hide();
        $("#labelOtroContacto").hide();
        $("#idDepartamento").val(data[0].idDepartamento);
        $('#idMunicipio').html('');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });

        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de producción:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").show();
        $("#labelCantidadProduccion").show();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);

        $("#tiempoProduccion").show();
        $("#labelTiempoProduccion").show();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").show();
        $("#labelMercaderia").show();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");

        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        
        }, 500);        

    }
    
    
    function solicitudCapacitacion(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Capacitación");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#btnGuardar").show();
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#labelTema").html("Tema");
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        $("#fecha").val("");
        $("#fecha").show();
        $("#labelFecha").show();
        $("#hora").val("");
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(0);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val("");
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitación:");
        $("#cantidadProduccion").val("");
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val("");
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val("");
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();

        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function verSolicitudCapacitacion(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Capacitación");
        $("#tipoSolicitud").val(2);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").attr("disabled", 'disabled');
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#fecha").attr("disabled", 'disabled');
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#hora").attr("disabled", 'disabled');
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").attr("disabled", 'disabled');
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").attr("disabled", 'disabled');
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudCapacitacion(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Capacitación");
        $("#tipoSolicitud").val(2);
        $("#solicitante").val(data[0].nombre);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        $('#idMunicipio').html('');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });        
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);

        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }


    function solicitudAsistenciaTecnica(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Asistencia Técnica");
        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#btnGuardar").show();
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").show();
        $("#labelArea").show();
        $("#areaProductiva").val("");
        $("#areaProductiva").show();
        $("#labelAreaProductiva").show();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#labelTema").html("Problema especifico:");
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        $("#fecha").val("");
        $("#fecha").show();
        $("#labelFecha").show();
        $("#hora").val("");
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(0);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val("");
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de producción:");
        $("#cantidadProduccion").val("");
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val("");
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val("");
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();

        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function verSolicitudAsistenciaTecnica(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Asistencia Técnica");
        $("#tipoSolicitud").val(3);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        switch(data[0].area){
            case 'AGRICOLA':
                $("#area").val(1);
            break;
            case 'PECUARIA':
                $("#area").val(2);
            break;
            case 'OTRO':
                $("#area").val(3);
            break;
            default:
            break;

        }
        
        $("#area").show();
        $("#labelArea").show();
        $("#area").attr("disabled", 'disabled');
        $("#areaProductiva").val(data[0].cantidadProduccion);
        $("#areaProductiva").show();
        $("#areaProductiva").attr("disabled", 'disabled');
        $("#labelAreaProductiva").show();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").attr("disabled", 'disabled');
        $("#labelTema").html("Problema especifico:");
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#fecha").attr("disabled", 'disabled');
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#hora").attr("disabled", 'disabled');
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").attr("disabled", 'disabled');
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").attr("disabled", 'disabled');
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudAsistenciaTecnica(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Asistencia Técnica");
        $("#tipoSolicitud").val(3);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        switch(data[0].area){
            case 'AGRICOLA':
                $("#area").val(1);
            break;
            case 'PECUARIA':
                $("#area").val(2);
            break;
            case 'OTRO':
                $("#area").val(3);
            break;
            default:
            break;

        }
        
        $("#area").show();
        $("#labelArea").show();
        $("#areaProductiva").val(data[0].cantidadProduccion);
        $("#areaProductiva").show();
        $("#labelAreaProductiva").show();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#labelTema").html("Problema especifico:");
        $("#temaCapacitacion").show();
        $("#labelTema").show();
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").hide();
        $("#labelServicio").hide();
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            }); 
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);

        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }

    function solicitudGestionAmbiental(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Gestión Ambiental");
        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#btnGuardar").show();
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#labelTema").html("Problema especifico:");
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        $("#fecha").val("");
        $("#fecha").show();
        $("#labelFecha").show();
        $("#hora").val("");
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(0);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val("");
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar:");
        $("#cantidadProduccion").val("");
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val("");
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val("");
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();

        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function verSolicitudGestionAmbiental(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Gestión Ambiental");
        $("#tipoSolicitud").val(4);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").attr("disabled", 'disabled');
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#servicioSolicitado").attr("disabled", 'disabled');
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#fecha").attr("disabled", 'disabled');
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#hora").attr("disabled", 'disabled');
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").attr("disabled", 'disabled');
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").attr("disabled", 'disabled');
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudGestionAmbiental(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Gestión Ambiental");
        $("#tipoSolicitud").val(4);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);

        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }

    function solicitudGestionEmpresarial(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Gestion Empresarial");
        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#btnGuardar").show();
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#labelTema").html("Problema especifico:");
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        $("#fecha").val("");
        $("#fecha").show();
        $("#labelFecha").show();
        $("#hora").val("");
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(0);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val("");
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar:");
        $("#cantidadProduccion").val("");
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val("");
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val("");
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();

        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        
        }, 500);        

    }
    function verSolicitudGestionEmpresarial(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Gestión Empresarial");
        $("#tipoSolicitud").val(5);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").attr("disabled", 'disabled');
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#servicioSolicitado").attr("disabled", 'disabled');
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#fecha").attr("disabled", 'disabled');
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#hora").attr("disabled", 'disabled');
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").attr("disabled", 'disabled');
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").attr("disabled", 'disabled');
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudGestionEmpresarial(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Gestión Empresarial");
        $("#tipoSolicitud").val(5);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);

        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }

    function solicitudPlanesNegocio(tipoSolicitud) {  
        setTimeout(() => {

        $("#SolicitudModalLabel").html("Solicitud Planes de Negocio");
        $("#btnGuardar").show();
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#tipoSolicitud").val(tipoSolicitud);
        $("#area").val(0);
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val("");
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#labelTema").html("Problema especifico:");
        $("#servicioSolicitado").val("");
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        $("#fecha").val("");
        $("#fecha").show();
        $("#labelFecha").show();
        $("#hora").val("");
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(0);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val("");
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#direccionEvento").val("");
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar:");
        $("#cantidadProduccion").val("");
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val("");
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val("");
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();

        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        
        }, 500);        

    }
    function verSolicitudPlanesNegocio(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Planes de Negocio");
        $("#tipoSolicitud").val(6);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").show();
        $("#labelObservacionCA").show();
        $("#observacionCA").attr("disabled", 'disabled');
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").attr("disabled", 'disabled');
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#servicioSolicitado").attr("disabled", 'disabled');
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#fecha").attr("disabled", 'disabled');
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#hora").attr("disabled", 'disabled');
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").attr("disabled", 'disabled');
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").attr("disabled", 'disabled');
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(0);
        $("#idMunicipio").val(0);
        $("#idDepartamento").val(data[0].idDepartamento);
        $("#idDepartamento").attr("disabled", 'disabled');
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#idMunicipio").attr("disabled", 'disabled');
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").attr("disabled", 'disabled');
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").attr("disabled", 'disabled');
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").attr("disabled", 'disabled');

        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#comentario").attr("disabled", 'disabled');
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").hide();
        $("#tipoSolicitudAgregar").val(0);
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }
    function editarSolicitudPlanesNegocio(data) {  
        setTimeout(() => {
        $("#SolicitudModalLabel").html("Solicitud Planes de Negocio");
        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#tipoSolicitud").val(6);
        $("#solicitante").val(data[0].nombre);
        $("#mercaderia").val(data[0].mercaderia);
        $("#idSolicitud").val(data[0].idSolicitud);
        $("#observacionCA").val(data[0].observacionCA);
        $("#observacionCA").hide();
        $("#labelObservacionCA").hide();
        $("#area").val();
        $("#area").hide();
        $("#labelArea").hide();
        $("#areaProductiva").val("");
        $("#areaProductiva").hide();
        $("#labelAreaProductiva").hide();
        $("#temaCapacitacion").val(data[0].temaCapacitacion);
        $("#temaCapacitacion").hide();
        $("#labelTema").hide();
        $("#servicioSolicitado").val(data[0].servicioSolicitado);
        $("#servicioSolicitado").show();
        $("#labelServicio").show();
        $("#labelServicio").html("Servicio solicitado:");
        fecha = data[0].fechaHoraEvento.substr(0,10);
        $("#fecha").val(fecha);
        $("#fecha").show();
        $("#labelFecha").show();
        hora = data[0].fechaHoraEvento.substr(11,5);
        $("#hora").val(hora);
        $("#hora").show();
        $("#labelHora").show();
        $("#nPersonas").val(data[0].nPersonas);
        $("#nPersonas").show();
        $("#labelNPersonas").show();
        $("#otroContacto").val(data[0].otroContacto);
        $("#otroContacto").show();
        $("#labelOtroContacto").show();
        $("#idDepartamento").val(data[0].idDepartamento);
        municipio = data[0].idMunicipioEvento;
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Solicitudes/Municipios") ?>",
                data: {
                    idDepartamento: data[0].idDepartamento
                },
                success: function(data) {
                    $('#idMunicipio').html('');
                    $("<option />").val(0)
                            .text("Seleccionar")
                            .appendTo($('#idMunicipio'));
                    for (var i = 0; i < data.length; i++) {
                        if(municipio == data[i].idMunicipio){
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).attr("selected", true).appendTo($('#idMunicipio'));
                        }else{
                            $("<option />").val(data[i].idMunicipio).text(data[i].nomMunicipio).appendTo($('#idMunicipio'));
                        }
                    }
                },
            });
        $("#direccionEvento").val(data[0].direccionEvento);
        $("#direccionEvento").show();
        $("#labelLugar").show();
        $("#labelLugar").html("Lugar de capacitacion:");
        $("#cantidadProduccion").val(data[0].cantidadProduccion);
        $("#cantidadProduccion").hide();
        $("#labelCantidadProduccion").hide();
        $("#tiempoProduccion").val(data[0].tiempoProduccion);
        $("#tiempoProduccion").hide();
        $("#labelTiempoProduccion").hide();
        $("#comentario").val(data[0].comentario);
        $("#mercaderia").hide();
        $("#labelMercaderia").hide();
        $("#btnGuardar").show();
        $("#tipoSolicitudAgregar").val(0);

        $("#area").removeAttr("disabled");
        $("#areaProductiva").removeAttr("disabled");
        $("#servicioSolicitado").removeAttr("disabled");
        $("#tiempoProduccion").removeAttr("disabled");
        $("#comentario").removeAttr("disabled");
        $("#cantidadProduccion").removeAttr("disabled");
        $("#direccionEvento").removeAttr("disabled");
        $("#idMunicipio").removeAttr("disabled");
        $("#idDepartamento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#hora").removeAttr("disabled");
        $("#temaCapacitacion").removeAttr("disabled");
        $("#nPersonas").removeAttr("disabled");
        $("#otroContacto").removeAttr("disabled");
        $("#SolicitudModal").modal("show");
        
        }, 500);        

    }

    function salir() {
        $("#SolicitudModal").modal("toggle");

    }

    function aprobarSolicitud(idSolicitud) {  
        setTimeout(() => {

        $("#ObservacionModalLabel").html("Aprobación de Solicitud");
        $("#observacionCA2").val("");
        $("#idSolicitudO").val(idSolicitud);
        $("#valor").val(1);
        $("#btnGuardarObservacion").html("Aprobar");
        $("#ObservacionModal").modal("show");
        
        }, 500);        

    }
    function denegarSolicitud(idSolicitud) {  
        setTimeout(() => {

        $("#ObservacionModalLabel").html("Denegación de Solicitud");
        $("#observacionCA2").val("");
        $("#idSolicitudO").val(idSolicitud);
        $("#valor").val(2);
        $("#btnGuardarObservacion").html("Denegar");
        $("#ObservacionModal").modal("show");
        
        }, 500);        

    }
    function guardarObservacion() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Solicitudes/guardarObservacion") ?>",
            data: $("#frmObservacion").serialize(),
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
                    $("#ObservacionModal").modal("toggle");
                    setTimeout(() => {
                        location.href = "<?= site_url("Solicitudes/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }
    function salirObservacion() {
        $("#ObservacionModal").modal("toggle");

    }

</script>