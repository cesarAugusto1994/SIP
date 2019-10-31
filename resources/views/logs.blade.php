@extends('base')

@section('content')

        <div class="container">
            <h2>Logs</h2>
            <div class="list-group" id="logs">
            </div>
        </div>

@stop

@section('scripts')

<script>
    function displayLog(data) {
        let $log = $('<div>').addClass('list-group-item')
            .html(`<pre><code>${JSON.stringify(data.message, null, 4)}</code></pre>`);
        $('#logs').prepend($log);
    }
</script>
<script>
    var socket = new Pusher("c9a5abf31bb9598d99c7", {
        encrypted: true,
        cluster: 'mt1',
    });
    socket.subscribe('{{ config('app.env') }}')
        .bind('log', displayLog);
</script>
@stop
