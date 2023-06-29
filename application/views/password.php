
<section class="top">
<?php
    $this->load->view('template/kop');
?>
</section>
<hr>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view("admin/menu"); ?>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Ganti Password
                </div>
                <div class="card-body">
                <?php 
                    if($this->session->flashdata('message')!="") { ?> <div class="alert alert-danger"><?=$this->session->flashdata('message'); ?> </div><?php } 
                    if (validation_errors()) {
                        echo '<div class="alert alert-danger">';
                        echo validation_errors();
                        echo '</div>';
                    }?>
                <form action="<?=base_url('password/store')?>" method="POST">
                    <div class="form-group">
                      <label for="password_lama">Password Lama</label>
                      <input name="password_lama" class="form-control" required />
                    </div>
                    <div class="form-group">
                      <label for="password_baru">Password Baru</label>
                      <input name="password_baru" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
