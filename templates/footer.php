
<script>
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("navbar").style.top = "0";
        } else {
            document.getElementById("navbar").style.top = "-70px";
        }
        prevScrollpos = currentScrollPos;
}
</script>
<footer class="section">
<div class="foot">


<div class="container-fluid ">

    <div class="row align-items-center justify-content-center"> 
    
    <div class="col-lg-4 col-xs-12 text-right m-2 mr-1"> 
    <h5> КОНТАКТИ </h3>
    <p> (+359) 999 999999 <br> Ива Събкова /председател/</p>
    <p> email: gup_vt@abv.bg </p>
    </div>

    <div class="col-lg-4 col-xs-12"> 
    <h5> АДРЕС </h3>
    <p> стая 306,<br> Младежки дом,<br> гр. Велико Търново, <br>България </p>
    </div>

    </div>
    
    
    <div class="row align-items-center justify-content-center"> 
    
        <div class="col-lg-4 col-xs-12 social"> 
        <a target="_blank" href="https://www.instagram.com/gup_vt/">
        <i class="fab fa-instagram"></i> <span>@gup_vt</span>
        </div>
        </a>

        <div class="col-lg-4 col-sm-12 social"> 
        <a target="_blank" href="https://www.facebook.com/Citystudentparliament/">
        <i class="fab fa-facebook"></i> <span> @citystudentparliament</span>
        </div>
        </a>

    </div>
</div>
   
<div class="text-center">Copyright &copy <?php echo date("Y"); ?> GUPapp </div>
</footer> </div>
</body>
