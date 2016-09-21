<canvas id="{{ $id }}_chart" height="{{ $height }}"></canvas>

@push('scripts')
<script>
    $(function(){
        new Chart(
                document.getElementById("{{ $id }}_chart").getContext("2d"),
                {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @foreach($data as $datum)
                            "{{ isset($label_property)? object_get($datum, $label_property): $datum->name }}",
                            @endforeach
                        ],
                        datasets: [{
                            data:[
                                @foreach($data as $datum)
                                "{{ isset($value_property)? object_get($datum, $value_property): $datum->id }}",
                                @endforeach
                            ],
                            backgroundColor: [
                                '#FF9800',
                                '#607D8B',
                                '#4CAF50',
                                '#F44336',
                                '#009688',
                                '#3F51B5',
                                '#795548',
                                '#2196F3',
                                '#CDDC39'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                }
        );
    });
</script>
@endpush