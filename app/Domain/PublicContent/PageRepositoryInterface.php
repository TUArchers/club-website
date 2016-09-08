<?php

namespace TuaWebsite\Domain\PublicContent;

/**
 * Page Repository Interface
 *
 * @package TuaWebsite\Domain\News
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface PageRepositoryInterface
{
    /**
     * @param Page $page
     */
    public function add(Page $page);

    /**
     * @param Page $page
     */
    public function update(Page $page);

    /**
     * @param int $page_id
     *
     * @return Page
     */
    public function get($page_id);

    /**
     * @param string $page_slug
     *
     * @return Page
     */
    public function withSlug($page_slug);
}