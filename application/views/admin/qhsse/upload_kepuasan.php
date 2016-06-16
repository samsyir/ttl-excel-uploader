<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header users-header">
            <h2>Upload Kepuasan
            </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php echo validation_errors(); ?>
            <?php echo form_open_multipart('qhsse/do_upload_mutu'); ?>
            <fieldset>
                <?php echo $error; ?>                
                <div class="form-group">
                    <?php 
                        echo '<label>Nama File'.$error.'</label>';
                        echo form_upload('userfile');
                    ?>
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <button class="btn btn-lg btn-success btn-block" type="submit" value="upload">Upload</button>
                <a href="<?= site_url('welcome');?>" class="btn btn-lg btn-failure btn-block" >Cancel</a>
            </fieldset>
            <?= form_close();?>
        </div>
    </div>
</div>