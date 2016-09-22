<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
    <div class="info-box hover-expand-effect">
        <div class="icon bg-{{ $event->type->colour }}">
            <a href="{{ route('admin.events.show', $event->id) }}"><i class="material-icons">{{ $event->type->icon_name }}</i></a>
        </div>
        <div class="content">
            <div class="text truncate">{{ strtoupper($event->name) }} ({{ $event->type->name }})</div>
            <div class="number">{{ $event->starts_at->format('g:i A') }}</div>
        </div>
    </div>
</div>