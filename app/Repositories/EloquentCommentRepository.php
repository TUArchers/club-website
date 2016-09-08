<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\News\Comment;
use TuaWebsite\Domain\News\CommentRepositoryInterface;

/**
 * Comment Repository (Eloquent)
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentCommentRepository implements CommentRepositoryInterface
{
    /** @inheritDoc */
    public function add(Comment $comment)
    {
        $comment->save();
    }

    /** @inheritDoc */
    public function update(Comment $comment)
    {
        $comment->save();
    }

    /** @inheritDoc */
    public function get($comment_id)
    {
        return Comment::find($comment_id);
    }
}