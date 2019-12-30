<?php

use app\controllers\ProjectController;
use app\models\Project;
use yii\web\View;

/** @var View $this */
/** @var Project $model */

$baseUrl = $this->theme->baseUrl;
?>
<div class="fade show d-none">
    <div class="overly">
        <?= $this->render('//site/_project_side', compact('model')) ?>
    </div>
    <?php if ($pdf_url = $model->getPdfUrl(ProjectController::$pdfDir)): ?>
        <div class="download">
            <a href="<?= $pdf_url ?>">
                <p><?= trans('words', 'Download As<br><strong>PDF</strong>') ?></p>
            </a>
        </div>
    <?php endif; ?>
</div>
<?= $model->render($this) ?>

