            <div class="bg-img">
                <img  src="<?= base_url("/assets/img/agromercado1.jpg")?>" alt="Bootstrap">
            </div>
            <h1 class="bg-precios py-2 mb-3" >Precios de los productos del agromercado USO</h1>

            <div class="rowPrincipal">
                <?php if ($this->session->userdata("acceso10")!=null){ ?>
                    <form class="mb-4" action="<?= site_url("PreciosProductos/SubirArchivo")?>" method="POST" enctype="multipart/form-data">                                        
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <input class="form-control" id="archivoProductos" name="archivoProductos" type="file" placeholder="Precios de productos">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btnRegistrar" id="btnActualizarPrecios">Actualizar precios</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>

                <?php  
                    if(file_exists('assets/documents/productPrices/precios_de_productos.pdf')){  
                ?>
                        <embed class="col-12" id="VisorPDF" src="<?= base_url("/assets/documents/productPrices/precios_de_productos.pdf")?>" type="application/pdf" height="825px">

                <?php  
                    } else{
                ?>                
                        <div class="row featurette my-5">
                            <div class="col-md-7 order-md-2 my-auto">
                                <h2 class="featurette-heading my-auto"><center>Subir PDF de precios de productos</center></h2>
                            </div>
                            <div class="col-md-5 order-md-1  mx-auto my-auto">
                                <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto ps-5" width="500" height="500" 
                                src="<?= base_url("/assets/img/upload.png")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

                            </div>
                        </div>
                <?php 
                    }
                ?>
            </div>

<script>
 

</script>