        </div>
        <!-- content-wrapper --></div>
    </section>
    <!-- home-section -->    

    <!-- footer -->
    <footer class="pt-2 pb-2 text-white">
        <div class="container-fluid">     
            <div class="row pt-2 pb-2">         
                <div class="col align-self-center text-end">
                     <img class="img-thumbnail" src="<?= base_url("/assets/img/logousocompleto.jpeg")?>" height="39px" width="100px" class="gallery-item" alt="USO">
                </div>           
                <div class="col align-self-center text-start">
                    <span class="text-secondary">USO - 2021</span>
                </div>                   
            </div>     
        </div> 
    </footer>    
    <!-- footer -->   

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar la sesión?</h5>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" en el botón de abajo si estás listo para terminar la sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-primary-v2" onclick="cerrarSesion()">Cerrar Sesión</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>/assets/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url() ?>/assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.ir-arriba').click(function(){ 
                $('body,html').animate({ 
                    scrollTop:'0px' 
                }, 400); 
            }); 
            
            $(window).scroll(function(){
                if($(this).scrollTop() > 0){ 
                    $('.ir-arriba').slideDown(400);
                }else{ 
                    $('.ir-arriba').slideUp(400); 
                }
            });

            let sidebar = document.querySelector(".sidebar");
            let closeBtn = document.querySelector("#btn");

            closeBtn.addEventListener("click", ()=>{
                sidebar.classList.toggle("open");
            });
        });      

        function cerrarSesion() {      
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo site_url("Login/Logout") ?>",
                success: function() {
                    $("#logoutModal").modal("toggle");
                }, 
                complete: function() {  
                    location.reload();
                }                
            });
        }  
    </script>    
</body>