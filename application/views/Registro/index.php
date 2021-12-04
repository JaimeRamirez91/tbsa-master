<div class="container-fluid" id="PadreContenido"> 

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= site_url() ?>">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Registrarse</li>
    </ol>
</nav>

<div class="card o-hidden border-0 shadow-lg my-5">
    
    <div class="card-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Registrarse</h1>
                    </div>
                    
                    <form id="frmame" class="user">
                        <input type="hidden" name="idUsuario" id="idUsuario"  value="<?= isset($Usuario["idUsuario"]) ? $Usuario["idUsuario"] : 0?>">
                        <input type="hidden" name="estado" id="estado"  value="BLOQUEADO">
                        <div class="form-group row  justify-content-center">
                            <div class="col col-12 col-sm-12 col-lg-7 col-xl-5">
                                <div class="row col-12">    
                                    <div class="mb-3 mb-sm-0">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control mb-2" name="nombre" id="nombre" value="<?= isset($Usuario["nombre"])  ? $Usuario["nombre"] : "" ?>">
                                    </div>
                                    <div class=" mb-3 mb-sm-0">
                                        <label for="correo">Correo</label>
                                        <input type="email" class="form-control mb-2" name="correo" id="correo" value="<?= isset($Usuario["correo"])  ? $Usuario["correo"] : "" ?>">
                                    </div>
                                    <div class=" mb-3 mb-sm-0">
                                        <label for="mercaderia">Productos que ofrece</label>
                                        <input class="form-control mb-2" name="mercaderia" id="mercaderia" value="<?= isset($Usuario["mercaderia"])  ? $Usuario["mercaderia"] : "" ?>">
                                    </div>
                            <?php
                                    if(!$editar){ ?>
                                        <div class="mb-3 mb-sm-0">
                                            <label for="password">Contraseña</label>
                                            <input type="password" class="form-control mb-2" name="password" id="password" >
                                        </div>
                                        <div class="mb-3 mb-sm-0">
                                            <label for="password2">Confirmar Contraseña</label>
                                            <input type="password" class="form-control mb-2" name="password2" id="password2" >
                                        </div>
                            <?php    }    
                            ?>
                                </div>
                            </div>
                            <div class="col col-xl-5">
                                <div class="row col-12">
                                    <div class="col col-12 col-sm-6">
                                        <div class="mb-3 mb-sm-0">
                                            <label for="telefono">Teléfono</label>
                                            <input class="form-control mb-2" onkeypress="return valideKey(event);" maxlength="9" name="telefono" id="telefono" placeholder="" mask="0000-0000" value="<?= isset($Usuario["telefono"])  ? $Usuario["telefono"] : "" ?>">
                                        </div>
                                        <div class="mb-3 mb-sm-0">
                                            <label for="dui">DUI</label>
                                            <input class="form-control mb-2" maxlength="10" name="dui" id="dui" placeholder="" value="<?= isset($Usuario["dui"])  ? $Usuario["dui"] : "" ?>">
                                        </div>
                                        <div class=" mb-3 mb-sm-0">
                                            <label for="nit">NIT</label>
                                            <input class="form-control mb-2" maxlength="17" name="nit" id="nit" placeholder="" value="<?= isset($Usuario["nit"])  ? $Usuario["nit"] : "" ?>">
                                        </div>
                                        
                                    </div>
                                    <div class="col col-12 col-sm-6">
                                        
                                        <div class=" mb-3 mb-sm-0">
                                            <label for="idPerfil">Perfil</label>
                                            <select class="form-select mb-2" name="idPerfil" id="idPerfil">
                                                <option value="0">Seleccionar</option>
                                                <?php
                                                if ($editar) {                                       
                                                    foreach ($perfiles as $c) {
                                                        if($Usuario["idPerfil"] == $c["idPerfil"]){?>
                                                        <option value="<?= $c["idPerfil"]?>" selected>                                            
                                                            <?= $c["nomPerfil"]?></option>
                                                        <?php
                                                        } else {?>
                                                            <option value="<?= $c["idPerfil"]?>">                                            
                                                            <?= $c["nomPerfil"]?></option>
                                                        <?php
                                                        }
                                                    }
                                                } else {
                                                    foreach ($perfiles as $c) {
                                                        ?>
                                                            <option value="<?= $c["idPerfil"]?>">
                                                            <?= $c["nomPerfil"]?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class=" mb-3 mb-sm-0">
                                            <label for="referencia">Referecia</label>
                                            <input class="form-control mb-2" name="referencia" id="referencia" value="<?= isset($Usuario["referencia"])  ? $Usuario["referencia"] : "" ?>">
                                        </div>
                                         
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="row">
                                            <div class="col col-12 col-sm-6">
                                                <div class=" mb-3 mb-sm-0">
                                                    <label for="idDepartamento">Departamento</label>
                                                    <select class="form-select mb-2" name="idDepartamento" id="idDepartamento">
                                                        <option>Seleccionar</option>
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
                                            </div>
                                            <div class="col col-12 col-sm-6">
                                                <div class=" mb-3 mb-sm-0">
                                                        <label for="idMunicipio">Municipio</label>
                                                        <select class="form-select mb-2" name="idMunicipio" id="idMunicipio">
                                                            <option>Seleccionar</option>
                                                            <?php
                                                            if ($editar) {                                       
                                                                foreach ($municipiosFiltrados as $c) {
                                                                if($municipioSelec["idMunicipio"] == $c["idMunicipio"]){?>
                                                                <option value="<?= $c["idMunicipio"]?>" selected>                                            
                                                                    <?= $c["nomMunicipio"]?></option>
                                                                <?php
                                                                } else {?>
                                                                    <option value="<?= $c["idMunicipio"]?>">                                            
                                                                    <?= $c["nomMunicipio"]?></option>
                                                                <?php
                                                                }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 mb-sm-0">
                                                <label for="direccion">Dirección</label>
                                                <input class="form-control mb-2" name="direccion" id="direccion" value="<?= isset($Usuario["direccion"])  ? $Usuario["direccion"] : "" ?>">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>  
                        
                        <br>
                        <div class="col text-center">
                            <button type="button" onclick="btnGuardar()" class="col-lg-3 btn btn-primary btn-user">
                            <strong>Guardar</strong>
                            </button>
                            <a class='col-lg-1 btn btn-danger'  href='<?php echo site_url() ?>' >Salir</a>

                        </div>
                        <hr>
                    </form>
                </div>
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
                url: "<?php echo site_url("Registro/Municipios") ?>",
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

        $("#telefono").keyup( function(e) {
            if((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8) {
            
                if($("#telefono").val().length > tam){
                    if ($("#telefono").val().length == 4){ 
                        texto = $("#telefono").val();
                        $("#telefono").val(texto + "-");
                    }
                }
                else{
                    if ($("#telefono").val().length == 4){ 
                        texto = $("#telefono").val();
                        $("#telefono").val(texto.substring(0, texto.length - 1));
                    }
                }
                tam = $("#telefono").val().length;
            } else {
                texto = $("#telefono").val();
                $("#telefono").val(texto.substring(0, texto.length - 1));
            }
            

        })

        tam3 = 0;
        $("#dui").keyup( function(e) {
            if((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8) {

                if($("#dui").val().length > tam3){
                    if ($("#dui").val().length == 8){ 
                        texto = $("#dui").val();
                        $("#dui").val(texto + "-");
                    }
                }
                else{
                    if ($("#dui").val().length == 8){ 
                        texto = $("#dui").val();
                        $("#dui").val(texto.substring(0, texto.length - 1));
                    }
                }
                tam3 = $("#dui").val().length;
            } else {
                texto = $("#dui").val();
                $("#dui").val(texto.substring(0, texto.length - 1));
            }
        })

        tam1=0;
        $("#nit").keyup( function(e) {
            if((e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8) {
                if($("#nit").val().length > tam1){
                    if ($("#nit").val().length == 4 || $("#nit").val().length == 11 || $("#nit").val().length == 15){ 
                        texto = $("#nit").val();
                        $("#nit").val(texto + "-");
                    }
                }
                else{
                    if ($("#nit").val().length == 4 || $("#nit").val().length == 11 || $("#nit").val().length == 15){ 
                        texto = $("#nit").val();
                        $("#nit").val(texto.substring(0, texto.length - 1));
                    }
                }
                tam1= $("#nit").val().length;
            } else {
                texto = $("#nit").val();
                $("#nit").val(texto.substring(0, texto.length - 1));
            }
        })



    })



    function btnGuardar() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url("Registro/Guardar") ?>",
            data: $("#frmame").serialize(),
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
                            location.href = "<?= site_url() ?>/"   
                    }, 1500);                                          
                }
            },
            complete: function() {}
        });
    }    
</script>