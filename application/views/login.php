<?php
    $this->load->view('template/navbar');
?>


<div class="container-fluid" id="background-main">
    <div class="formLogin">       

        <h5>MONITORING DAN KONSULTASI BIMBINGAN KONSELING</h5>    
        <form action="<?=base_url()?>login/proses" method="POST">
            
            <?php 
            if($this->session->flashdata('message')!="") { ?> <div class="alert alert-danger"><?=$this->session->flashdata('message'); ?> </div><?php } 
            if (validation_errors()) {
                echo '<div class="alert alert-danger">';
                echo validation_errors();
                echo '</div>';
            }?>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Username" name="username" required>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" placeholder="Password" name="password" required>
            </div>
            <button class="btn btn-success">Login</button>
        </form>
    </div>

</div>