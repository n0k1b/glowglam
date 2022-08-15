{{-- --------- Check in Seesion Message -------- --}}
@if (session()->has('success_message'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <strong>{{ session('success_message')}} </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  {{-- ---------------- X -------------------- --}}
