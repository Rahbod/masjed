<?php

/** @var ActiveDataProvider $projectProvider */

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
$baseUrl = $this->theme->baseUrl;
?>


<?php
if ($projectProvider->totalCount): ?>
    <section class="full-slide">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= $baseUrl ?>. /images/apartment-icon-w.png" alt="apartment-icon">
                        <div class="text">
                            <h2 class="slide"><strong>found </strong> apartment</h2>
                        </div>
                    </div>
                    <div class="title-right">
                        <p class="slide">
                            <span class="available-project">found<br>
									apartment </span>
                            <span class="num"><?= $projectProvider->count ?></span>
                        </p>
                    </div>
                </div>
                <div class="container-fluid project-list">
                    <div class="row">
                        <? if ($projectProvider->count): ?>
                            <?php echo \yii\widgets\ListView::widget([
                                'id' => 'project-list',
                                'dataProvider' => $projectProvider,
                                'itemView' => '//page/_page_item',
                                'layout' => '{items}'
                            ]) ?>
                        <? else: ?>
                            <div class="empty-box d-flex">
                                <h3 class="d-flex__title"><?= trans('words', 'No Result!') ?></h3>
                            </div>
                        <? endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
