<?php
/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 *
 * @author chenwei
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initConfig()
    {
        // 把配置保存起来
        $appConfig = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $appConfig);
        $regexConfig = (new Yaf_Config_Ini(CONF_PATH . '/regex.ini'));
        Yaf_Registry::set('regex', $regexConfig);
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    {
        // 注册一个插件
        $authPlugin = new AuthPlugin();
        $dispatcher->registerPlugin($authPlugin);
    }

    public function _initView(Yaf_Dispatcher $dispatcher)
    {
        // 在这里注册自己的view控制器
        // 前后分离，不需要渲染页面
        $dispatcher->autoRender(false);
    }

    public function _initApplication()
    {
        // 定义当前所属应用
        Yaf_Registry::set('application', 'admin');
    }
}
