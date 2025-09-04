{{--
<script>
    window.location.href = "/cart/direct_checkout?discount_id={{ $discount_id }}&user_id={{ $user->id }}";
</script>
--}}
{{--

<form action="/cart/direct_checkout" method="post" id="cartForm">
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <input type="hidden" name="discount_id" value="{{ $discount_id }}">

    <!-- No need for CSRF token in stateless form -->
</form>

<script>
    function submitForm() {
        document.getElementById("cartForm").submit();
    }
    submitForm();
</script>
--}}

<form action="/cart/checkout" method="post" id="cartForm">
    {{ csrf_field() }}
    <input type="hidden" name="discount_id" value="{{$discount_id}}">
</form>

<script>
    function submitForm() {
        document.getElementById("cartForm").submit();
    }
    submitForm();
</script>
