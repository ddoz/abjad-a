
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
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="card">
                                <div class="card-header">Monitoring</div>
                                <div class="card-body">
                                    <img width="100" src="<?=base_url('assets/img/monitoring.png')?>" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-header">Konsultasi</div>
                                <div class="card-body">
                                    <img width="100" src="<?=base_url('assets/img/konsultasi.png')?>" alt="">
                                </div>
                            </div>
                        </div>
                        <?php if($this->session->userdata('level')=='admin'){ ?>
                        <div class="col-md-4 text-center">
                            <div class="card">
                                <div class="card-header">Data Siswa</div>
                                <div class="card-body">
                                    <img width="100" src="<?=base_url('assets/img/data.png')?>" alt="">
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <?php if($this->session->userdata('level')=='admin'){ ?>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Grafik Monitoring</div>
                                <div class="card-body">
                                    <div id="chartContainer" style="width: 100%; height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>