# cwf

![License](https://img.shields.io/packagist/l/inhere/php-validate.svg?style=flat-square)
![Php Version](https://img.shields.io/badge/php-%3E=7.1-brightgreen.svg?maxAge=2592000)

使用YAF搭建的一个简单框架。

- 使用composer进行依赖管理
- 引入[catfan/Medoo](https://medoo.lvtao.net/doc.php)作为ORM
- 引入[inhere/php-validate](https://github.com/inhere/php-validate)作为表单验证
- 引入[lcobucci/jwt](https://github.com/lcobucci/jwt) JWT的封装
- 引入[php-curl-class/php-curl-class](https://github.com/php-curl-class/php-curl-class) CURL的封装
- redis操作简易封装
- MQ操作简易封装
- 错误码规则定义
- yaf命令行模式示例
- 实现单元测试自动加载


### 需要额外安装的php扩展

yaf redis amqp。

### 安装依赖的composer包

```
composer install
```

### 代码层级

- 如果需要使用中间件，applications/xxx/Bootstrap中注册plugin类，plugin类里编写对应代码。
- 控制器层进行表单验证，调用service层的业务逻辑封装，json响应。
- service层文件夹划分模块，实现业务逻辑，调用dao数据对象和mq消息发送，dao层调用model、cache、http层。
- 根目录下的script里编写命令行执行的脚本，包括计划任务与、队列消费脚和其他守护进程任务或者数据处理脚本等。

### 错误码设计

六位数错误码，前两位表示所属模块，中间两位表示模块的一个业务子类，后两位表示子类里的一个具体错误。

