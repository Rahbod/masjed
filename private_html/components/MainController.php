<?php

namespace app\components;


use app\models\Advice;
use app\models\Cooperation;
use app\models\Department;
use app\models\Field;
use app\models\Menu;
use app\models\Message;
use app\models\Model;
use app\models\Reception;
use app\models\Request;
use app\models\User;
use app\models\UserRequest;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\Controller;

/**
 * Class MainController
 * @package app\components
 *
 * @property User $user
 */
class MainController extends Controller implements CrudControllerInterface
{
    public $bodyClass='home';
    public $headerClass='';
    public $innerPage=false;
    public $mainTag='';
    public $theme;
    public $tmpDir = 'uploads/temp';
    public static $tempDir = 'uploads/temp';
    public $models;
    public $menus;

    public $submenu = [];
    public $breadcrumbs = [];

    public function init()
    {
        parent::init();
        app()->name = trans('words', 'App Name');
        if (app()->session->has('language'))
            app()->language = app()->session->get('language');
        else if (isset(app()->request->cookies['language']))
            app()->language = app()->request->cookies['language']->value;

        $this->initializeRequirements();
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getMenuActions()
    {
        return [];
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getSystemActions()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getSamePermissions()
    {
        return [];
    }

    public function userCanAccess($action, $isPermissionName = false)
    {
        /* @var $role \yii\rbac\Role */
        $roles = app()->authManager->getRolesByUser(app()->user->id);
        foreach ($roles as $role)
            if ($role->name == 'superAdmin')
                return true;

        if ($isPermissionName)
            return $permissions || app()->user->can($action);
        else
            return $permissions || app()->user->can($this->id . ucfirst($action));
    }


    public function setTheme($theme, $config = [])
    {
        if ($theme) {
            app()->view->theme = new \yii\base\Theme([
                'basePath' => '@webroot/themes/' . $theme,
                'baseUrl' => '@web/themes/' . $theme,
            ]);

            foreach ($config as $key => $value)
                $this->$key = $value;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $validClasses
     * @param array $excludeClasses
     * @param bool $menuActions
     * @return array
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAllActions($validClasses = [], $excludeClasses = [], $menuActions = false)
    {
        $excludeClasses = array_merge($excludeClasses, [
            'app\controllers\ApiController',
            'app\controllers\CronController'
        ]);

        $actions = [];
        foreach (glob(alias('@app') . '/controllers/*Controller.php') as $controller) {
            $className = 'app\controllers\\' . basename($controller, '.php');

            if ($validClasses && !in_array($className, $validClasses))
                continue;

            if (!in_array($className, $excludeClasses)) {
                $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);

                preg_match('/(app\\\\controllers\\\\)(\w*)(Controller)/', $className, $matches);
                if (!$matches)
                    continue;

                $class = app()->createControllerByID(strtolower($matches[2]));

                if ($menuActions) {
                    if (!method_exists($className, 'getMenuActions'))
                        continue;

                    $className = explode('\\', $className);
                    $className = end($className);

                    foreach ($class->getMenuActions() as $key)
                        $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = $key;
                    continue;
                }

                if (!($class instanceof AuthController))
                    continue;

                $unusableClasses = ['yii\web\Controller', 'yii\base\Controller', 'app\components\MainController'];
                foreach ($methods as $method) {
                    if (in_array($method->class, $unusableClasses))
                        continue;

                    $className = StringHelper::basename($method->class);
                    preg_match('/(app\\\\controllers\\\\)(\w*)(Controller)/', $method->class, $matches);
                    if (!$matches)
                        continue;

                    $class = app()->createControllerByID(strtolower($matches[2]));

                    if (!method_exists($method->class, 'getSystemActions'))
                        continue;

                    $excludeActions = $class->getSystemActions();
                    foreach ($class->getSamePermissions() as $permission => $samePermission) {
                        if (is_string($samePermission))
                            $excludeActions[] = $samePermission;
                        elseif (is_array($samePermission))
                            $excludeActions = array_merge($excludeActions, $samePermission);
                    }

                    if ($method->name == 'actions') {
                        $list = $class->actions();
                        foreach (array_keys($list) as $key) {
                            if (in_array($key, $excludeActions))
                                continue;

                            if (key_exists(lcfirst(substr($className, 0, strpos($className, 'Controller'))), $actions))
                                if (in_array($key, $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))]))
                                    continue;

                            $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = $key;
                        }
                    } elseif (preg_match('/action(\w*)/', $method->name) == 1) {
                        $methodBasename = substr($method->name, 6);
                        $methodBasename = lcfirst($methodBasename);

                        if (in_array($methodBasename, $excludeActions))
                            continue;
                        if (key_exists(lcfirst(substr($className, 0, strpos($className, 'Controller'))), $actions))
                            if (in_array(lcfirst(substr($method->name, 6)), $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))]))
                                continue;

                        $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = lcfirst(substr($method->name, 6));
                    }
                }
            }
        }

        return $actions;
    }

    /**
     * @return mixed
     */
    public function getModel($name)
    {
        return isset($this->models[$name]) ? $this->models[$name] : null;
    }

    /**
     * Prepare input array to show in jsTree widget
     * @param array $array
     * @param null|array $selected
     * @param null|string $parent
     * @return array
     */
    protected function prepareForView($array, $selected = null, $parent = null)
    {
        $temp = [];
        foreach ($array as $key => $value) {
            $node = [
                'name' => is_string($key) ? $key : $parent . '-' . $value,
                'alias' => trans('actions', is_string($key) ? $key : $value),
                'actions' => is_array($value) ? $this->prepareForView($value, $selected, $key) : false,
                'selected' => false,
            ];

            if (!is_null($selected) and !is_array($value) and !is_null($parent))
                if (in_array($parent . ucfirst($value), $selected))
                    $node['selected'] = true;

            $temp[] = $node;
        }
        return $temp;
    }

    public function prepareForSelect($array)
    {
        $temp = [];
        foreach ($array as $controller => $actions) {
            foreach ($actions as $action)
                $temp[$controller][lcfirst($controller) . '@' . $action] = trans('actions', lcfirst($controller) . '.' . $action);
        }
        return $temp;
    }

    public static function getMenu($roleID)
    {
        $roleID = !$roleID ? 'guest' : $roleID;

        switch ($roleID) {
            case 'operator':
                $permissions = false;
                $menuName = 'Operator Menu';
                break;
            case 'admin':
            case 'superAdmin':
                $permissions = true;
                $menuName = 'Management Menu';
                break;
            case 'guest':
            default:
                $permissions = false;
                $menuName = 'Guest';
                break;
        }

        $contactLinks = [];
//        foreach (Department::find()->valid()->all() as $item) {
//            $contactLinks[] = ['label' => "پیام های {$item->name}", 'url' => ['/message/index', 'id' => $item->id], 'visible' => $permissions || app()->user->can('messageIndex')];
//        }
        $contactLinks[] = ['label' => 'پیام های تماس با ما', 'url' => ['/message/index'], 'visible' => $permissions || app()->user->can('messageContactus')];
        $contactCount = Message::find()->andWhere(['type' => Message::STATUS_UNREAD])->count();
        $contactCount = $contactCount>0?'<span class="m-badge m-badge--danger float-right">'.$contactCount.'</span>':'';

        // unread requests
        $unreadCount = Request::find()->andWhere(['status' => Request::STATUS_UNREAD])->count();
        $unreadCount = $unreadCount>0?'<span class="m-badge m-badge--danger float-right">'.$unreadCount.'</span>':'';

        return [
            [
                'label' => '<i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">' . trans('words', 'Dashboard') . '</span>',
                'url' => ['/admin'],
                'visible' => $permissions || app()->user->can('adminDashboard')
            ],

            "<li class='m-menu__section'><h4 class='m-menu__section-text'>" . trans('words', $menuName) . "</h4><i class='m-menu__section-icon flaticon-more-v3'></i></li>",
            [
                'label' => '<i class="m-menu__link-icon fa fa-bars"></i><span class="m-menu__link-text">' . trans('words', 'Menus') . '</span>',
                'url' => ['/menu/index'],
                'visible' => $permissions || app()->user->can('menuIndex')
            ],
//
//            [
//                'label' => '<i class="m-menu__link-icon fas fa-building"></i><span class="m-menu__link-text">پروژه ها</span>',
//                'url' => ['/project/index'],
//                'visible' => $permissions || app()->user->can('projectIndex')
//            ],

            [
                'label' => '<i class="m-menu__link-icon fa fa-server"></i><span class="m-menu__link-text">' . trans('words', 'Items') . '</span>',
                'items' => [
                    ['label' => trans('words', 'Slides'), 'url' => ['/slide/index'], 'visible' => $permissions || app()->user->can('slideIndex')],
                    ['label' => trans('words', 'Pages'), 'url' => ['/page/index'], 'visible' => $permissions || app()->user->can('pageIndex')],
                    ['label' => trans('words', 'Post'), 'url' => ['/post/index'], 'visible' => $permissions || app()->user->can('postIndex')],
                    ['label' => trans('words', 'Lists'), 'url' => ['/list/index'], 'visible' => $permissions || app()->user->can('listIndex')],
                ]
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-building"></i><span class="m-menu__link-text">' . trans('words', 'Project Management') . '</span>',
                'items' => [
                    ['label' => trans('words', 'Project Process'), 'url' => ['/process/index'], 'visible' => $permissions || app()->user->can('processIndex')],
                    ['label' => trans('words', 'Project Section'), 'url' => ['/section/index'], 'visible' => $permissions || app()->user->can('sectionIndex')],
                    ['label' => trans('words', 'Project Timeline'), 'url' => ['/timeline/index'], 'visible' => $permissions || app()->user->can('timelineIndex')],
                    ['label' => trans('words', 'Donation'), 'url' => ['/donation/index'], 'visible' => $permissions || app()->user->can('donationIndex')],
                    ['label' => trans('words', 'Material Assistance'), 'url' => ['/material/index'], 'visible' => $permissions || app()->user->can('materialIndex')],
                ]
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-th"></i><span class="m-menu__link-text">' . trans('words', 'Categories') . '</span>',
                'url' => ['/category/index'],
                'visible' => $permissions || app()->user->can('categoryIndex')
            ],

            [
                'label' => '<i class="m-menu__link-icon fa fa-images"></i><span class="m-menu__link-text">' . Yii::t('words', 'Gallery') . '</span>',
                'items' => [
                    ['label' => Yii::t('words', 'Picture Gallery'), 'url' => ['/gallery/index'], 'visible' => $permissions || Yii::$app->user->can('galleryIndex')],
                    ['label' => Yii::t('words', 'Video Gallery'), 'url' => ['/gallery/index-video'], 'visible' => $permissions || Yii::$app->user->can('galleryIndexVideo')],
                ]
            ],

            [
                'label' => '<i class="m-menu__link-icon fa fa-comments"></i><span class="m-menu__link-text">' . 'تماس با ما' . '</span>',
                'items' => [
                    ['label' => Yii::t('words', 'Messages'), 'url' => ['/message/index'], 'visible' => $permissions || Yii::$app->user->can('messageIndex')],
                    ['label' => Yii::t('words', 'Departments'), 'url' => ['/message/department'], 'visible' => $permissions || Yii::$app->user->can('messageDepartment')],
                ]
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-users"></i><span class="m-menu__link-text">کاربران</span>',
                'items' => [
                    ['label' => 'مدیریت کاربران', 'url' => ['/user/index'], 'visible' => $permissions || app()->user->can('userIndex')],
                    ['label' => 'افزودن کاربر', 'url' => ['/user/create'], 'visible' => $permissions || app()->user->can('userCreate')],
                    ['label' => 'مدیریت نقش های کاربری', 'url' => ['/role/index'], 'visible' => $permissions || app()->user->can('roleIndex')],
                ]
            ],

            [
                'label' => '<i class="m-menu__link-icon fa fa-language"></i><span class="m-menu__link-text">مدیریت ترجمه ها</span>',
                'url' => ['/admin/translate'],
                'visible' => $permissions || app()->user->can('adminTranslate')
            ],

            [
                'label' => '<i class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-text">' . trans('words', 'Setting') . '</span>',
                'url' => ['/setting/index'],
                'visible' => $permissions || app()->user->can('settingIndex')
            ],


            [
                'label' => '<i class="m-menu__link-icon flaticon-logout"></i><span class="m-menu__link-text text-danger">' . trans('words', 'Logout') . '</span>',
                'url' => ['/admin/logout'],
                'visible' => !app()->user->isGuest
            ],
            [
                'label' => '<i class="m-menu__link-icon flaticon-imac"></i><span class="m-menu__link-text">' . trans('words', 'Login') . '</span>',
                'url' => ['/admin/login'],
                'visible' => app()->user->isGuest
            ]
        ];
    }

    private function initializeRequirements()
    {
        $cache = app()->cache;

        // cache users
        $expire = 30 * 24 * 3600;

        // cache models
//        $cache->flush();
        $this->models = $cache->getOrSet('models', function () {
            $arr = [];
            foreach (Model::find()->all() as $model)
                $arr[$model->name] = $model->id;
            return $arr;
        }, $expire);

        // cache menus
        $this->menus = $cache->getOrSet('menus', function () {
            $arr = [];
            foreach (Menu::find()->valid()->all() as $menu)
                $arr[$menu->id] = $menu;
            return $arr;
        }, $expire);
    }

    /**
     * Default route for all controllers that use Crud Controller Trait
     *
     * @return array
     */
    public static function getRoutes()
    {
        return [
            static::AFTER_SAVE_ROUTE => 'index'
        ];
    }
}