<div class="info-box">
    <div class="icon bg-{{ $colour }}">
        <i class="material-icons">{{ $icon }}</i>
    </div>
    <div class="content">
        <div class="text">{{ $title }}</div>
        <div class="number count-to" data-from="0" data-to="{{ $value }}" data-speed="1000" data-fresh-interval="20">{{ $value }}</div>
    </div>
</div>