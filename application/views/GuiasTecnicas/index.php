<div class="mb-5">
   <h1 class="TemaLA pt-5">Guías técnicas</h1>
<hr  class="sidebar-divider LinePN">

<?php if ($this->session->userdata("acceso12")!=null){ ?>
   <div class="rowPrincipal">
      <form class="mb-4" action="<?= site_url("GuiasTecnicas/SubirArchivo")?>" method="POST" enctype="multipart/form-data">                                        
         <div class="row align-items-center">
            <div class="col-md-8">
               <input class="form-control" id="archivosPDF" name="archivosPDF" type="file" placeholder="Multimedia">
            </div>
               <div class="col-md-4">
                  <button type="submit" class="btn btn-primary btnAGaleria" id="btnActualizarPrecios"><i class="fas fa-plus"></i> Agregar</button>
               </div>
         </div>
      </form>
   </div>
<?php } ?>

<section class="gallery min-vh-100">
   <div class="container-lg">
      <?php          
      $tipoDocumento = 'pdf';      
      $ruta = 'assets/documents/technicalGuides/';

      // Se comprueba que realmente sea la ruta de un directorio
      if(is_dir($ruta)){
         // Abre un gestor de directorios para la ruta indicada
         $gestor = opendir($ruta);

         $totalDocumentos = count(glob($ruta . "*." . "pdf", GLOB_BRACE));

         if($totalDocumentos > 0){
      ?>   
         <div class="row gy-4 row-cols-1 row-cols-md-3"> 
      <?php
            // Recorre todos los archivos del directorio
            while(($archivo = readdir($gestor)) !== false){
               // Solo buscamos archivos sin entrar en subdirectorios
               if(is_file($ruta . "/" . $archivo)){ 
                  $arreglo = explode(".", $archivo);
                  $extension = strtolower(end($arreglo));

                  if($extension == $tipoDocumento){
   ?>                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12">
                        <!-- embed -> para mostrar objetos multimedia (incluyendo PDF) -->
                        <embed class="col-12" id="VisorPDFDoc" src="<?= base_url($ruta . $archivo)?>" type="application/pdf" height="400px">
                        <p class="col-12"><?= $archivo ?></p>
                        <?php if ($this->session->userdata("acceso12")!=null){ ?>
                           <button onclick="ConfirmDel('<?= $archivo ?>')" class="btn btn-primary col-4">Eliminar</button>
                        <?php } ?>
                     </div>   
      <?php       } 
               }            
            } 
      ?>                      
         </div>
      <?php
         } else{
      ?>   
            <div class="rowPrincipal">
               <div class="row featurette my-5">
                  <div class="col-md-7 order-md-2 my-auto">
                     <h2 class="featurette-heading my-auto"><center>Subir documentos PDF para visualizarlos</h2>
                  </div>
                  <div class="col-md-5 order-md-1  mx-auto my-auto">
                     <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto ps-5" style="width:500; height:500; box-shadow: none; cursor: default;" 
                     src="<?= base_url("/assets/img/upload.png")?>"></img>
                  </div>
               </div>
            </div>
      <?php 
         }
         // Cierra el gestor de directorios
         closedir($gestor);
      }      
      ?>
   </div>
</section>

<!-- Modal imagenes-->
<div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button id="btnEliminarDoc" type="button" style="border: 0 !important;" class="deleteButton" data-bs-dismiss="modal" aria-label="Delete">
               <i class="far fa-trash-alt" style="width: 100%; height: 100%;"></i></button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <embed class="col-12" id="VisorPDFGuias" type="application/pdf" height="490px">
         </div>
      </div>
   </div>
</div>

<script>
   document.addEventListener("click",function (e){
      if(e.target.classList.contains("gallery-item")){
         let src = $("#VisorPDFDoc").attr("src");
         let nom = src;
         let ultimaPleca = nom.lastIndexOf("/") + 1;
         let nomDoc = nom.substr(ultimaPleca);
                  
         $("#btnEliminarDoc").attr("onclick", "ConfirmDel('" + nomDoc + "')");
         document.querySelector("#VisorPDFGuias").src = src;
         const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
         myModal.show();
      }      
   })
   
   function ConfirmDel(nombre) {
      setTimeout(() => {    
         Swal.fire({
               title: '¿Desea eliminar "' + nombre + '" ?',
               icon: 'warning',
               text: '',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Si, deseo eliminar'
         }).then((result) => {
               if (result.isConfirmed) {
                  eliminarDocumento(nombre);
               }
         })
      }, 500);  
    }
    
    function eliminarDocumento(nombre) {
      $.ajax({
         type: "POST",
         dataType: "json",
         url: "<?php echo site_url("GuiasTecnicas/Eliminar") ?>",
         data: {
            nombre: nombre
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
                     location.href = "<?= site_url("GuiasTecnicas/IrPrincipal") ?>"
                  }, 1500);
               }
         },
         complete: function() {}
      });
    }
</script>





