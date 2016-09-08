<?php

namespace TuaWebsite\Domain\News;

/**
 * Article Repository Interface
 *
 * @package TuaWebsite\Domain\News
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface ArticleRepositoryInterface
{
    /**
     * @param Article $article
     */
    public function add(Article $article);

    /**
     * @param Article $article
     */
    public function update(Article $article);

    /**
     * @param int $article_id
     *
     * @return Article
     */
    public function get($article_id);

    /**
     * @param string $article_slug
     *
     * @return Article
     */
    public function withSlug($article_slug);
}