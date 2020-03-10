<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-11-07
 * Time: 10:04
 */

namespace Inhere\Validate;

use InvalidArgumentException;

/**
 * Class AbstractValidation
 * @package Inhere\Validate
 */
abstract class AbstractValidation implements ValidationInterface
{
    use ValidationTrait {
        //set as traitSet;
        // Methods to define an alias, can be used in the current class.
        get as traitGet;
    }

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array  $data
     * @param array  $rules
     * @param array  $translates
     * @param string $scene
     * @param bool   $startValidate 立即开始验证
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        array $data = [],
        array $rules = [],
        array $translates = [],
        string $scene = '',
        bool $startValidate = false
    ) {
        $this->data = $data;
        $this
            ->atScene($scene)
            ->setRules($rules)
            ->setTranslates($translates);

        if ($startValidate) {
            $this->validate();
        }
    }

    /**
     * @param array  $data
     * @param string $scene
     * @param bool   $startValidate
     *
     * @return AbstractValidation
     */
    public static function quick(array $data, string $scene = '', bool $startValidate = false): AbstractValidation
    {
        return new static($data, [], [], $scene, $startValidate);
    }

    /**
     * @param array  $data
     * @param array  $rules
     * @param array  $translates
     * @param string $scene
     * @param bool   $startValidate 立即开始验证
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public static function make(
        array $data,
        array $rules = [],
        array $translates = [],
        string $scene = '',
        bool $startValidate = false
    ) {
        return new static($data, $rules, $translates, $scene, $startValidate);
    }

    /**
     * Create and start verification immediately
     *
     * @param array  $data
     * @param array  $rules
     * @param array  $translates
     * @param string $scene
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public static function makeAndValidate(array $data, array $rules = [], array $translates = [], string $scene = '')
    {
        return new static($data, $rules, $translates, $scene, true);
    }

    /**
     * Create and start verification immediately
     *
     * @param array  $data
     * @param array  $rules
     * @param array  $translates
     * @param string $scene
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public static function check(array $data, array $rules = [], array $translates = [], string $scene = '')
    {
        return new static($data, $rules, $translates, $scene, true);
    }
}
