<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\customWidgets\CustomCaptchaAction;
use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\models\ContactForm;
use app\models\Item;
use app\models\Message;
use app\models\Page;
use app\models\projects\Apartment;
use app\models\projects\ApartmentSearch;
use app\models\projects\Investment;
use app\models\projects\InvestmentSearch;
use app\models\projects\OtherConstruction;
use app\models\projects\OtherConstructionSearch;
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
                'width' => 130,
                'height' => 40,
                'transparent' => true,
                'onlyNumber' => true,
                'foreColor' => 0x555555,
                'minLength' => 4,
                'maxLength' => 4,
                'fontFile' => '@webroot/themes/frontend/assets/fonts/OpenSans-Bold.ttf'
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

        $availableApartments = Apartment::find()->andWhere(['>', Apartment::columnGetString('free_count'), 0])->count();

        $term = Yii::$app->request->getQueryParam('query');
        if ($term && !empty($term)) {
            $searchApartment = new ApartmentSearch();
            $searchApartment->name = $term;
            $searchApartment->subtitle = $term;
            $apartmentProvider = $searchApartment->search([]);
            $apartmentProvider->getPagination()->pageSize = 20;

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

            return $this->render('//apartment/list', [
                'projects' => $apartmentProvider->getModels(),
                'availableApartments' => $availableApartments,
            ]);

//            return $this->render('search', compact('term', 'investmentProvider',
//                'constructionProvider', 'searchApartment', 'apartmentProvider', 'services'));
        } else
            return $this->goBack();
    }


    public function actionIndex()
    {
        $this->bodyClass = 'home';

        $apartmentCounts = Apartment::find()->count();
        $investmentCounts = Investment::find()->count();
        $constructionCounts = OtherConstruction::find()->count();

//        $services = Service::find()->where(['=','name','SERVICES'])->orderBy(['id' => SORT_DESC,])->all();
        $services = Service::find()->all();
        $slides = Slide::find()->valid()->orderBy(['id' => SORT_ASC])->all();

        $availableApartments = Apartment::find()->orderBy([Apartment::columnGetString('special') => SORT_DESC, 'id' => SORT_DESC])->andWhere(['>', Apartment::columnGetString('free_count'), 0])->all();
        $availableInvestments = Investment::find()->orderBy([Investment::columnGetString('special') => SORT_DESC, 'id' => SORT_DESC])->andWhere(['>', Investment::columnGetString('free_count'), 0])->all();
        $availableConstructions = OtherConstruction::find()->orderBy([OtherConstruction::columnGetString('special') => SORT_DESC, 'id' => SORT_DESC])
//            ->andWhere(['>', OtherConstruction::columnGetString('free_count'), 0])
            ->all();

        return $this->render('index', compact(['slides', 'apartmentCounts', 'investmentCounts',
            'constructionCounts', 'availableApartments', 'availableInvestments', 'availableConstructions', 'services']));
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $this->setTheme('frontend');
        $this->innerPage = true;
        $this->bodyClass = 'more-one list';
        $this->mainTag = 'main-submit-page';

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
                $message->subject = $model->subject;
                $message->email = $model->email;
                $message->body = $model->body;
                if($message->save())
                    $model->contact(Setting::get('email'));

                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
//
//    /**
//     * Displays about page.
//     *
//     * @return string
//     */
//    public function actionAbout()
//    {
//        $this->setTheme('frontend');
//        $this->innerPage = true;
//        $this->bodyClass = 'text-page';
//        $this->headerClass = 'header-style-2';
//        $this->mainTag = 'main-text-page';
//
//        $model = Page::find()->one();
//
//        $availableApartments = Apartment::find()->andWhere(['>', Apartment::columnGetString('free_count'), 0])->all();
//
//        return $this->render('//page/show', compact('availableApartments', 'model'));
//    }


    public function getProjects()
    {
        return Apartment::find()->andWhere(['>', Apartment::columnGetString('free_count'), 0])->all();
    }
}
