<?php
/**
 * 赫夫曼编码
 * 创建赫夫曼编码
 *      创建一个赫夫曼树，赫夫曼树的组成是按照字符的权值(字符出现的次数)，小的两个字符先组合，成一个新的结点，在进行组合。。。见/images/赫夫曼树构造过程.jpeg
 *      所以，需要一个队列，一个权值优先级的队列(priority queue)
 *      比如，"I am antfoot"
 */

define('MAX_SIZE', 256);

/**
 * Class HlNode
 * huffman表的叶子结点
 * 对于叶子结点的最终编码的计算方式，在huffman树中，向左子树找一次，记一个0，向右子树找一次，记一个1
 */
class HlNode {
    public $symbol; // 字符，比如'a'
    public $code; // 存放编码，也就是huffman编码表中叶子结点最终的编码，比如0001
    public $next; // 下一个HlNode结点
}

/**
 * Class HlTable
 */
class  HlTable {
    public $first; // 指向HlNode
    public $last; // 指向HlNode
}

/**
 * Class HtTree
 * 树的根结点
 */
class HtTree {
    public $root;
}

/**
 * Class HtNode
 * 赫夫曼树的结点
 *  ymbol就是ascii的值
 *  left指向左结点
 *  right指向右结点
 */
class HtNode {
    public $symbol;
    public $left;
    public $right;
}

/**
 * Class PQueueNode
 * 链表
 * 实际队列
 */
class PQueueNode {
    public $val; // 指向一个树的结点
    public $priority; // 优先级 >= 0，也就是出现的次数
    public $next; // 指向下一个PQueueNode结点
}


/**
 * Class PQueue
 * 优先队列的头结点
 */
class PQueue {
    public $size;
    public $first; // 头指针，执行PQueueNode结点
}

class Huffman {
    /**
     * @param $queue
     *  创建队列
     */
    public function initPQueue(&$queue)
    {
        $queue = new PQueue();
        $queue->first = null;
        $queue->size = 0;
    }

    /**
     * @param $queue
     * @param $htNode
     * @param $priority
     * 加入队列
     *  $queue为队列
     *  $htNode为树结点
     *  $priority 优先级,出现的次数
     */
    public function addPQueue(&$queue, $htNode, $priority)
    {
        if ($queue->size == MAX_SIZE) {
            printf("\n队列已满\n");
            return;
        }
        $pQueueNode = new PQueueNode();
        $pQueueNode->priority = $priority;
        $pQueueNode->val = $htNode;

        if ($queue->size == 0 || $queue->first == null) { // 空队列
            $pQueueNode->next = null; // 队列结点的next为空
            $queue->first = $pQueueNode;
            $queue->size = 1;
        } else { // 队列不为空
            if ($queue->first->priority >= $priority) {// 如果队列第一个结点的优先级>=当前传进来的值
                 // 将新结点作为队列的头结点
                $pQueueNode->next = $queue->first;
                $queue->first = $pQueueNode;
                $queue->size ++;
            } else {
                // 将头结点赋值给一个迭代器，用于下边的迭代判断
                // 此时第一个结点的优先级 < 新结点的优先级
                $iterator = $queue->first;
                // 迭代判断下一个结点的优先级
                while ($iterator->next != null) {
                    if ($iterator->next->priority >= $priority) {
                         // 如果新优先级要小，则插入当前迭代到的结点之前
                        $pQueueNode->next = $iterator->next;
                        $iterator->next = $pQueueNode;
                        $queue->size ++;
                        return;
                    }
                    $iterator = $iterator->next; // 下一个结点
                }

                // 如果上边的while没有返回，则说明新结点的优先级最高，则插入最后
                if ($iterator->next == null) {
                    $pQueueNode->next = null;
                    $iterator->next = $pQueueNode;
                    $queue->size++;
                    return;
                }
            }
        }
    }

    /**
     * @param $queue
     * @return null
     * 获取队列结点
     */
    public function getQueue($queue)
    {
        $htNode = null;
        if ($queue->size > 0) {
            $htNode = $queue->first->val;
            $queue->first = $queue->first->next;
            $queue->size--;
        } else {
            printf("\n当前队列为空\n");
        }
        return $htNode;
    }

    /**
     * @param $str
     * @return HtTree
     * 创建Huffman树
     *      首先生成一个字符出现次数的数组。
     *      初始化一个优先级队列 $huffmanQueue
     *      将生成的字符数组，逐个添加到队列，在添加队列操作中，会按照出现次数的少到多，在队列中排序
     *      生成赫夫曼树
     *          先取出前两个最小的结点，然后赋值给新创建的'根'结点的左子树和右子树，连同新结点的权值，在加入到队列
     *          。。。如此一直while操作，直到剩下最后一个结点
     *          最后一个结点赋值给根结点，即可
     */
    public function buildTree($str)
    {
        // $probability记录每个字符出现的次数
        $probability = [];
        $len = strlen($str);
        // 统计待编码的字符串各个字符（ascii码）出现的次数
        for ($j=0; $j<$len; $j++) {
            $asciiCode = ord($str[$j]);
            $probability[$asciiCode] = isset($probability[$asciiCode]) ? ++$probability[$asciiCode] : 1;
        }
        // 生成一个队列的头结点
        $this->initPQueue($huffmanQueue);

        // 填充队列
        // 保证队列有序，优先级从小到大，按照次数从少到多，进行插入排列
        // $k<256 因为ascii有256个字符
        for ($k=0; $k<256; $k++) {
            // 判断是否出现过
            if (isset($probability[$k]) && $probability[$k] != 0) {
                // 生成一个树的结点
                $htNode = new HtNode();
                $htNode->left = null;
                $htNode->right = null;
                $htNode->symbol = chr($k); // chr() 指定ascii转为字符

                // 加入队列
                $this->addPQueue($huffmanQueue, $htNode, $probability[$k]);
            }
        }
        unset($probability);

        // 创建赫夫曼树
        while ($huffmanQueue->size != 1) { // 因为剩下一个元素的时候，就是树的跟结点
            // $priority是队列的前两个结点（权值最小的两个结点）的权值的和
            $priority = $huffmanQueue->first->priority;
            $priority += $huffmanQueue->first->next->priority;

            // 弹出队列的前两个最小的结点
            $leftTreeNode = $this->getQueue($huffmanQueue);
            $rightTreeNode = $this->getQueue($huffmanQueue);

            // 生成一个新的树结点，并将上边弹出的两个最小结点，放到当前新节点（根结点）的左子树和右子树上
            $newTreeNode = new HtNode();
            $newTreeNode->left = $leftTreeNode;
            $newTreeNode->right = $rightTreeNode;

            // 新树结点加入到队列
            $this->addPQueue($huffmanQueue, $newTreeNode, $priority);
        }

        $treeNode = new HtTree();
        $treeNode->root = $this->getQueue($huffmanQueue);
        return $treeNode;
    }

    /**
     * @param $huffmanTree
     * @return HlTable
     * 根据huffman树，生成一个表，也就是赫夫曼树编码
     */
    public function buildTable($huffmanTree)
    {
        $hlTable = new HlTable();
        $hlTable->first = null;
        $hlTable->last = null;

        $codes = [];
        $k = 0; // 当前在第几层
        $this->traverseTree($huffmanTree->root, $hlTable, $k, $codes);
        return $hlTable;
    }

    /**
     * @param $htNode
     * @param $table
     * @param $k
     * @param $codes
     * 递归遍历赫夫曼树，计算叶子结点的编码
     */
    public function traverseTree($htNode, $table, $k, &$codes)
    {
        if ($htNode->left == null && $htNode->right == null) { // 到达叶子结点
            // 声明一个huffman表的叶子结点
            $hlNode = new HlNode();
            $hlNode->code = implode('', $codes);
            $hlNode->symbol = $htNode->symbol;
            $hlNode->next = null;

            if ($table->first == null) {
                $table->first = $hlNode;
                $table->last = $hlNode;
            } else {
                $table->last->next = $hlNode;
                $table->last = $hlNode;
            }
        }

        if ($htNode->left != null) { // 左子树存在，则记一个0，层数+1
            $codes[$k] = 0;
            $this->traverseTree($htNode->left, $table, $k+1, $codes);
        }

        if ($htNode->right != null) {
            $codes[$k] = 1;
            $this->traverseTree($htNode->right, $table, $k+1, $codes);
        }
    }

    // 打印编码
    public function encode($table, $str)
    {
        printf("打印编码内容： \n");
        for ($i=0; $i<strlen($str); $i++) {
            // 表的链表第一个结点
            $traversal = $table->first;
            while ($traversal->symbol != $str[$i]) {
                $traversal = $traversal->next;
            }
            printf("%s", $traversal->code);
        }
        printf("\n");
    }
    // 解码
    public function decode($table, $strToCode)
    {
        $traversal = $table->root;
        printf("打印字符内容： \n");
        for ($i=0; $i<strlen($strToCode); $i++) {
            if ($traversal->left == null && $traversal->right == null) {
                printf("%s", $traversal->symbol);
                $traversal = $table->root;
            }
            if ($strToCode[$i] == 0) {
                $traversal = $traversal->left;
            }

            if ($strToCode[$i] == 1) {
                $traversal = $traversal->right;
            }

            if ($strToCode[$i] != 0 && $strToCode[$i] != 1) {
                printf("输入的code码错误");
                return;
            }
        }
        if ($traversal->left == null && $traversal->right == null) {
            printf("%s", $traversal->symbol);
            $traversal = $table->root;
        }
        printf("\n");
    }
}

$obj = new Huffman();
$str = 'I am antfoot';
$tree = $obj->buildTree($str);
$table = $obj->buildTable($tree);
$obj->encode($table, $str);
$obj->decode($tree, "001101100011101100010110000111111110");
//var_dump($table);