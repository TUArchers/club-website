<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\PublicContent\Page;
use TuaWebsite\Domain\PublicContent\PageRepositoryInterface;

/**
 * Page Repository (Eloquent)
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentPageRepository implements PageRepositoryInterface
{
    /** @inheritDoc */
    public function add(Page $page)
    {
        $page->save();
    }

    /** @inheritDoc */
    public function update(Page $page)
    {
        $page->save();
    }

    /** @inheritDoc */
    public function get($page_id)
    {
        return Page::find($page_id);
    }

    /** @inheritDoc */
    public function withSlug($page_slug)
    {
        return Page::where('slug', $page_slug)->first();
    }

}