<?php
/**
 * 双向链表
 */
class ListNode {
    public $data = '';
    public $prior = null; // 指向前面的结点
    public $next = null; // 指向后边的结点
}

class TwoWayLinkedList {
    /**
     * @param $node
     * @return int
     * 初始化
     */
    public function init(&$node)
    {
        $node = new ListNode();
        $p = $node; // 生成一个头结点
        for ($i=0; $i<5; $i++) { // 生成5个结点
            $q = new ListNode();
            $q->data = chr(ord('A') + $i);
            $q->prior = $p;
            $q->next = $p->next;
            $p->next = $q;
            $p = $q;
        }
        return 0;
    }

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
}

$list = new TwoWayLinkedList();
$list->init($node);
$list->getItem($node, 3, $item);
var_dump($item);
var_dump($node);
