<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\News\Article;
use TuaWebsite\Domain\News\ArticleRepositoryInterface;

/**
 * Article Repository (Eloquent)
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentArticleRepository implements ArticleRepositoryInterface
{
    /** @inheritDoc */
    public function add(Article $article)
    {
        $article->save();
    }

    /** @inheritDoc */
    public function update(Article $article)
    {
        $article->save();
    }

    /** @inheritDoc */
    public function get($article_id)
    {
        return Article::find($article_id);
    }

    /** @inheritDoc */
    public function withSlug($article_slug)
    {
        return Article::where('slug', $article_slug)->first();
    }
}