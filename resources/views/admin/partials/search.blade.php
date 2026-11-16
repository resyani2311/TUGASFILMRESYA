<form method="get" action="{{ $action }}">
  <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control" placeholder="{{ $placeholder ?? 'Cari...' }}">
  <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
  @if (!empty($keyword)) <a href="{{ $action }}" class="btn btn-link">Reset</a> @endif
</form>
