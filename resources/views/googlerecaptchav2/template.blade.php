
<style>
    @media screen and (max-height: 575px) {
        .g-recaptcha {
            transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;
        }
    }
</style>

<script>
    function onloadCallback() {
        @foreach($ids as $id)
            document.getElementById('{{$id}}').classList.add("g-recaptcha");
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
