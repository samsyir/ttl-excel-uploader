<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
        	<div class="page-header users-header">
            <h2>Upload Kas
        	</h2>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12">
    		<?php echo validation_errors(); ?>
            <?php echo form_open_multipart('fa/do_upload_kas'); ?>
    		<fieldset>
                <?php echo $error; ?>                
                <div class="form-group">
                    <?php 
                        echo '<label>Nama File'.$error.'</label>';
                        echo form_upload('userfile');
                    ?>
                </div>
                <!-- <div class="form-group">
                    <?php $options = array(
                        '1'=>'JANUARI',
                        '2'=>'FEBRUARI',
                        '3'=>'MARET',
                        '4'=>'APRIL',
                        '5'=>'MEI',
                        '6'=>'JUNI',
                        '7'=>'JULI',
                        '8'=>'AGUSTUS',
                        '9'=>'SEPTEMBER',
                        '10'=>'OKTOBER',
                        '11'=>'NOVEMBER',
                        '12'=>'DESEMBER');
                            $attribute = array('class'=>'form-control');
                        echo form_dropdown('bulan',$options,'JANUARI',$attribute);
                    ?>
                </div>
                <div class="form-group">
                    <?php 
                        $year = date('Y');

                        $options = array(
                            $year-3 =>$year-3,
                            $year-2 =>$year-2,
                            $year-1 =>$year-1,
                            $year   =>$year,
                            $year+1 =>$year+1,
                            $year+2 =>$year+2);
                            $attribute = array('class'=>'form-control');
                        echo form_dropdown('tahun',$options,$year,$attribute);
                    ?>
                </div> -->
                <!-- Change this to a button or input when using this as a form -->
                <button class="btn btn-lg btn-success btn-block" type="submit" value="upload">Upload</button>
                <a href="<?= site_url('welcome');?>" class="btn btn-lg btn-failure btn-block" >Cancel</a>
            </fieldset>
    		<?= form_close();?>
    	</div>
    </div>
</div>