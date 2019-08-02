<?php
/**
 * 单链表 模拟 一个struc结构，包含一个数据域和一个指针域
 */
class ListNode {
    public $data = null; // 数据域
    public $next = null; // 指针域

    public function __construct($val = null)
    {
        $this->data = $val;
    }
}

class SingleLinkedList {
    /**
     * @param ListNode $listNode
     * @param $n
     * @return int
     * 尾查法 创建单链表 => 正序
     * head -> null
     * head -> node1 -> null
     * head ->node1->node2 -> null
     */
    public function createListTail(ListNode $listNode, $n)
    {
        $r = $listNode; // 初始状态 $r 是头结点，也是最后一个结点。此处表示最后一个结点
        for ($i=0; $i<$n; $i++) {
            $p = new ListNode($i); //生成新结点
            $r->next = $p; // 最后一个结点的指针，指向新结点
            $r = $p;       // 新结点，作为最后一个结点
        }
        return 0;
    }
    /**
     * @param ListNode $listNode
     * @param $n
     * @return int
     * 头插法 创建单链表 => 逆序
     */
    public function createListHead(ListNode $listNode, $n)
    {
        for ($i=0; $i<$n; $i++) {
            $p = new ListNode($i); // 生成新结点
            $p->next = $listNode->next; // 将新结点的指针 指向 头结点的指针所指向的内容
            $listNode->next = $p;       // 将头结点的指针 指向 新结点
        }
        return 0;
    }
    /**
     * @param ListNode $listNode，链表的第一个结点，头结点
     * @param $i
     * @param $item
     * @return int
     * 获取第i个元素
     */
    public function getItem(ListNode $listNode, $i, &$item)
    {
        $j=1;
        $p = $listNode->next; // 获取链表的第一个结点
        while ($p && $j<$i) { // 直到$p=null或者找到$i-1位置的时候，找到结点
            $p = $p->next;
            ++$j;
        }
        if (!$p || $j>$i) {
            return -1;
        }
        $item = $p->data;
        return 0;
    }

    /**
     * @param ListNode $listNode
     * @param $i
     * @param $item
     * @return int
     * 插入元素
     */
    public function InsertItem(ListNode $listNode, $i, $item)
    {
        $j = 1;
        $p = $listNode;
        while ($p && $j<$i) { // 先找到要插入的位置
            $p = $p->next;
            $j++;
        }

        if (!$p || $j>$i) {
            return -1;
        }
        $newNode = new ListNode($item); // 生成新结点，并赋值插入的数据
        $newNode->next = $p->next;
        $p->next = $newNode;
        return 0;
    }

    /**
     * @param ListNode $listNode
     * @param $i
     * @param $item
     * @return int
     * 删除元素
     */
    public function delItem(ListNode $listNode, $i, &$item)
    {
        $j = 1;
        $p = $listNode;
        while ($p && $j<$i) { // 先找到要插入的位置
            $p = $p->next;
            $j++;
        }
        if (!$p || $j>$i) {
            return -1;
        }
        $q = $p->next;
        $item = $q->data;
        $p->next = $q->next;
        unset($q);
        return 0;
    }

    /**
     * @param ListNode $listNode
     * @return int
     * 整表删除
     */
    public function clearList(ListNode $listNode)
    {
        $p = $listNode->next; // 获得第一个结点
//        $m = memory_get_usage();
//        var_dump($m); // 407840
        while ($p) {
            $q = $p->next;
            unset($p); // 逐步释放掉，也就是引用-1
            $p = $q;
        }
        $listNode->next = null; // 最后设置单链表为空表
        return 0;
//        $m = memory_get_usage();
//        var_dump($m);exit; // 当执行了上边的while循环unset之后：399872, 如果没有经过上面的while：407608
    }
}

$singleLinkedList = new SingleLinkedList();
/**
$node =new ListNode();
$res = $singleLinkedList->createListHead($node, 4);
var_dump($node);

object(ListNode)#2 (2) {
["data"]=>
NULL
["next"]=>
object(ListNode)#6 (2) {
["data"]=>
int(3)
["next"]=>
object(ListNode)#5 (2) {
["data"]=>
int(2)
["next"]=>
object(ListNode)#4 (2) {
["data"]=>
int(1)
["next"]=>
object(ListNode)#3 (2) {
["data"]=>
int(0)
["next"]=>
NULL
}
}
}
}
}
 */

/**
$node =new ListNode();
$res = $singleLinkedList->createListTail($node, 4);
var_dump($node);
object(ListNode)#2 (2) {
["data"]=>
NULL
["next"]=>
object(ListNode)#3 (2) {
["data"]=>
int(0)
["next"]=>
object(ListNode)#4 (2) {
["data"]=>
int(1)
["next"]=>
object(ListNode)#5 (2) {
["data"]=>
int(2)
["next"]=>
object(ListNode)#6 (2) {
["data"]=>
int(3)
["next"]=>
NULL
}
}
}
}
}
*/
$node =new ListNode();
$res = $singleLinkedList->createListTail($node, 4);
$singleLinkedList->InsertItem($node, 2, 'aaa');
$singleLinkedList->delItem($node, 2, $item);
//$singleLinkedList->clearList($node);
var_dump($node);