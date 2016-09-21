<div class="progress">
    <div class="progress-bar{{ isset($classes)? ' '.$classes:null }}" role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$value}}%"></div>
</div>