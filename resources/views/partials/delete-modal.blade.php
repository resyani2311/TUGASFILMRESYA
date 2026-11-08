<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="delete-icon"><i class="bi bi-trash3"></i></div>
                <h5 class="mb-2" id="deleteModalLabel">Hapus data?</h5>
                <p class="text-muted mb-1">Anda akan menghapus <strong class="text-white" data-delete-name>data ini</strong>.</p>
                <p class="small text-warning mb-0" data-delete-note style="display:none"></p>
                <p class="small text-muted mt-2 mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4 gap-2">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-cine" data-loading="Menghapus..."><i class="bi bi-trash3"></i> Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
