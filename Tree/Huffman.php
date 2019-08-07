<?php
/**
 * 赫夫曼树
 * 创建赫夫曼编码
 *      创建一个赫夫曼树，赫夫曼树的组成是按照字符的权值(字符出现的次数)，小的两个字符先组合，成一个新的结点，在进行组合。。。见/images/赫夫曼树构造过程.jpeg
 *      所以，需要一个队列，一个权值优先级的队列(priority queue)
 *      比如，"I am antfoot"
 */

class Huffman {
    public function buildTree($str)
    {

    }

    public function buildTable()
    {

    }

    // 打印编码
    public function encode() {}
    // 解码
    public function decode() {}
}

$obj = new Huffman();
$str = 'I am antfoot';
$obj->buildTree($str);