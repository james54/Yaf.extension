<?php

class Ke_init {

    static private $isInit = false;

    public static function init($app_name = null) {
        if(self::$isInit) {
            return false;
        }

        // 执行初始化操作
        self::$isInit = true;
        self::initBasicEnv();           // 初始化基础环境
        self::initAppEnv($app_name);    // 初始化App环境
        self::initYaf();                // 初始化Yaf框架
        self::initLog($app_name);       // 初始化日志库

        return Yaf_Application::app();
    }

    private static function initBasicEnv() {
        define('REQUEST_TIME_US', intval(microtime(true)*1000000));
        define('ROOT_PATH', dirname(PHP_PREFIX));
        define('CONF_PATH', ROOT_PATH.'/conf');
        define('DATA_PATH', ROOT_PATH.'/data');
        define('BIN_PATH', ROOT_PATH.'/php/bin');
        define('LOG_PATH', ROOT_PATH.'/log');
        define('APP_PATH', ROOT_PATH.'/app');
        define('TPL_PATH', ROOT_PATH.'/template');
        define('LIB_PATH', ROOT_PATH.'/php/phplib');
        define('WEB_ROOT', ROOT_PATH.'/webroot');
        define('PHP_EXEC', BIN_PATH.'/php');
        return true;
    }

    private static function initAppEnv($app_name = null) {
        if($app_name != null) {
            define('IS_ODP', true);
            define('MAIN_APP', $app_name);
        } else {
            define('IS_ODP', false);
            define('MAIN_APP', 'unknow-app');
        }
        define('APP', MAIN_APP)
        // 设置当前App
        require_once(LIB_PATH.'/ke/AppEnv.php');
        Ke_AppEnv::setCurrApp(APP);
        return true;
    }

    private static function initYaf() {
        require_once(LIB_PATH.'/ke/Conf.php');
        $yaf_conf = Ke_Conf::getConf('yaf');
        $yaf_conf['directory'] = Ke_AppEnv::getEnv('code');
        $app = new Yaf_Application(array('application'=>$yaf_conf));
        $app->getDispatcher()->catchException(true);
        return true;
    }

    private static function initLog($app_name) {

    }
}
