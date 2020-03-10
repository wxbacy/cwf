<?php

namespace basic\utils;

class ArrayUtils
{
    /**
     * 数组按pid实现树形分级结构
     *
     * @param array $array
     * @param string $idColumn
     * @param string $pidColumn
     * @param int $pid
     * @return array
     */
    public static function tree(array $array, $pid, $idColumn = 'id', $pidColumn = 'pid')
    {
        // 每次都声明一个新数组用来放子元素
        $tree = array();
        foreach ($array as $v) {
            // 匹配子记录
            if ($v[$pidColumn] == $pid) {
                // 递归获取子记录
                $v['children'] = self::tree($array, $v[$idColumn], $idColumn, $pidColumn);
                if ($v['children'] == null) {
                    // 如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                    unset($v['children']);
                }
                // 将记录存入新数组
                $tree[] = $v;
            }
        }

        return $tree;
    }
}