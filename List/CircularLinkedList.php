<?php
/**
 * 循环链表
 * 将单链表的最后一个结点指针为空，改为指向头结点
 * 循环链表的空则是 head->next = head
 * todo
 */
class ListNode {
    public $next = null;
    public $data = '';
}
class CircularLinkedList {
    /**
     * @param $listNode
     * 指向链表的第一个结点
     * @param array $arr
     */
    public function init($listNode, array $arr)
    {
        $j = 0;
        $count = count($arr);
        if ($count == 0) {
            return;
        }
        while ($j<$count) {
            if ($listNode->next == null) { // 链表为空
                $node = new ListNode();
                $node->data = $arr[$j];
                $node->next = $listNode;
            } else {

            }
            $j++;
        }
    }
}

$node = new ListNode();
$circularLinkedList = new CircularLinkedList();
$circularLinkedList->init($node, [11, 13, 54, 55, 78]);
var_dump($node);