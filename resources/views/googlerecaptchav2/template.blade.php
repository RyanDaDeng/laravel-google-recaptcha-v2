<script>
    function onloadCallback() {
        @foreach($ids as $id)
        let client{{$id}} =  grecaptcha.render('{{$id}}', {
            'sitekey': '{{$publicKey}}',
            'theme': '{{$theme}}',
            'badge': '{{$badge}}',
            'size': '{{$size}}',
            'hl': '{{$language}}'
        });

        @if($size==='invisible')
        grecaptcha.ready(function () {
            grecaptcha.execute(client{{$id}});
        });
        @endif
        @endforeach
    }
</script>
<script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=onloadCallback" defer async></script>
