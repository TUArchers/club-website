<?php

namespace TuaWebsite\Domain\News;

/**
 * Comment Repository Interface
 *
 * @package TuaWebsite\Domain\News
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface CommentRepositoryInterface
{
    /**
     * @param Comment $comment
     */
    public function add(Comment $comment);

    /**
     * @param Comment $comment
     */
    public function update(Comment $comment);

    /**
     * @param int $comment_id
     *
     * @return Comment
     */
    public function get($comment_id);
}