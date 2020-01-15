<?php

namespace library\validation;

use Inhere\Validate\FieldValidation;

/**
 * xxx表单验证
 *
 * @author chenwei
 */
class MemberValidation extends FieldValidation
{
    // 验证规则
    public function rules(): array
    {
        return [
            // 必填并且 4 <= tagId <=567
            ['tagId', 'required|min:4|max:567', 'filter' => 'int'],

            // title 必填并且 length >= 40
            ['title', 'required|min:40', 'filter' => 'trim'],

            // 必填并且大于 0
            ['freeTime', 'required|number'],

            // 含有前置条件
            ['tagId', 'number', 'when' => function ($data) {
                return isset($data['status']) && $data['status'] > 2;
            }],

            // 在验证前会先过滤转换为 int。并且仅会在指明场景名为 'scene1' 时规则有效
            ['userId', 'number', 'on' => 'scene1', 'filter' => 'int'],
            ['username', 'string|min:6', 'on' => 'scene2', 'filter' => 'trim'],

            // 使用自定义正则表达式
            ['username', 'required|regexp' ,'/^[a-z]\w{2,12}$/'],

            // 自定义验证器，并指定当前规则的消息
            ['title', 'custom', 'msg' => '{attr} error msg!' ],

            // 直接使用闭包验证
            ['status', function ($status) {
                if (is_int($status) && $status > 3) {
                    return true;
                }
                return false;
            }],

            // 标记字段是安全可靠的 无需验证
            ['createdAt, updatedAt', 'safe'],
        ];
    }

    // 定义不同场景需要验证的字段。
    // 功能跟规则里的 'on' 类似，两者尽量不要同时使用，以免混淆。
    public function scenarios(): array
    {
        return [
            'create' => ['user', 'pwd', 'code'],
            'update' => ['user', 'pwd'],
        ];
    }

    // 定义字段翻译
    public function translates(): array
    {
        return [
            'userId' => '用户Id',
        ];
    }

    // 自定义验证器的提示消息, 默认消息请看 {@see ErrorMessageTrait::$messages}
    public function messages(): array
    {
        return [
            'required' => '{attr} 是必填项。',
            // 可以直接针对字段的某个规则进行消息定义
            'title.required' => 'O, 标题是必填项。are you known?',
        ];
    }

    // 添加一个验证器。必须返回一个布尔值标明验证失败或成功
    protected function customValidator($title)
    {
        // some logic ...
        // $this->getRaw('field'); 访问 data 数据

        return true; // Or false;
    }
}
