<div class="social-icon">
    <ul class="social-list">
        <?php use app\components\Setting;
        use yii\helpers\Url;

        $val = Setting::get('socialNetworks.whatsapp');
        echo $val && !empty($val) ? '<li class="social-item whatsapp"><a href="' . $val . '" target="_blank"><i class="fab fa-whatsapp"></i></a></li>' : ''; ?>

        <?php $val = Setting::get('socialNetworks.twitter');
        echo $val && !empty($val) ? '<li class="social-item twitter"><a href="' . $val . '" target="_blank"><i class="fab fa-twitter"></i></a></li>' : ''; ?>

        <?php $val = Setting::get('socialNetworks.instagram');
        echo $val && !empty($val) ? '<li class="social-item instagram"><a href="' . $val . '" target="_blank"><i class="fab fa-instagram"></i></a></li>' : ''; ?>

        <?php $val = Setting::get('socialNetworks.facebook');
        echo $val && !empty($val) ? '<li class="social-item facebook"><a href="' . $val . '" target="_blank"><i class="fab fa-facebook-f"></i></a></li>' : ''; ?>

        <?php $val = Setting::get('socialNetworks.youtube');
        echo $val && !empty($val) ? '<li class="social-item youtube"><a href="' . $val . '" target="_blank"><i class="fab fa-youtube"></i></a></li>' : ''; ?>
    </ul>
</div>
