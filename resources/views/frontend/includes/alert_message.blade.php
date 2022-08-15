{{-- --------- Check in Seesion Message -------- --}}
@if (session()->has('alert_message'))
    <div class="alert alert-{{ session('alert_type')}} alert-dismissible fade show text-center" role="alert">
        <strong>{{ session('alert_message')}} </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  {{-- ---------------- X -------------------- --}}
