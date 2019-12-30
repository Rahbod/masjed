<?php

use app\controllers\ApartmentController;
use app\models\projects\Apartment;
use yii\web\View;

/** @var View $this */
/** @var Apartment $model */

$baseUrl = $this->theme->baseUrl;
?>
<div class="fade show d-none">
    <div class="overly">
        <?= $this->render('//site/_project_side', compact('model')) ?>
    </div>
    <?php if ($pdf_url = $model->getPdfUrl(ApartmentController::$pdfDir)): ?>
        <div class="download">
            <a href="<?= $pdf_url ?>">
                <p><?= trans('words', 'Download As<br><strong>PDF</strong>') ?></p>
            </a>
        </div>
    <?php endif; ?>
</div>
<?= $model->render($this) ?>

