@if (session('success') || session('error'))
  <div class="container" style="margin-top:15px">
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session('success') ?? session('error') }}
    </div>
  </div>
@endif
