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
            <li class="breadcrumb-item active" aria-current="page">Noticias</li>
        </ol>
    </nav>

    <div class="card shadow mb-4 col-lg-12 col-sm-12">
        <div class="card-header py-3 d-flex">
            <div>
                <h4 class="m-0 font-weight-bold">Noticias</h4>
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
                    <button onclick="AgregarNoticia()" class="btn btn-primary"><i class="fas fa-plus"></i> <span>Agregar</span></button>
                </div>
            </div>

            <br>

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tableNoticias" name="tableNoticias">
                    <thead>
                        <tr>
                            <th scope="col"><span class="">Titulo</span></th>
                            <th scope="col"><span class="d-none d-lg-block ">Descripción</span></th>
                            <th scope="col"><span class="">Principal</span></th>
                            <th scope="col"><span class=" col-lg-3 col-xl-2 "></span></th>
                        </tr>
                    </thead>
            
                    <tbody>
                        <?php
                        $cont = 0;
                        $pag = 1;
                        $pagValor = $valorPag;
                        foreach ($noticias as $d){ 
                            $cont = $cont +1; 
                            if($pag == $pagValor){
                        ?>
                            <tr>
                                <td ><span class=""><?= $d["titulo"] ?></span></td>
                                <td><span class="d-none d-lg-block "><?= $d["descripcion"] ?></span></td>
                                <td ><span class=""><?= $d["principal"] ?></span></td>
                                <td class="text-end col-lg-3 col-xl-2" style="width:150px">
                                    <button class='btn btn-secondary btn-sm' onclick='verDetalles(<?=$d["idNoticia"]?>)' title='Detalles'><i class='fas fa-list'></i></button>
                                    <button class='btn btn-primary btn-sm'  onclick='editar(<?=$d["idNoticia"]?>)' title='Editar'><i class='fas fa-edit'></i></button>
                                    <button onclick='ConfirmDel(<?=$d["idNoticia"]?>,"<?=$d["titulo"]?>","<?=$d["imagen"]?>")' class='btn btn-warning btn-sm' title='Eliminar'><i class='fas fa-window-close'></i></button>
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
                        <span>Mostrando 
                            <?php 
                            if($pagValor>1){
                                echo ($pagValor*10)-9;
                            } else if($cont>0){
                                echo 1;
                            } else{
                                echo 0;
                            }
                            ?> 
                            al 
                            <?php 
                            if(($pagValor) * 10 > $cont){ 
                                echo $cont;
                            } else{
                                echo ($pagValor) * 10;
                            }
                            ?> 
                            de <?= $cont ?> registros
                        </span>
                    </div>
                    <ul class="pagination">
                        <?php if ($pagValor > 1){ ?>
                        <form  id="frmEnviar" class="text-end" method="post" action="Consultar">
                            <input type="hidden" id="buscar" name="buscar" value="<?= isset($buscar)  ? $buscar : "" ?>">
                            <input type="hidden" id="valor" name="valor" value='<?=$pagValor-2 ?>'>
                            <li ><input class="page-item page-link" value="Anterior"  type="submit"></li>  
                        </form>
                        <?php } ?>
                        <li class="page-item"><label class="form-control" for="" id="labelPagina" name="labelPagina">pág <?=$pagValor ?> de <?=$pag ?></label></li>
                        <?php if ($pagValor < $pag){ ?>
                        <form  id="frmEnviar" class="text-end" method="post" action="Consultar">
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

    <div class="modal fade" id="AgregarNoticiaModal" tabindex="-1" role="dialog" aria-labelledby="AgregarNoticiaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AgregarNoticiaModalLabel"></h5>
                </div>
                <div class="modal-body">
                    <form id="frmAgregarNoticia" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idNoticia" id="idNoticia" value="<?= isset($Perfil["idNoticia"]) ? $Perfil["idNoticia"] : 0?>">
                        <div class="form-group col">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="titulo">Titulo:</label>
                                    <input class="form-control mb-2" type="" placeholder="" id="titulo" name="titulo">
                                </div>
                            </div>               
                            
                            <div class="col-sm-12 mb-sm-0 mb-2">
                                <label for="principal">Principal:</label>
                                <select class="form-select mb-2" name="principal" id="principal">
                                    <option value="2">Seleccionar</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                            
                            <div class="form-group row ">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea class="form-control mb-2" rows="5" placeholder="" id="descripcion" name="descripcion"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row ">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <label for="imagen">Imagen:</label> 
                                    <input type="hidden" id="nomImagen" name="nomImagen"> 
                                    <input type="hidden" id="nomImagenVieja" name="nomImagenVieja"> 
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="frmSubirImagen" action="<?= site_url("Noticias/SubirArchivo")?>" method="POST" enctype="multipart/form-data">
                        <input class="form-control mb-2" id="photoNoti" name="photoNoti" type="file" placeholder="Foto de noticia">
                    </form>
                    <center><img class="img-fluid" id="imgNoti" name="imgNoti" alt="gallery" height="250px" width="250px"></center>
                </div>
                <div class="modal-footer">
                    <button onclick="guardarNoticia()" class="btn btn-primary" id="btnGuardar" type="button">Guardar</button>
                    <button onclick="salirNoticia()" class="btn btn-danger" type="button" >Salir</button>
                </div>
            </div>                
        </div>
    </div>
</div>

<script>

    var valor = 0;
    $(function() {
        $("#photoNoti").on("change", function() {
            $("#nomImagen").val(document.getElementById('photoNoti').files[0].name);
        })
    })

    function guardarNoticia() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Noticias/guardarNoticia") ?>",
            data: $("#frmAgregarNoticia").serialize(),
            success: function(data) {
                if(data.Error){
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
                    $("#frmSubirImagen").submit();
                    $("#AgregarNoticiaModal").modal("toggle");
                    setTimeout(() => {
                        location.href = "<?= site_url("Noticias/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function ConfirmDel(idNoticia, titulo, imagen) {
        setTimeout(() => {    
            Swal.fire({
                title: '¿Desea eliminar noticia "'+ titulo +'" ?',
                icon: 'warning',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminar'
            }).then((result) => {
                if (result.isConfirmed){
                    eliminar(idNoticia, imagen);
                }
            })
        }, 500);  
    }

    function eliminar(idNoticia, imagen) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Noticias/eliminar") ?>",
            data: {
                idNoticia: idNoticia,
                imagen: imagen
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
                        location.href = "<?= site_url("Noticias/consultar") ?>"
                    }, 1500);
                }
            },
            complete: function() {}
        });
    }

    function AgregarNoticia() {
        setTimeout(() => {
            $("#AgregarNoticiaModalLabel").html("Agregar Noticia");
            $("#titulo").removeAttr("disabled");
            $("#descripcion").removeAttr("disabled");
            $("#principal").removeAttr("disabled");
            $("#photoNoti").removeAttr("disabled");
            $("#btnGuardar").show();
            $("#titulo").val("");
            $("#descripcion").val("");
            $("#principal").val(2);
            $("#imgNoti").attr("src", '<?= base_url("/assets/img/iconimg.png")?>');
            $("#idNoticia").val("0");
            $("#AgregarNoticiaModal").modal("show");
        }, 500);
    }

    function verDetalles(idNoticia) {  
       $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Noticias/verDetalles") ?>",
            data: {
                idNoticia: idNoticia
            },
            success: function(data) {
                $("#AgregarNoticiaModalLabel").html("Detalles noticia");
                $("#titulo").val(data[0].titulo);
                $("#descripcion").val(data[0].descripcion);
                $("#principal").val(data[0].principal);
                $("#imgNoti").attr("src", '<?= base_url("/assets/fotosNoticias")?>' + '/' + data[0].imagen);
                $("#idNoticia").val(data[0].idNoticia);
                $("#titulo").attr("disabled", 'disabled');
                $("#descripcion").attr("disabled", 'disabled');
                $("#principal").attr("disabled", 'disabled');
                $("#photoNoti").attr("disabled", 'disabled');
                $("#btnGuardar").hide();
                $("#AgregarNoticiaModal").modal("show");
            },
        }); 
    }

    function editar(idNoticia){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Noticias/verDetalles") ?>",
            data: {
                idNoticia: idNoticia
            },
            success: function(data) {
                $("#AgregarNoticiaModalLabel").html("Editar Noticia");
                $("#titulo").removeAttr("disabled");
                $("#descripcion").removeAttr("disabled");
                $("#principal").removeAttr("disabled");
                $("#photoNoti").removeAttr("disabled");
                $("#btnGuardar").show();

                $("#titulo").val(data[0].titulo);
                $("#descripcion").val(data[0].descripcion);
                $("#principal").val(data[0].principal);
                $("#idNoticia").val(data[0].idNoticia);
                $("#imgNoti").attr("src", '<?= base_url("/assets/fotosNoticias")?>' + '/' + data[0].imagen);
                $("#nomImagenVieja").val(data[0].imagen);

                $("#AgregarNoticiaModal").modal("show");
            },
        }); 
    }

    function salirNoticia() {
        $("#AgregarNoticiaModal").modal("toggle");
    }
</script>