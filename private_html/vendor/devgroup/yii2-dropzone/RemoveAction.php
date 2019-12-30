<?php

namespace devgroup\dropzone;

use app\components\DynamicActiveRecord;
use app\models\Attachment;
use app\models\Item;
use app\models\Page;
use Yii;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class RemoveAction extends Action
{
    const STORED_JSON_MODE = 'json';
    const STORED_FIELD_MODE = 'field';
    const STORED_DYNA_FIELD_MODE = 'dyna_field';
    const STORED_RECORD_MODE = 'record';

    public $rename = false; // false|unique|uniquewithext

    public $tmpDir = 'uploads/temp';
    /**
     * @var string upload folder Dir
     */
    public $upload;

    /**
     * @var array thumbnail sizes array
     */
    public $thumbSizes = array();
    /**
     * @var ActiveRecord|DynamicActiveRecord model class instance
     */
    public $model;
    /**
     * @var string attribute name
     */
    public $attribute;
    /**
     * @var string saved in Database mode for this file field|record
     */
    public $storedMode;

    public $options = [];

    public function init()
    {
        if (!$this->upload)
            throw new \Exception('{upload} main files folder path is not specified.', 500);
        if (!$this->attribute)
            throw new \Exception('{attribute} attribute is not specified.', 500);
    }

    public function run()
    {
        $this->init();
        $deleteFlag = false;
        $upload = Yii::getAlias("@webroot/$this->upload/");
        $tmpDir = Yii::getAlias("@webroot/$this->tmpDir/");
        if (isset($_POST['fileName'])) {
            $fileName = $_POST['fileName'];
            $file = new UploadedFiles($this->upload, $fileName, $this->options);
            $deleteFlag = true;

            if ($this->model instanceof ActiveRecord) {
                if ($this->storedMode === self::STORED_DYNA_FIELD_MODE) {
                    $modelClass = $this->model;
                    $model = $this->model->find()->filterWhere([$modelClass::columnGetString($this->attribute) => $fileName])->one();
                }else
                    $model = $this->model->find()->filterWhere([$this->attribute => $fileName])->one();

                if ($model) {
                    if ($this->storedMode === self::STORED_DYNA_FIELD_MODE || $this->storedMode === self::STORED_FIELD_MODE) {
                        $model->{$this->attribute} = null;
                        $deleteFlag = $model->save(false) ? true : false;
                    } elseif ($this->storedMode === self::STORED_RECORD_MODE)
                        $deleteFlag = $model->delete() ? true : false;

                    if ($this->model instanceof Attachment)
                        $upload .= "$model->path/";
                }
            }

            if ($deleteFlag) {
                if ($file->remove($fileName, true))
                    $response = ['status' => true, 'msg' => 'فایل با موفقیت حذف شد.'];
                else
                    $response = ['status' => false, 'msg' => 'حذف فایل با مشکل مواجه شد.'];
            } else
                $response = ['status' => false, 'msg' => 'حذف فایل با مشکل مواجه شد.'];
        } else
            $response = ['status' => false, 'message' => 'نام فایل موردنظر ارسال نشده است.'];
        return Json::encode($response);
    }
}