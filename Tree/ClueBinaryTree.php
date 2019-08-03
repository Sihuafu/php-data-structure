<?php
/**
 * 线索二叉树
 * 在二叉链表表示二叉树的基础上，在二叉树结点的结构体中，加入ltag,rtag标识
 */

/**
 * Class BitNode
 * 线索二叉树结点 结构 BitNode
 */
//class Enums {
//    public static $childTree = 1;
//    public static $thread = 0;
//}
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

class ClueBinaryTree {
    // 始终指向刚刚访问过的结点
    // 在对创建好的二叉树进行线索化的时候，需要用到，即，判断某个结点的左子树为空的时候，需要用此变量记录上一个访问过的结点，
    // 然后将此变量赋值给该左子树为空的结点的$leftChild值，同时修改ltag=0。表示当前$leftChild指向的是它的前驱结点
    public $preNode = null;

    /**
     * @param $bitNode
     * 前序遍历创建二叉树
     * 因为这个参数bitNode在传递的过程中，是null，通过使用引用传递的方式，实现一个指针效果
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
            // 默认该结点是有左右子树
            // 创建完成之后（前序遍历创建），在通过中序遍历修改
            $newNode->ltag = 1;
            $newNode->rtag = 1;
            $bitNode = $newNode;
            // 递归调用 创建 左子树，右子树
            $this->createBitTree($bitNode->leftChild);
            $this->createBitTree($bitNode->rightChild);
        }
    }

    /**
     * @param $bitNode
     * 中序遍历线索化
     */
    public function inOrderThroughForClue($bitNode)
    {
        if ($bitNode) { // 若非空树
            // 由于是中序遍历，所以先左子树，再根结点，最后右子树的顺序进行

            // 递归左子树线索化
            // 此次递归调用，会一直递归调用下去，直到最后一个，理解为最左下的一个结点
            $this->inOrderThroughForClue($bitNode->leftChild);
            // 结点处理
            // 代码进行到此处，说明当前递归深度已经遍历完所有的左子树，并且到达 最左的一个结点
            // 它的左子树为空
            if (!$bitNode->leftChild) { // 左子树为空，则需要将ltag标记改为0，并设置一个前驱指针
                $bitNode->ltag = 0;
                $bitNode->leftChild = $this->preNode;
            }
            if ($this->preNode && !$this->preNode->rightChild) { // 如果上一个结点右子树 为空。则将rtag设置为0，rightChild指向的应该是该结点
                $this->preNode->rtag = 0;
                $this->preNode->rightChild = $bitNode;
            }
            $this->preNode = $bitNode;
            $this->inOrderThroughForClue($bitNode->rightChild); // 递归y右子树线索化
        }

    }

    /**
     * @param $bitNode
     * @param $node
     * 线索初始化，也即是让preNode变量有一个初始值，从根结点开始
     */
    public function inOrderClueNode($bitNode, &$node)
    {
        // 生成一个node作为根结点
        $node = new BitNode();
        $node->ltag = 1;
        $node->rtag = 0;
        // 初始时，rtag设置为0，rightChild指向后继结点，即自身
        $node->rightChild = $node;
        if (!$bitNode) { // 如果传入进来的结点是null，则
            $node->leftChild = $node;
            $node->ltag = 0;
        } else {
            $node->leftChild = $bitNode;
            $this->preNode = $node;
            $this->inOrderThroughForClue($bitNode);

            // 收尾
            // 将最后一个结点的rightChild 指向 根结点
            $this->preNode->rightChild = $node;
            $this->preNode->rtag = 0;
            // 将头结点的rightChild 指向最后一个结点
            $node->rightChild = $this->preNode;
        }
    }
}

$tree = null;
$node = null;
$binaryLinkedList = new ClueBinaryTree();
$binaryLinkedList->createBitTree($tree);
$binaryLinkedList->inOrderClueNode($tree, $node);
var_dump($node);