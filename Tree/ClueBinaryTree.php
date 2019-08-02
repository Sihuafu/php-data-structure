<?php
/**
 * 线索二叉树
 * 在二叉链表表示二叉树的基础上，在二叉树结点的结构体中，加入ltag,rtag标识
 */

/**
 * Class BitNode
 * 二叉树结点 结构
 */
class BitNode {
    public $data = ''; // 数据域
    public $leftChild = null; // 指针域 指向左子树
    public $rightChild = null; // 指针域 指向右子树
    public $ltag; // 当$ltag=0的时候，$leftChild指向左子树，当$ltag=1的时候，$leftChild指向该结点的前躯
    public $rtag;// 当$rtag=0的时候，$rightChild指向右子树，当$rtag=1的时候，$rightChild指向该结点的后继

    public function __construct($val = '')
    {
        $this->data = $val;
    }
}