<form action="{{ $action }}" method="post" style="display:inline" onsubmit="return confirm('{{ $confirm ?? 'Yakin ingin menghapus data ini?' }}')">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
</form>
