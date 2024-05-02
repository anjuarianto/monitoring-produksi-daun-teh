@if ($message = Session::get('success'))
  <div class="alert alert-success" role="alert">
    <div class="d-flex justify-content-between">
      <div class="d-flex">
        <div>
          <!-- Download SVG icon from http://tabler-icons.io/i/check -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
        </div>
        <div>
          <h4 class="alert-title">Success!</h4>
          <div class="text-secondary">{{$message}}</div>
        </div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  </div>
@endif
