<?php

namespace Fourum\Model;

class Node extends \Baum\Node
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'tree';

    /**
     * Column name which stores reference to parent's node.
     *
     * @var int
     */
    protected $parentColumn = 'parent_id';

    /**
     * Column name for the left index.
     *
     * @var int
     */
    protected $leftColumn = 'left';

    /**
     * Column name for the right index.
     *
     * @var int
     */
    protected $rightColumn = 'right';

    /**
     * Column name for the depth field.
     *
     * @var int
     */
    protected $depthColumn = 'depth';

    /**
     * With Baum, all NestedSet-related fields are guarded from mass-assignment
     * by default.
     *
     * @var array
     */
    protected $guarded = array('id', 'parent_id', 'left', 'right', 'depth');

    /**
     * @return Forum
     */
    public function forum()
    {
        return $this->belongsTo('Fourum\Model\Forum')->first();
    }

    /**
     * @return string
     */
    public function html(/* $firstLevelWrapper, $secondLevelWrapper, ... */)
    {
        $args = func_get_args();

        $wrappers = array(
            1 => head(array_slice($args, 0, 1)),
            2 => head(array_slice($args, 1, 2)),
            3 => head(array_slice($args, 2, 3))
        );

        $treeHtml = '';

        /**
         * @todo solve recursively
         */
        foreach ($this->getDescendants() as $node) {
            $forum = $node->forum();

            if ($forum->isCategory()) {
                $treeHtml .= $this->wrap($wrappers[$node->getLevel()], $forum);

                foreach ($node->getImmediateDescendants() as $subNode) {
                    $treeHtml .= $this->wrap($wrappers[$subNode->getLevel()], $subNode->forum());
                }
            }
        }

        return $treeHtml;
    }

    /**
     * @param string $target
     * @param Forum $forum
     *
     * @return string
     */
    private function wrap($target, $forum)
    {
        $matches = null;
        $result = preg_match_all("/\%(.*?)\%/", $target, $matches);
        $keys = $matches[1];

        foreach ($keys as $key) {
            $method = 'get' . ucwords($key);
            $target = str_replace('%' . $key . '%', $forum->$method(), $target);
        }

        return $target;
    }
}