<?php

namespace TuaWebsite\Providers;

use Illuminate\Support\ServiceProvider;
use TuaWebsite\Domain\Event\EventRepositoryInterface;
use TuaWebsite\Domain\Event\EventTypeRepositoryInterface;
use TuaWebsite\Domain\Event\ReservationRepositoryInterface;
use TuaWebsite\Domain\Identity\PermissionRepositoryInterface;
use TuaWebsite\Domain\Identity\RoleRepositoryInterface;
use TuaWebsite\Domain\Identity\UserRepositoryInterface;
use TuaWebsite\Domain\News\ArticleRepositoryInterface;
use TuaWebsite\Domain\News\CommentRepositoryInterface;
use TuaWebsite\Domain\PublicContent\PageRepositoryInterface;
use TuaWebsite\Domain\Records\RoundRepositoryInterface;
use TuaWebsite\Domain\Records\ScoreRepositoryInterface;
use TuaWebsite\Repositories\EloquentArticleRepository;
use TuaWebsite\Repositories\EloquentCommentRepository;
use TuaWebsite\Repositories\EloquentEventRepository;
use TuaWebsite\Repositories\EloquentEventTypeRepository;
use TuaWebsite\Repositories\EloquentPageRepository;
use TuaWebsite\Repositories\EloquentPermissionRepository;
use TuaWebsite\Repositories\EloquentReservationRepository;
use TuaWebsite\Repositories\EloquentRoleRepository;
use TuaWebsite\Repositories\EloquentRoundRepository;
use TuaWebsite\Repositories\EloquentScoreRepository;
use TuaWebsite\Repositories\EloquentUserRepository;

/**
 * Repository Provider
 *
 * @package TuaWebsite\Providers
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class RepositoryProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    public function register()
    {
        // Identity
        $this->app->bind(PermissionRepositoryInterface::class, EloquentPermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloquentRoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);

        // Events
        $this->app->bind(EventRepositoryInterface::class, EloquentEventRepository::class);
        $this->app->bind(EventTypeRepositoryInterface::class, EloquentEventTypeRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, EloquentReservationRepository::class);

        // News
        $this->app->bind(ArticleRepositoryInterface::class, EloquentArticleRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, EloquentCommentRepository::class);

        // Records
        $this->app->bind(RoundRepositoryInterface::class, EloquentRoundRepository::class);
        $this->app->bind(ScoreRepositoryInterface::class, EloquentScoreRepository::class);

        // Public Content
        $this->app->bind(PageRepositoryInterface::class, EloquentPageRepository::class);
    }
}
