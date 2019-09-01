<?php
/** @var UploadForm $model */

use app\modules\panel\models\form\UploadForm;

?>
<?php if (count($model->existed) > 0):?>
<hr>
<h4>Already exist</h4>
<div class="uploaded-items">
    <?php foreach ($model->existed as $item):?>
        <div><?= $item; ?></div>
        <hr>
    <?php endforeach;?>
</div>
<hr>
<?php endif;?>
