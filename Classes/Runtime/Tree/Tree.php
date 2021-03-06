<?php

/*
  [The "BSD licence"]
  Copyright (c) 2005-2008 Terence Parr
  All rights reserved.

  Redistribution and use in source and binary forms, with or without
  modification, are permitted provided that the following conditions
  are met:
  1. Redistributions of source code must retain the above copyright
  notice, this list of conditions and the following disclaimer.
  2. Redistributions in binary form must reproduce the above copyright
  notice, this list of conditions and the following disclaimer in the
  documentation and/or other materials provided with the distribution.
  3. The name of the author may not be used to endorse or promote products
  derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR
  IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
  OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
  IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,
  INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
  NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
  DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
  THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
  THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Antlr\Runtime\Tree;

use Antlr\Runtime\Token;

/**
 * What does a tree look like?  ANTLR has a number of support classes
 * such as CommonTreeNodeStream that work on these kinds of trees.  You
 * don't have to make your trees implement this interface, but if you do,
 * you'll be able to use more support code.
 *
 * NOTE: When constructing trees, ANTLR can build any kind of tree; it can
 * even use Token objects as trees if you add a child list to your tokens.
 *
 * This is a tree node without any payload; just navigation and factory stuff.
 */
interface Tree
{

    //public static final Tree INVALID_NODE = new CommonTree(Token.INVALID_TOKEN);

    public function getChild($i);

    public function getChildCount();

    // Tree tracks parent and child index now > 3.0

    public function getParent();

    public function setParent(Tree $t);

    /** Is there is a node above with token type ttype? */
    public function hasAncestor($ttype);

    /** Walk upwards and get first ancestor with this token type. */
    public function getAncestor($ttype);

    /** Return a list of all ancestors of this node.  The first node of
     *  list is the root and the last is the parent of this node.
     */
    public function getAncestors();

    /** This node is what child index? 0..n-1 */
    public function getChildIndex();

    public function setChildIndex($index);

    /** Set the parent and child index values for all children */
    public function freshenAllParentAndChildIndexes();

    /** Add t as a child to this node.  If t is null, do nothing.  If t
     *  is nil, add all children of t to this' children.
     */
    function addChild(Tree $t);

    /** Set ith child (0..n-1) to t; t must be non-null and non-nil node */
    public function setChild($i, Tree $t);

    public function deleteChild($i);

    /** Delete children from start to stop and replace with t even if t is
     *  a list (nil-root tree).  num of children can increase or decrease.
     *  For huge child lists, inserting children can force walking rest of
     *  children to set their childindex; could be slow.
     */
    public function replaceChildren($startChildIndex, $stopChildIndex, $t);

    /** Indicates the node is a nil node but may still have children, meaning
     *  the tree is a flat list.
     */
    public function isNil();

    /**  What is the smallest token index (indexing from 0) for this node
     *   and its children?
     */
    public function getTokenStartIndex();

    public function setTokenStartIndex($index);

    /**  What is the largest token index (indexing from 0) for this node
     *   and its children?
     */
    public function getTokenStopIndex();

    public function setTokenStopIndex($index);

    public function dupNode();

    /** Return a token type; needed for tree parsing */
    public function getType();

    public function getText();

    /** In case we don't have a token payload, what is the line for errors? */
    public function getLine();

    public function getCharPositionInLine();

    public function toStringTree();

    public function toString();
}
