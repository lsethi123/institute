    <script type="text/javascript">
        $(document).ready(function(){
           $(".header-toggle").hover(function(){
                $(this).addClass("header-toggle-hover");
           },function(){
                $(this).removeClass("header-toggle-hover");
           }).click(function(){
                $(".content-box-content-toggle").slideToggle("normal");                
           });
            
           $(".button-box").hover(function(){
                $(this).css('background-color', '#E4E4E4');
                $(".button-detail",this).fadeIn();
           },function(){
                $(this).css('background-color', '#fff');
                $(".button-detail",this).fadeOut();
           });
           
           $(".dashboard-close").click(function(e){
                e.preventDefault();
                $(".content-box-content-toggle").slideUp("normal");
           });
        });
    </script>
    <div class="content-box">
        <div class="content-box-header header-toggle">
            <h3>Dashboard</h3>
        </div>
        <div class="content-box-content content-box-content-toggle">
            <div class="dashboard-options">
                <div class="button-box">
                  <a href="addstate.php" class="option-buttons" id="opt_state">
                    <div class="button-label">
                        <p>State</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage States
                  </div>
                </div>
                <div class="button-box">
                  <a href="addcity.php" class="option-buttons" id="opt_city">
                    <div class="button-label">
                        <p>City</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage City
                  </div>
                </div>
                <div class="button-box">
                  <a href="addloc.php" class="option-buttons" id="opt_loc">
                    <div class="button-label">
                        <p>Location</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Location
                  </div>
                </div>
                <div class="button-box">
                  <a href="addLandmark.php" class="option-buttons" id="opt_lnd">
                    <div class="button-label">
                        <p>Landmarks</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Landmarks
                  </div>
                </div>
                <div class="button-box">
                  <a href="addamenity.php" class="option-buttons" id="opt_amn">
                    <div class="button-label">
                        <p>Amenities</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Amenities
                  </div>
                </div>
                <div class="button-box">
                  <a href="addTestimonials.php" class="option-buttons" id="opt_tst">
                    <div class="button-label">
                        <p>Testimonial</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Testimonial
                  </div>
                </div>
                <div class="button-box">
                  <a href="#" class="option-buttons" id="opt_adv">
                    <div class="button-label">
                        <p>Advertisement</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Advertisement
                  </div>
                </div>
                <div class="button-box">
                  <a href="addbuilder.php" class="option-buttons" id="opt_builder">
                    <div class="button-label">
                        <p>Builder</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Builder Details
                  </div>
                </div>
                <div class="button-box">
                  <a href="addproject.php" class="option-buttons" id="opt_project">
                    <div class="button-label">
                        <p>Project</p>
                    </div>
                  </a>
                  <div class="button-detail">
                    Manage Project Details
                  </div>
                </div>
                <div class="cleaner"></div>
                <a href="#" class="dashboard-close"></a>
            </div>
        </div>
    </div>