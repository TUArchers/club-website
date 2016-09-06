<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TuaWebsite\Http\Controllers\Controller;

/**
 * News Controller
 *
 * For posting and editing news articles
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class NewsController extends Controller
{
    public function publishArticle(Request $request)
    {
        //
    }

    public function editArticle(Request $request, $articleId)
    {
        //
    }

    public function showArticles()
    {
        //
    }

    public function showArticleDetails($articleId)
    {
        //
    }

    public function removeArticle($articleId)
    {
        //
    }
}