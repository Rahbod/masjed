<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\customWidgets\CustomCaptchaAction;
use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\components\SmsSender;
use app\models\ContactForm;
use app\models\Item;
use app\models\Message;
use app\models\Page;
use app\models\ProjectSearch;
use app\models\Service;
use app\models\Slide;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

//use Symfony\Component\EventDispatcher\Tests\Service;

class SiteController extends AuthController
{

    public function getMenuActions()
    {
        return [
            'index',
            'contact',
            'coming-soon'
//            'about',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionComingSoon(){
        return $this->renderPartial('coming_soon');
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => CustomCaptchaAction::className(),
                'setTheme' => true,
                'width' => 100,
                'height' => 40,
                'transparent' => true,
                'onlyNumber' => true,
                'foreColor' => 0x555555,
                'minLength' => 4,
                'maxLength' => 4,
                'fontFile' => '@webroot/themes/frontend/fonts/OpenSans/Bold/OpenSans-Bold.ttf'
            ],
        ];
    }


//    public function actionError()
//    {
//        var_dump(Yii::$app->request);exit;
//    }

    public function actionChangeLang($language = false, $controller = false, $action = false)
    {
        if ($language && in_array($language, array_keys(MultiLangActiveRecord::$langArray))) {
            Yii::$app->language = $language;
            Yii::$app->session->set('language', $language);
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
            ]);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::$app->response->cookies->add($cookie);
        }

        $referrer = Yii::$app->request->getReferrer() ?: ['/'];
        if (!$controller)
            return $this->redirect($referrer);

        $url = str_replace(["/$language", "$language/"], "", $referrer);
        return $this->redirect($url);
    }


    public function actionSearch()
    {
        $this->innerPage = true;
        $this->bodyClass = 'more-one list';

        $term = Yii::$app->request->getQueryParam('query');
        if ($term && !empty($term)) {
            $searchProject = new ProjectSearch();
            $searchProject->name = $term;
            $searchProject->subtitle = $term;
            $projectProvider = $searchProject->search([]);
            $projectProvider->getPagination()->pageSize = 20;

//            $searchInvestment = new InvestmentSearch();
//            $searchInvestment->name = $term;
//            $searchInvestment->subtitle = $term;
//            $investmentProvider = $searchInvestment->search([]);
//            $investmentProvider->getPagination()->pageSize = 20;
//
//            $searchConstruction = new OtherConstructionSearch();
//            $searchConstruction->name = $term;
//            $searchConstruction->subtitle = $term;
//            $constructionProvider = $searchConstruction->search([]);
//            $constructionProvider->getPagination()->pageSize = 20;

//            $searchPage = new PageSearch();
//            $searchPage->name = $term;
//            $searchPage->body = $term;
//            $searchPage->status = Page::STATUS_PUBLISHED;
//            $pageProvider = $searchPage->search([]);
//            $pageProvider->getPagination()->pageSize = 100;

//            $services = Service::find()->all();

            return $this->render('//project/list', [
                'projects' => $projectProvider->getModels()
            ]);
        } else
            return $this->goBack();
    }


    public function actionIndex()
    {
        $this->setTheme('frontend');
        $this->layout = 'main';
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {

                $message = new Message();
                $message->name = $model->name;
                $message->tel = $model->tel;
                $message->email = $model->email;
                $message->body = $model->body;
                if($message->save())
                    $model->contact(Setting::get('email'));

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['/']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        $this->setTheme('frontend');
        $this->layout = 'main';
        return $this->render('index');
    }

    public function actionTest()
    {
        dd(SmsSender::SendPaymentSuccessful('09358389265','یوسف مبشری',number_format(15000000). 'تومان'));
    }
}
