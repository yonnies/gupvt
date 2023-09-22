<script>
    // JavaScript for handling the navbar hide/show behaviour on scroll
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            // Scroll Up: Show the navbar
            document.getElementById("navbar").style.top = "0";
        } else {
            // Scroll Down: Hide the navbar
            document.getElementById("navbar").style.top = "-70px";
        }
        prevScrollpos = currentScrollPos;
    }
</script>

<footer class="section">
    <div class="foot">
        <div class="container-fluid">
            <!-- Contact Information -->
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-4 col-md-4 col-xs-12 text-right m-2 mr-1">
                    <h5>КОНТАКТИ</h5>
                    <p>(+359) 999 999999<br>Ива Събкова /председател/</p>
                    <p>email: gup_vt@abv.bg</p>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <h5>АДРЕС</h5>
                    <p>стая 306,<br>Младежки дом,<br>гр. Велико Търново,<br>България</p>
                </div>
            </div>
            
            <!-- Social Media Links -->
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-4 col-md-4 col-xs-12 social">
                    <a target="_blank" href="https://www.instagram.com/gup_vt/">
                        <i class="fab fa-instagram"></i> <span>@gup_vt</span>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12 social">
                    <a target="_blank" href="https://www.facebook.com/Citystudentparliament/">
                        <i class="fab fa-facebook"></i> <span>@citystudentparliament</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Copyright Information -->
        <div class="text-center">Copyright &copy; <?php echo date("Y"); ?> GUPapp</div>
    </div>
</footer>
