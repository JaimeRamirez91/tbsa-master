<div class="mb-5">
   <h1 class="TemaLA pt-5"> Galería del Centro de Agronegocios</h1>
<hr  class="sidebar-divider LinePN">

<div class="rowPrincipal">
   <?php if ($this->session->userdata("acceso11")!=null){ ?>
      <form class="mb-4" action="<?= site_url("Galeria/SubirArchivo")?>" method="POST" enctype="multipart/form-data">                                        
         <div class="row align-items-center">
            <div class="col-md-8">
               <input class="form-control" id="fotoVideo" name="fotoVideo" type="file" placeholder="Multimedia">
            </div>
            <div class="col-md-4">
               <button class="btn btn-primary btnAGaleria" id="btnActualizarPrecios"><i class="fas fa-plus"></i> Agregar</button>
            </div>
         </div>
      </form>
   <?php } ?>
</div>

<section class="gallery min-vh-100">
   <div class="container-lg">
      <?php          
      $tipoVideo = array('avi', 'wmv', 'asf', 'flv', 'rm', 'rmvb', 'mp4', 'mkv', 'mks', '3gpp');      
      $ruta = 'assets/galeria/';

      // Se comprueba que realmente sea la ruta de un directorio
      if(is_dir($ruta)){
         // Abre un gestor de directorios para la ruta indicada
         $gestor = opendir($ruta);

         $totalGaleria = count(glob($ruta . "*." . "*", GLOB_BRACE));

         if($totalGaleria > 0){
      ?>   
            <div class="row gy-4 row-cols-1 row-cols-sm-2 row-cols-md-3"> 
      <?php
            // Recorre todos los archivos del directorio
            while(($archivo = readdir($gestor)) !== false){
               // Solo buscamos archivos sin entrar en subdirectorios
               if(is_file($ruta . "/" . $archivo)){ 
                  $arreglo = explode(".", $archivo);
                  $extension = strtolower(end($arreglo));

                  if(in_array($extension, $tipoVideo)){
      ?>                       
                     <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                        <video id="videoView" src="<?= base_url($ruta . $archivo)?>" class="gallery-item imgG heigthGalery" 
                          preload="none" loop="false" controls></video>
                     </div>    
      <?php       } else { ?> 
                  <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                     <img src="<?= base_url($ruta . $archivo)?>" class="gallery-item imgG heigthGalery img-thumbnail" alt="gallery">
                  </div>     
      <?php      
                  }
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
                        <h2 class="featurette-heading my-auto"><center>Subir fotos o videos para visualizarlos</h2>
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
<div class="modal fade" id="gallery-modal-img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <?php if ($this->session->userdata("acceso11")!=null){ ?>
               <button id="btnEliminarImg" type="button" style="border: 0 !important;" class="deleteButton" data-bs-dismiss="modal" aria-label="Delete">
                  <i class="far fa-trash-alt" style="width: 100%; height: 100%;"></i></button>
            <?php } ?>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <img class="modal-img" alt="modal img">
         </div>
      </div>
   </div>
</div>

<!-- Modal Videos-->
<div class="modal fade" id="gallery-modal-video" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <?php if ($this->session->userdata("acceso11")!=null){ ?>
               <button id="btnEliminarVideo" type="button" style="border: 0 !important;" class="deleteButton" data-bs-dismiss="modal" aria-label="Delete">
               <i class="far fa-trash-alt" style="width: 100%; height: 100%;"></i></button>
            <?php } ?>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <video id="videoModal" class="modal-img"
               autoplay="false" loop="false" controls></video>
         </div>
      </div>
   </div>
</div>

<script>
   $(function() {
      $("#videoView").attr("autoplay", 'false');
   })

   document.addEventListener("click",function (e){
      if(e.target.classList.contains("gallery-item")){
         let src = e.target.getAttribute("src");
         let tVideo = ['avi', 'wmv', 'asf', 'flv', 'rm', 'rmvb', 'mp4', 'mkv', 'mks', '3gpp'];  
         let nom = src;
         let ultimaPleca = nom.lastIndexOf("/") + 1;
         let ultimoPunto = nom.lastIndexOf(".") + 1;
         let nomMulti = nom.substr(ultimaPleca);
         let exten = nom.substr(ultimoPunto);
         
         let videoEncontrado = false;

         for(let i = 0; i < tVideo.length; i++){
            if(tVideo[i] == exten){
               videoEncontrado = true;
            }
         }

         if(videoEncontrado){
            $("#btnEliminarVideo").attr("onclick", "ConfirmDel('" + nomMulti + "')");
            document.querySelector("#videoModal").src = src;
            const myModal = new bootstrap.Modal(document.getElementById('gallery-modal-video'));
            myModal.show();
         } else{
            $("#btnEliminarImg").attr("onclick", "ConfirmDel('" + nomMulti + "')");
            document.querySelector(".modal-img").src = src;
            const myModal = new bootstrap.Modal(document.getElementById('gallery-modal-img'));
            myModal.show();
         }
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
                  eliminarMultimedia(nombre);
               }
         })
      }, 500);  
    }
    
    function eliminarMultimedia(nombre) {
      $.ajax({
         type: "POST",
         dataType: "json",
         url: "<?php echo site_url("Galeria/Eliminar") ?>",
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
                     location.href = "<?= site_url("Galeria/IrPrincipal") ?>"
                  }, 1500);
               }
         },
         complete: function() {}
      });
    }
</script>