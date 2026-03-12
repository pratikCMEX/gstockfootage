<h3>{{ $plan->name }}</h3>

<p>Price : ${{ $plan->price }}</p>
<p>Total Clips : {{ $plan->total_clips }}</p>

<form method="POST" action="{{ route('subscription.payment') }}">
    @csrf

    <input type="hidden" name="plan_id" value="{{ $plan->id }}">

    <button class="btn btn-primary">
        Proceed to Payment
    </button>

</form>