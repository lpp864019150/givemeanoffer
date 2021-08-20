<?php
class Algorithm
{
    public static function test($sort = 'bubble')
    {
        $arr = [45, 20, 45, 93, 67, 10, 97, 52, 88, 33, 92, 45];

        $maps = [
            'bubble' => 'bubbleSort',
            'insert' => 'insertSort',
            'select' => 'selectSort',
            'quick' => 'quickSort',
        ];
        $method = $maps[$sort] ?? 'bubbleSort';

        echo 'run ' . $method . PHP_EOL;
        $r = call_user_func_array(['static', $method], [$arr]);

        //sort($arr);
        echo json_encode($r) . PHP_EOL;
    }

    /**
     * bubbleSort 冒泡排序
     * 冒泡排序只会操作相邻的两个数据，每次冒泡都对相邻的两个数据进行比较，不满足大小的要求那么就互换位置。所以一次冒泡排序就能让一个元素移到它应该存在的位置。
     * 重复n次，就完成了排序。
     * @author pp 2021-08-11
     * @param array $arr
     * @return array
     */
    public static function bubbleSort(array $arr) : array
    {
        $len = count($arr);
        if ($len <= 1) return $arr;

        $times = 0;
        // 1. 需要 n-1 次尝试
        for ($i = 1; $i < $len; $i++) {
            $switch = false;
            // 2. 每次从最左开始，左右相邻进行比对，每趟比对次数为 n-i(第几趟)，也即每趟可以确定一个最大值，则相应的少比对一次
            for ($j = 0; $j < $len - $i; $j++) {
                $times++;
                // 2.1. 若左边比右边大，则交换位置，位移+1，进行比对
                if ($arr[$j] > $arr[$j+1]) {
                    $t = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $t;

                    // 3. 若当前趟有交换则代表当前排序仍未排好序
                    $switch = true;
                }
            }

            // 3.1. 若当前趟未发生交换位置，则代表为最终态
            if (!$switch) break;
        }

        echo "Total Comparisons: ".$times . "\n";

        return $arr;
    }

    /**
     * insertSort 插入排序
     * 插入排序把数据分成了两个区，左边有序区和右边无序区。
     * 每次从无序区中取出一个数，插入到对应有序区的位置。并且保证有序区的元素一直都是有序的。初始化的时候数组的第一个元素就是有序区。
     * 插入排序也需要比较元素的大小以及对应的元素的移动。
     * 当我们拿到一个未排序区的数据和已排序区进行比较，找到合适的位置插入之后，我们还需要把插入点之后的位置全部往后面移动一位，给他腾出位置插入。
     * 插入排序和冒泡排序一样，是稳定的排序，同时它的最坏情况倒序下，时间复杂度也是O(n2)。（插入排序还可以进行优化）
     * @author pp 2021-08-11
     * @param array $arr
     * @return array
     */
    public static function insertSort(array $arr) : array
    {
        $len = count($arr);
        if ($len <= 1) return $arr;

        // 1. 默认左侧是已经排好序，从第2位开始进行插入操作
        for ($i = 1; $i < $len; $i++) {
            $k = $arr[$i];

            // 2. 从目标位开始往前进行比对，若大于目标数，则往后移动，否则目标数插入

            // 2.1. 使用for进行循环，从右往左逐个比对，最左位为0
            /*for ($j = $i - 1; $j >= 0; $j--) {
                if ($arr[$j] > $k) {
                    $arr[$j + 1] = $arr[$j];
                } else break;
            }*/

            // 2.2. 使用while进行循环，从右往左逐个比对，最左位为0
            $j = $i - 1;
            while ($j >= 0 && $arr[$j] > $k) {
                $arr[$j + 1] = $arr[$j];
                $j++;
            }

            // 3. 没有比目标数更大的，则腾出来的位置，插入目标数字，空位在位移后面
            $arr[$j + 1] = $k;
        }

        return $arr;
    }

    /**
     * selectSort 选择排序，与冒泡相反，每趟找最小，从左侧开始放置
     * 选择排序和插入排序一样，也区分有序区和无序区，只是选择排序每次是从无序区中拿出一个最小的数，插入到已排序区间的末尾。
     * 值得注意的是选择排序不是一个稳定的排序。选择排序每次都要找剩余未排序元素的最小值，并和前面的数据互换位置，这就破坏了稳定性。
     * @author pp 2021-08-11
     * @param array $arr
     * @return array
     */
    public static function selectSort(array $arr) : array
    {
        $len = count($arr);
        if ($len <= 1) return $arr;

        // 1. 需要 n-1 趟尝试，从当前位移开始，逐个往右
        for ($i = 0; $i < $len - 1; $i++) {
            // 2. 从已排好序的位置开始往后找最小值，一直到最右
            $m = $i;
            for ($j = $i + 1; $j < $len; $j++) {
                if ($arr[$j] < $arr[$m]) {
                    $m = $j;
                }
            }

            // 3. 若最小值非当前位置，则交换位置
            if ($i != $m) {
                $t = $arr[$i];
                $arr[$i] = $arr[$m];
                $arr[$m] = $t;
            }
        }

        return $arr;
    }

    /**
     * quickSort 快速排序
     * 分治思维
     * 快速排序的思想是，如果我们要排序p到r之间的一组数据，我们选择p到r之间的任意一个数作为分区点q，然后遍历p到r之间的数，
     * 只要是小于分区点的放在它的左边，大于分区点的放在右边。这样的话，数组p到r就分成了三个部分，小于分区点的，分区点，以及大于分区点的。
     * 所以我们可以利用递归的思想，排序下标p到q-1,q+1到r之间的数据，直到区间缩小成1的时候，说明此时整个数组都是有序的。
     * @author pp 2021-08-11
     * @param array $arr
     * @return array
     */
    public static function quickSort(array $arr) : array
    {
        $len = count($arr);
        if ($len <= 1) return $arr;

        self::_quickSort($arr, 0, $len - 1);
        //self::_quickSort2($arr, 0, $len - 1);

        return $arr;
    }

    public static function _quickSort(array &$arr, int $l, int $r)
    {
        // 边界，递归必须有边界
        if ($l >= $r) return;

        // 以point为基准点，划分左右两半，左边都是小于point，右边都是大于point
        $point = $arr[$r];
        $j = $l;
        for ($i = $l; $i < $r; $i++) {
            if ($arr[$i] < $point) {
                $t = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $t;
                $j++;
            }
        }

        // point放在数组的中间位置
        $t = $arr[$j];
        $arr[$j] = $point;
        $arr[$r] = $t;

        self::_quickSort($arr, $l, $j - 1);
        self::_quickSort($arr, $j + 1, $r);
    }

    public static function _quickSort2(array &$arr, int $l, int $r)
    {
        // 边界，递归必须有边界
        if ($l >= $r) return;

        // 随机取一个值作为基准，从左开始找大于，从右开始找小于
        //$pivot = $arr[mt_rand($p, $r)];
        $pivot = $arr[$l];
        $i = $l - 1;
        $j = $r + 1;
        while (true) {
            // 从左往右开始找不小于的(大于或者等于)，需要挪到右侧
            do {
                $i++;
            } while ($arr[$i] < $pivot && $arr[$i] != $pivot);

            // 从右往左开始找不大于的(小于或者等于)，需要挪到左侧
            do {
                $j--;
            } while ($arr[$j] > $pivot && $arr[$j] != $pivot);

            // 进行交换
            if ($i < $j) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$j];
                $arr[$j] = $temp;

            } else {
                break;
            }
        }

        // 中间点重新排序
        self::_quickSort2($arr, $l, $j);
        self::_quickSort2($arr, $j + 1, $r);
    }
}

// test
Algorithm::test($argv[1]);

// php yii algorithm.php sort
// sort为排序算法
