<?php

class Sort
{
    /**
     * 冒泡排序
     *
     * @param  array $value 待排序数组
     * @return array
     */
    public function bubble($value = [])
    {
        $length = count($value) - 1;
        // 外循环
        for ($j = 0; $j < $length; $j++) {
            // 内循环
            for ($i = 0; $i < $length-$j; $i++) {
                // 如果后一个值小于前一个值，则互换位置
                if ($value[$i + 1] < $value[$i]) {
                    $tmp = $value[$i + 1];
                    $value[$i + 1] = $value[$i];
                    $value[$i] = $tmp;
                }
            }
        }

        return $value;
    }

    /**
     * 优化冒泡排序
     *
     * @param  array $value 待排序数组
     * @return array
     */
    public function bubble_better($value = [])
    {
        $flag = true; // 标示 排序未完成
        $length = count($value) - 1; // 数组长度
        $index = $length; // 最后一次交换的索引位置 初始值为最后一位
        while ($flag) {
            $flag = false; // 假设排序已完成
            $last = 0;
            for ($i = 0; $i < $index; $i++) {
                if ($value[$i] > $value[$i + 1]) {
                    $flag = true; // 如果还有交换发生 则排序未完成
                    $last = $i; // 记录最后一次发生交换的索引位置
                    $tmp = $value[$i];
                    $value[$i] = $value[$i + 1];
                    $value[$i + 1] = $tmp;
                }
            }
            $index = $last;
        }

        return $value;
    }

    /**
     * 堆排序.
     *
     * @param array $value 待排序数组
     * @return array
     */
    public function heap(&$values = [])
    {
        //堆化数组
        $heap = [];
        foreach ($values as $i=>$v) {
            $heap[$i] = $v;
            $heap = $this->minHeapFixUp($heap, $i);
        }
        $values = $heap;

        //堆排序
        $n = count($values);
        for ($i = $n-1; $i>=1; $i--) {
            $this->swap($values[$i], $values[0]);
            $this->minHeapFixDown($values, 0, $i);
        }
        return $values;
    }

    public function swap(&$a, &$b) {
        $temp = $a;
        $a= $b;
        $b = $temp;
    }

    /**
     * 堆插入数据
     * @param $values
     * @param $i
     * @return mixed
     */
     public function minHeapFixUp($values, $i) {

        $j = ($i-1)/2;
        $temp = $values[$i];

        while($j >= 0 && $i != 0) {

            if($values[$j] <= $temp) {
                break;
            }
            $values[$i] = $values[$j];
            $i = $j;
            $j = ($i-1)/2;
        }
        $values[$i] = $temp;
        return $values;
    }

    /**
     * 调整堆,可用于删除堆节点
     * @param $heap
     * @param $i
     * @param $n
     */
    public function minHeapFixDown(&$heap, $i, $n) {
        $j = 2*$i + 1;
        $temp = $heap[$i];

        while ($j < $n) {
            if($j+1 <$n && $heap[$j+1] < $heap[$j]) {
                $j++;
            }
            if($heap[$j] >= $temp) {
                break;
            }
            $heap[$i] = $heap[$j];
            $i = $j;
            $j = 2*$i + 1;
        }
        $heap[$i] = $temp;
    }

    /**
     * 插入排序.
     *
     * @param  array   $value 待排序数组
     * @param  integer $point 起始位置
     *
     * @return array
     */
    public function insert(&$value=[], $point=0)
    {
        if ($point >= count($value) - 1) {
            return;
        }
        $next  = $value[$point + 1]; // 下一个待插入值
        // 从后向前遍历已排序数组
        for ($i=$point; $i >= 0; --$i) {
            // 如果当前已排序值大于 待插入值
            // 把当前值后往后移动一位
            // 继续向前遍历
            if ($value[$i] > $next) {
                $value[$i+1] = $value[$i];
                // 如果到开头，自动到插入头位
                if ($i === 0) {
                    $value[$i] = $next;
                    break;
                }
                continue;
            }
            // 如果，当前已排序值小于或等于 待插入值
            // 则，在当前值后插入 当前待插入值
            // 特殊：如果末尾值小于或等于待插入值 则当前值后插入本身
            $value[$i+1] = $next;
            break;
        }
        $point += 1;// 已排序末尾位置
        // 递归
        $this->insert($value, $point);

        return $value;
    }

    /**
     * 插入排序 for循环版
     *
     * @param array $value 待排序数组
     *
     * @return array
     */
    public function insert_for($arr=array())
    {
        $len = count($arr);
        for($i = 1; $i < $len; $i++) {
            $base = $arr[$i];
            for($j = $i - 1; $j >= 0; $j--) {
                if ($base < $arr[$j]) {
                    $arr[$j + 1] = $arr[$j];
                    if ($j === 0) {
                        $arr[$j] = $base;
                        break;
                    }
                    continue;
                }
                $arr[$j + 1] = $base;
                break;
            }
        }
        return $arr;
    }

    /**
     *	插入排序
     *	在要排序的一组数中，假设前面的数已经是排好顺序的，现在要把第n个数插到前面的有序数中，使得这n个数也是排好顺序的。如此反复循环，直到全部排好顺序。
     */
    public function insertSort($arr) {
        $len=count($arr);
        //这个元素 就是从第二个元素开始，到最后一个元素都是这个需要排序的元素
        for($i=1;$i<$len; $i++) {
            $tmp = $arr[$i];
            //内层循环控制，比较并插入
            for($j=$i-1;$j>=0;$j--) {
                if($tmp < $arr[$j]) {
                    //发现插入的元素要小，交换位置，将后边的元素与前面的元素互换
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $tmp;
                } else {
                    //如果碰到不需要移动的元素，由于是已经排序好是数组，则前面的就不需要再次比较了。
                    break;
                }
            }
        }
        return $arr;
    }

    /**
     * 快速排序.
     *
     * @param  array $value 待排序数组
     * @param  array $left  左边界
     * @param  array $right 右边界
     *
     * @return array
     */
    public function quick(&$value, $left, $right)
    {
        // 左右界重合 跳出
        if ($left >= $right) {
            return;
        }
        $base = $left;
        do {
            // 从最右边开始找到第一个比基准小的值，互换位置
            // 找到基准索引为止
            for ($i=$right; $i > $base; --$i) {
                if ($value[$i] < $value[$base]) {
                    $tmp = $value[$i];
                    $value[$i] = $value[$base];
                    $value[$base] = $tmp;
                    $base = $i; // 更新基准值索引
                    break;
                }
            }

            // 从最左边开始找到第一个比基准大的值，互换位置
            // 找到基准索引为止
            for ($j=$left; $j < $base; ++$j) {
                if ($value[$j] > $value[$base]) {
                    $tmp = $value[$j];
                    $value[$j] = $value[$base];
                    $value[$base] = $tmp;
                    $base = $j; // 更新基准值索引
                    break;
                }
            }
        } while ($i > $j);// 直到左右索引重合为止

        // 开始递归
        // 以当前索引为分界
        // 开始排序左部分
        $this->quick($value, $left, $i-1);
        // 开始排序右边部分
        $this->quick($value, $i+1, $right);

        return $value;
    }

    /**
     * 快速排序.while版本
     *
     * @param  array $value 待排序数组
     * @param  array $left  左边界
     * @param  array $right 右边界
     *
     * @return array
     */
    public function quick_while(&$value, $left, $right)
    {
        // 左右界重合 跳出
        if ($left >= $right) {
            return;
        }

        $point = $left;
        $i = $right;
        $j = $left;
        while ($i > $j) {
            //查右边值
            while ($i > $point) {
                if ($value[$i] < $value[$point]) {
                    $tmp = $value[$i];
                    $value[$i] = $value[$point];
                    $value[$point] = $tmp;
                    $point = $i;
                    break;
                }
                --$i;
            }

            //查左边值
            while ($j < $point) {
                if ($value[$j] > $value[$point]) {
                    $tmp = $value[$j];
                    $value[$j] = $value[$point];
                    $value[$point] = $tmp;
                    $point = $j;
                    break;
                }
                ++$j;
            }
        }

        // 开始递归
        // 以当前索引为分界
        // 开始排序左部分
        $this->quick_while($value, $left, $i-1);
        // 开始排序右边部分
        $this->quick_while($value, $i+1, $right);

        return $value;
    }

    /**
     * 选择排序.
     *
     * @param  array $value 待排序数组
     *
     * @return array
     */
    public function select_sort(&$value=[])
    {
        $length = count($value)-1;
        for ($i=0; $i < $length; $i++) {
            $point = $i;// 最小值索引
            for ($j=$i+1; $j <= $length; $j++) {
                if ($value[$point] > $value[$j]) {
                    $point = $j;
                }
            }
            $tmp = $value[$i];
            $value[$i] = $value[$point];
            $value[$point] = $tmp;
        }
        return $value;
    }
}

$sort = new Sort;
//print_r($sort->bubble([1,5,2,3,8,9,20,9,30]));
//print_r($sort->bubble_better([1,500,2,3,8,9,20,9,30,1,4,5,6,100]));
//print_r($sort->a([1,500,2,3,8,9,20,9,30,1,4,5,6,100]));
$a = [1,500,2,3,8,9,20,9,30,1,4,5,6,100];
//print_r($sort->heap($a));
//print_r($sort->insert($a));
print_r($sort->insertSort($a));