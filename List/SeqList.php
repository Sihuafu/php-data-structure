<?php
/**
 * 线性表 - 顺序存储结构
 * 存，读数据时，不管在哪个位置，时间复杂度都是O（1）
 * 插入，删除时候，复杂度都是O(n)
 */

define('MAX_SIZE', 5);

/**
 * Class ListNode
 * 定义一个线性表 的 顺序存储结构
 * 相比数组，就多了一个length属性，表示当前存储长度
 */
class ListNode {
    public $fixArr = []; // 存储空间的起始位置，也就是线性表的存储空间的存位置
    public $length = 0; // 当前线性表的长度

    public function __construct()
    {
        $this->fixArr = new SplFixedArray(MAX_SIZE);
    }
}

class SeqList {
    /**
     * @param ListNode $listNode
     * @param $i
     * @param $item
     * @return int
     * 返回线性表的第i个位置的元素，对于数组来说是 索引值是 i-1
     * O(1)
     */
    public function getItem(ListNode $listNode, $i, &$item)
    {
        if ($listNode->length==0 || MAX_SIZE<$i || $i<1) {
            return -1;
        }
        $item = $listNode->fixArr[$i-1];
        return 0;
    }

    /**
     * @param ListNode $listNode
     * @param $i
     * @param $item
     * @return int
     * 在第i个位置插入元素
     * O(n) / O(1)
     */
    public function insertItem(ListNode $listNode, $i, $item)
    {
        if ($listNode->length == MAX_SIZE) { // 顺序存储结构已满，不可以在添加
            return -1;
        }

        if ($i<1 || $i>$listNode->length + 1) { // 不再可插入范围
            return -1;
        }
        if ($i<=$listNode->length) { // 判断插入元素，不再表尾 O(n)
            for ($j=$listNode->length-1; $j>=$i-1; $j--) {
                $listNode->fixArr[$j+1] = $listNode->fixArr[$j];
            }
        }
        $listNode->fixArr[$i-1] = $item; // 插入新元素
        $listNode->length++;
        return 0;
    }

    /**
     * @param ListNode $listNode
     * @param $i
     * @param $item
     * @return int
     * 删除元素
     * O(n) / O(1)
     */
    public function delItem(ListNode $listNode, $i, &$item)
    {
        if ($listNode->length == 0) {
            return -1;
        }
        if ($i<1 || $i>$listNode->length) {
            return -1;
        }
        $item = $listNode->fixArr[$i-1]; // 获取要删除的元素
        if ($i <$listNode->length) { // 判断删除的元素，不是表尾 O(n)
            for ($j=$i; $j<$listNode->length; $j++) {
                $listNode->fixArr[$j-1] = $listNode->fixArr[$j];
            }
        }
        $listNode->length--;
        return 0;
    }
}

$listNode = new ListNode();
$seqList = new SeqList();
for ($i=0; $i<MAX_SIZE-2; $i++) {
    $seqList->insertItem($listNode, $i+1, $i);
}
$seqList->insertItem($listNode, 2, 'aa');
var_dump($listNode);