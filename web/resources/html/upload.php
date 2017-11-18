<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="fileupload"><?= __("Please select the whats app .txt file") ?>:</label>
        <input type="file" class="form-control-file" id="fileupload" name="fileupload">
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="<?= __("Analyse") ?>">
</form>