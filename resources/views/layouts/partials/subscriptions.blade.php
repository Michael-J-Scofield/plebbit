@if($subPlebbit)
<script>
    $('.subscribe').click(function() {
        _this = $(this);
        var subscribed = _this.attr('data-subscribed');

        @if(Auth::check())
            data = {'api_token': '{{Auth::user()->api_token}}'};

            plebbit = '{{$subPlebbit->name}}';
            if (subscribed === 'no') {
                $.post( "/api/subscribe/" + plebbit, data, function( res ) {
                    _this.removeClass('notsubscribed').addClass('subscribed').attr('data-subscribed', 'yes').text('Unsubscribe');
                });
            } else {
            $.post( "/api/unsubscribe/" + plebbit, data, function( res ) {
                    _this.removeClass('subscribed').addClass('notsubscribed').attr('data-subscribed', 'no').text('Subscribe');
                });
            }
        @else
            $('#loginModal').modal('show');
            $('#loginModalMessage').html('to subscribe to <a href="/p/{{$subPlebbit->name}}">/p/{{$subPlebbit->name}}</a>');
        @endif
    });
</script>
@endif