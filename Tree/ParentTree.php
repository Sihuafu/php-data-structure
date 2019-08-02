<?php
/**
 * 树的表示方式 - 双亲表示法
 * 用固定数组表示一段连续的存储空间，用来存储树的各个结点
 * 特点：
 *  根据某个结点的parent找到双亲结点的复杂度是O(1)，索引到01时，找到根结点
 *  如果要找到某个结点的子结点，则需要遍历整个树
 * 改进：
 *  在结点TreeNode中，添加子结点指针，兄弟结点指针。。。
 *  但是这样，容易造成浪费，因为有的结点的度可能是0，有的可能是1，还有的可能是3。所以如果添加子结点指针的话，要在结构上添加最大度值的数量的指针
 *  例如 child1, child2, child3 ..指针
 *  同样兄弟指针也是。。如此的浪费情况
 *  例如 left，right 指针
 * 再改进
 *      可以将指向子结点的指针放到一个数组里，第一个元素位置存储该结点的度，其余位置存储子结点的下标
 * 但是，虽然解决里空间浪费问题，但是每个结点的度值不一样，导致初始化和维护起来很麻烦
 * 再改进
 *      可以将结点位置的指针指向一个单链表
 */
define('MAX_TREE_SIZE', 10);
class TreeNode {
    public $data = ''; // 存储结点数据
    public $parent = null; // 双亲的位置，数据应该是一个指向双亲的下标，根结点为-1
}

class ParentTree {
    public $root; // 跟的位置
    public $num; // 结点的总数目
    public $fixArr=[]; //内存空间
    public function __construct()
    {
        $fixArr = new SplFixedArray(MAX_TREE_SIZE);
    }
}