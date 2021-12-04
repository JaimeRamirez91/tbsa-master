<script src="https://unpkg.com/aos@next/dist/aos.js"></script>  
<script>
  AOS.init();
</script>

<!-- carousel -->
<div id="slideNews" class="carousel slide" data-bs-ride="carousel"> <!-- abierto -->

    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php 
        $countNotiPrinci = 0;

        foreach ($noticias as $d) { 
            if($d["principal"] == "SI"){    
        ?>
                <button type="button" data-bs-target="#slideNews" data-bs-slide-to="<?= $countNotiPrinci ?>" class="<?php if($countNotiPrinci == 0){ echo 'active'; }?>" aria-current="true" aria-label="Noticia <?= $countNotiPrinci ?>"></button> 
        <?php  
                $countNotiPrinci++;
            } 
        } 
        ?>
    </div>

    <!-- The slideshow -->
    <div class="carousel-inner"> <!-- abierto -->
        <?php 
        $countNotiPrinci = 0;

        foreach ($noticias as $d) { 
            if($d["principal"] == "SI"){
        ?>
                <div class="carousel-item <?php if($countNotiPrinci == 0){ echo ' active'; }?>" pause="true">
                    <img class="img-fluid" src="<?= base_url("/assets/fotosNoticias") . "/" . $d["imagen"]?>" alt="<?= $d["titulo"] ?>" aria-hidden="true" focusable="false"></img>
                    <div class="container">
                        <div class="carousel-caption">
                            <h1><?= $d["titulo"] ?></h1>                
                        </div>
                    </div>
                </div>
        <?php   
                $countNotiPrinci++;
            } 
        } 
        ?>        
    </div> <!-- cerrado -->

    <!-- Left and right controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#slideNews" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slideNews" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div> <!-- cerrado -->

<!-- carousel --> 
<div class="container-fluid"  id="PadreContenido"> <!-- abierto -->
    <div class="row bg-red " id="rowHome">
        <div class=" col-xl-6 col-lg-6 col-md-6" data-aos="fade-right" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
            <img class="borderimgL bd-placeholder-img " width="140" height="140" src="<?= base_url("/assets/img/logouso.png")?>" alt="AFP" 
                aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></img>
            <h2 class="pt-3 tituloInst tituloInst2"><Center>Universidad de Sonsonate</Center></h2>
            <p class="parrafoInst ">Las diferentes acciones que se desarrollan fundamentan el desempeño de la Universidad en materia de proyección social,
                facilitando procesos institucionales que se generan con: Alcaldias Municipales, Empresas privadas, FAO, CENTA,MAG, MARN, ONG´S.</p>
            <p style="text-align: center;"></p>
        </div><!-- /.col-lg-4 -->
   

        <div class=" col-xl-6 col-lg-6 col-md-6" data-aos="fade-left" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
            <img class="borderimgL bd-placeholder-img" width="140" height="140" src="<?= base_url("/assets/img/logoagr.png")?>" alt="AFP" 
                aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></img>
            <h2 class="pt-3 tituloInst tituloInst2"><center> Centro de Agronegocios</center></h2>
            <p class="parrafoInst ">Provee servicios de alta calidad para facilitar el emprendimiento, contribuyendo de esta manera al desarrollo del
                productor agropecuario, en  un esquema integral proporcionando productos y servicios para la generación  de agronegocios globales.</p>
            <p style="text-align: center;"></p>
        </div><!-- /.col-lg-4 -->
    </div>
</div> <!-- cerrado -->

<div class="margenNoticias"> <!--abierto-->
    <hr class="featurette-divider">

    <div class="row featurette my-5" data-aos="zoom-in-right" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 order-md-2 my-auto divText">
            <h2 class="featurette-heading my-auto temaPLA  px-4"><center>Gestión empresarial</center></h2>
            <p class="lead my-auto pt-3 px-4 parrafoPLA">La gestión empresarial esta dirigida a los agroproductores para el fortalecimiento agroempresarial, 
                mediante el cual les permita contar con herramientas que les ayuden a tener una mejor administración de sus negocios.</p>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 order-md-1  mx-auto my-auto">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto px-4 imgPLA" width="500" height="500" 
            src="<?= base_url("/assets/img/ge3.jpg")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

        </div>
    </div>
    <hr class="featurette-divider">


    <div class="row featurette my-5" data-aos="zoom-in-left" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 order-md-1 my-auto">
            <h2 class="featurette-heading my-auto temaPLA"><center>Asistencias técnica agropecuarias</center></h2>
            <p class="lead my-auto pt-3 px-5 parrafoPLA">Las asistencias técnicas estan dirigidas a productores, agropecuarios, agro empresarios, entre otras personas que soliciten información específica
                 de cultivos y rubros que estos estén implementando.</p>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 order-md-2 mx-auto my-auto">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto imgPLAR" width="500" height="500" 
            src="<?= base_url("/assets/img/at1.jpg")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

        </div>
    </div>
    <hr class="featurette-divider">


    <div class="row featurette my-5" data-aos="zoom-in-right" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 order-md-2 my-auto">
            <h2 class="featurette-heading  px-5 my-auto temaPLA"><center>Planes, modelos y ruedas de negocios</center></h2>
            <p class="lead my-auto pt-3 px-5 parrafoPLA">Estos servicios son dirigidos al público en general que este interesado, ya que el servicio es gratuito para pequeños productores y organizaciones locales que no puedan costear
                los gastos, no así para agro empresarios y medianas empresas que lo requieran.</p>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 order-md-1 mx-auto my-auto">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto ps-5 imgPLA" width="500" height="500" 
            src="<?= base_url("/assets/img/pmrneg3.jpg")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

        </div>
    </div>
    <hr class="featurette-divider">


    <div class="row featurette my-5" data-aos="zoom-in-left" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 order-md-1  my-auto">
            <h2 class="featurette-heading my-auto temaPLA"><center>Capacitaciones</center></h2>
            <p class="lead my-auto pt-3 px-5 parrafoPLA">Las capacitaciones se basan en la transferencia de conocimientos básicos en forma teórico-práctico, así como las
                herramientas administrativas, que permitan un mayor desarrollo socio-económico de los productores agropecuarios y 
                micro-empresariales.</p>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 order-md-2  mx-auto my-auto">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto imgPLAR" width="500" height="500" 
            src="<?= base_url("/assets/img/cap.jpg")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

        </div>
    </div>
    <hr class="featurette-divider">


    <div class="row featurette my-5" data-aos="zoom-in-right" 
          data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
          data-aos-easing="ease-in-out">
        <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-6 order-md-2 my-auto">
            <h2 class="featurette-heading my-auto temaPLA"><center> Gestión ambiental</center></h2>
            <p class="lead my-auto pt-3 px-5 parrafoPLA">La gestión ambiental realiza metodologías para la elaboración de diagnósticos ambientales que están
                 dirigidos a las unidades ambientales municipales y a otras instituciones.</p>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 order-md-1 mx-auto my-auto">
            <img class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto my-auto ps-5 imgPLA" width="500" height="500" 
            src="<?= base_url("/assets/img/ga1.jpg")?>" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><!--<text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text>--></img>

        </div>
    </div>
    <hr class="featurette-divider">

</div> <!--cerrado-->

<div class="margenNoticias2">
    <div class="card-deck row">   
        <?php         
        foreach ($noticias as $d) { ?>     
            <div class="col-md-6 card-min-heightNoti" data-aos="fade-down" 
                data-aos-duration="1000" data-aos-once="true" data-aos-delay="50" data-aos-offset="200" data-aos-mirror="true"
                data-aos-easing="ease-in-out">
                <div class="card border-left-dark shadow mb-4 ">
                    <img class="card-img-top img-thumbnail heigthImg" src="<?= base_url("/assets/fotosNoticias/") . "/" . $d["imagen"]?>">
                    
                    <div class="card-body heigthText">
                        <h5 class="card-title text-dark"><center><?= $d["titulo"] ?></center></h5>
                        <p class="card-text"><?= $d["descripcion"] ?></p> 
                    </div>
                    <div class="card-footer" style="height: 41px;" >
                        <small class="text-muted">Publicado el 06-07-2021</small>                   
                    </div>
                </div>
                <div class="w-100 d-none d-sm-block d-md-none"></div>
            </div>
        <?php } ?>
    </div>
</div>
            

           
        

         







        
    

