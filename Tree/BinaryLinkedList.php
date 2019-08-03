<?php
/**
 * 二叉链表  表示二叉树
 */

/**
 * Class BitNode
 * 二叉树结点 结构
 */
class BitNode {
    public $data = ''; // 数据域
    public $leftChild = null; // 指针域 指向左子树
    public $rightChild = null; // 指针域 指向右子树

    public function __construct($val = '')
    {
        $this->data = $val;
    }
}

/**
 * Class BinaryLinkedList
 * 二叉树
 */
class BinaryLinkedList {
    /**
     * @param $bitNode
     * 初始化创建一颗二叉树，使用前序遍历的方式创建
     */
    public function createBitTree(&$bitNode)
    {
        fwrite(STDOUT, '请输入值:');

        $c = rtrim(fgets(STDOUT), "\n");
        var_dump($c);
        if ($c == ' ') {
            $bitNode = null;
        } else {
            $newNode = new BitNode($c);
            $bitNode = $newNode;
            $this->createBitTree($bitNode->leftChild);
            $this->createBitTree($bitNode->rightChild);
        }
    }

    /**
     * 访问二叉树具体操作
     */
    public function visit($c, $level)
    {
        echo sprintf("%s 位于第 %d 层\n", $c, $level);
    }

    /**
     * @param BitNode $bitNode
     * @param $level
     * 前序遍历二叉树
     */
    public function preOrderTraverse($bitNode, $level)
    {
        if ($bitNode) {
            // 前序遍历
            $this->visit($bitNode->data, $level);
            $this->preOrderTraverse($bitNode->leftChild, $level+1);
            $this->preOrderTraverse($bitNode->rightChild, $level+1);

            // 中序遍历
//            $this->preOrderTraverse($bitNode->leftChild, $level+1);
//            $this->visit($bitNode->data, $level);
//            $this->preOrderTraverse($bitNode->rightChild, $level+1);

            // 后序遍历
//            $this->preOrderTraverse($bitNode->leftChild, $level+1);
//            $this->preOrderTraverse($bitNode->rightChild, $level+1);
//            $this->visit($bitNode->data, $level);
        }
    }
}

$node = null;
$binaryLinkedList = new BinaryLinkedList();
$binaryLinkedList->createBitTree($node);
var_dump($node);
// 遍历
$binaryLinkedList->preOrderTraverse($node, 1);
/**
 * 输入 A B C D E 空 空 空 空 空
A 位于第 1 层
B 位于第 2 层
C 位于第 3 层
D 位于第 4 层
E 位于第 5 层
 * 输出结果，所以是一个斜树，左斜树
 */

/**
 *  输入AB空D空空CE空空空
 *  这里输入的空格，在程序创建二叉树中，可以理解为，递归进入之后，需要满足c == ' '判断，退出该执行
 *  返回递归调用前一个函数中，会进入第二个递归调用，即创建右子树，所有如果没有右子树，需要一个 空 来退出
 *输出
A 位于第 1 层
B 位于第 2 层
D 位于第 3 层
C 位于第 2 层
E 位于第 3 层
 * 一共三层
 */