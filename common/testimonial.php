        <div class="testimonials">
                <div class="testimonials-heading">
                   TESTIMONIALS
                </div>
           <?php
            $BUFF = 3;
            $sql = "SELECT `username_tst`,`testimonial_tst` FROM `testimonials_tst` ORDER BY RAND() LIMIT $BUFF ;";
            $data = $db->fetchQueryPrepared($sql,array());
           ?>
            <?php foreach($data as $val)
                  {
                  ?>    
           
                <div class="testimonials-block">
                     <div class="testimonials-cont">
                           <p style="font-style: italic;font-family: sans-serif;font-size:small;"><?php echo $val['testimonial_tst'];?></p> 
                            <div class="testimonials-user">
                                <a href="#" ><b><?php echo $val['username_tst'];?></b></a>
                            </div>
                     </div>
                     <br/>
                     
                </div>
           <?php }?>
        </div>