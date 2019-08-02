<?php
/**
 * 静态链表
 * 用数组，代替指针实现的链表 即静态链表
 * 这种描述方法叫做 游标实现法
 *
 * 设置数组为1000个元素，也就是0 到 999
 * 数组下标是0的元素，不存放任何数据，并且第一个元素的游标 指向 第一个没有存放数据元素的下标
 * 数组下标是maxSize - 1 的元素，不存放数据，并且这个最后一个元素的游标 指向 第一个有数据的元素的下标，相当于 单链表中的 头结点
 * 其他的元素的游标都是 指向 它的下一个元素的下标 ，类似于单链表的指针
 * 最后一个有数据的元素的游标是0 ,因为静态链表的长度是固定的，要求最后一个元素且有数据的元素的游标是0，表示 最后获取空闲游标的时候，会返回一个0。表示不可在添加
 */
define('MAX_SIZE', 5);
class ListNode {
    /**
     * @var SplFixedArray|null
     *
     */
    public $data = ''; // 数据
    public $cur = null; // 游标

    public function __construct()
    {

    }
}

class StaticLinkedList {
    /**
     * @param SplFixedArray $fixedArr
     * @return int
     * 静态链表 初始化
     * 因为 使用一个数组来描述链表，所以将数组的每个元素保存成一个结点，类似于c中的static结构体。这个结点中包含来数据元素的值以及游标
     */
    /**
     * 结果
     *  游标：  1  2   3   4   0
     *  下标：  0  1   2   3   4
     */
    public function initList(SplFixedArray $fixedArr)
    {
        // 因为最后一个元素，不存储数据，所以i < MAX_SIZE - 1
        for ($i=0; $i<MAX_SIZE-1; $i++) {
            $node = new ListNode();
            $node->cur = $i+1;
            $fixedArr[$i] = $node;
        }
        $node = new ListNode();
        $node->cur = 0;
        $fixedArr[MAX_SIZE-1] = $node;
        return 0;
    }

    /**
     * @param SplFixedArray $fixedArr
     * @return mixed
     * 获取数组中空闲的位置下标
     * 在初始化之后，第一次获取空闲的$i=1，然后将第一个位置的游标指向下标是1的游标，即2
     */
    public function getFreeIndex(SplFixedArray $fixedArr)
    {
        $i = $fixedArr[0]->cur; // 获取第一个位置的下标，因为第一个元素的游标 指向 第一个没有存放数据元素的下标
        if ($fixedArr[0]->cur) {
            $fixedArr[0]->cur = $fixedArr[$i]->cur; // 获取第一个没有数据位置的游标，即应该是第二个空闲位置的下标。赋值给第一个元素的游标
        }
        return $i; // 返回这个空闲游标，用于插入
    }

    /**
     * @param SplFixedArray $fixedArr
     * @param $i
     * 在哪个位置插入，当对于有数据的位置
     * @param $data
     * @return int
     * 插入元素
     */
    public function insertItem(SplFixedArray $fixedArr, $i, $data)
    {
        $k = MAX_SIZE - 1; // 最后一个元素
        if ($i<1 || $i>$this->getLength($fixedArr)+1) {
            return -1;
        }
        $j = $this->getFreeIndex($fixedArr); // 获取空闲下标，第一个获取的时候，应该是1
        if ($j) {
            $node = new ListNode();
            $node->data = $data; // 赋值数据
            $fixedArr[$j] = $node; // 在空闲位置，插入数据
            for ($l = 1; $l<=$i-1; $l++) {
                // 如果i=1表示第一次插入，则不进入此循环，最终会将第一个有值的位置的cur设置为0
                // 如果i=2表示第二次插入，进入此循环，也就是类似于头结点指针，找到插入位置之前的位置，即i-1位置
                $k = $fixedArr[$k]->cur;
            }
            //
            $fixedArr[$j]->cur = $fixedArr[$k]->cur; // 设置插入位置的游标，保持为0
            $fixedArr[$k]->cur = $j; // 设置插入位置 之前 位置 的游标 为当前插入位置的下标
        }
        return 0;
    }

    /**
     * @param SplFixedArray $fixedArr
     * @param $i
     * @return int
     * 删除元素
     */
    public function delItem(SplFixedArray $fixedArr, $i)
    {
        // 比如删除i=3的元素。也就是第三个元素
        // 需要将第二个元素的游标指向第四个元素的下标
        if ($i<1 || $i>$this->getLength($fixedArr)) {
            return -1;
        }
        $k = MAX_SIZE - 1;
        for ($j = 1; $j<=$i-1; $j++) {
            $k = $fixedArr[$k]->cur; // 找到删除位置的前一个位置的下标
        }
        $j = $fixedArr[$k]->cur; // 将删除位置的下标赋值给j
        $fixedArr[$k]->cur = $fixedArr[$j]->cur; // 将删除位置的游标赋值给前一个位置的游标
        // 释放
        $this->free($fixedArr, $j);
        return 0;
    }

    /**
     * @param SplFixedArray $splFixedArr
     * @param $k
     * 将下标为k的空闲结点收回到备用链表
     */
    public function free(SplFixedArray $splFixedArr, $k)
    {
        // 当前空闲位置为第一个空闲位置，所以它的游标，应该指向第二个空闲位置的下标，也就是目前第一个位置的游标.
        $splFixedArr[$k]->cur = $splFixedArr[0]->cur;
        // 因为 第一个元素的游标 指向 第一个没有存放数据元素的下标。所以赋值
        $splFixedArr[0]->cur = $k;
    }

    /**
     * @param SplFixedArray $splFixedArr
     * @return int
     * 返回静态链表的长度
     */
    public function getLength(SplFixedArray $splFixedArr)
    {
        $i = $splFixedArr[MAX_SIZE-1]->cur;
        $j = 0;
        while ($i) {
            $i = $splFixedArr[$i]->cur;
            $j++;
        }
        return $j;
    }
}

$fixedArr = new SplFixedArray(MAX_SIZE);
$staticLinkedList = new StaticLinkedList();
$staticLinkedList->initList($fixedArr);

$res = $staticLinkedList->insertItem($fixedArr, 1, 10);
$res = $staticLinkedList->insertItem($fixedArr, 2, 20);
var_dump($res);
var_dump($fixedArr);