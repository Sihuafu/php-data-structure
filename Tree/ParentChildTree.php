<?php
/**
 * 树的表示方式 - 双亲双子表示法
 * 首先申请一块连续的内存空间，用来存储树结构数据
 * 在申请的空间中存储一个$root 表示跟结点下标，$num表示当前结点总数，$fixArr 用来存储各个树结点
 * 定义树结点结构，包含$data 表示结点值，$parent 表示双亲结点的下标 $firstChild 指向子结点链表的指针
 * 定义子结点组成的单链表结点结构，包含一个$child和一个 指向下一个结点的指针
 */

define('MAX_TREE_SIZE', 10);

/**
 * 单链表存储子结点
 */
class ChildNode {
    public $child = ''; // 子结点的下标
    public $next = null; // 指向下一个子结点的指针
}

/**
 * Class TreeNode树结点
 */
class TreeNode {
    public $data = ''; // 结点的值
    public $parent = -1; // 双亲结点的下标
    public $firstChild = null; // 指向子结点链表的第一个结点
}

/**
 * Class ParentChildTree
 * 树结构
 */
class ParentChildTree {
    public $fixArr = []; // 表示存储树结构，申请的连续内存空间
    public $root = 0; // 跟结点的下标
    public $num = 0; // 结点的总数

    public function __construct()
    {
        $this->fixArr = new SplFixedArray(MAX_TREE_SIZE);
    }
}