$(document).ready(function () {
    $('.edit').on('click', function () {
        var $editModal = $('#editEmployeeModal');
        var id = $(this).data('id');
        var detail = $(this).data('detail');
        console.log("ID: ", id); // Debug
        console.log("Detail: ", detail); // Debug
        $editModal.find('#edit-id').val(id);
        $editModal.find('#edit-detail').val(detail);
        $editModal.modal('show');
    });
        $('.delete').on('click', function () {
            var $deleteModal = $('#deleteEmployeeModal');
            var id = $(this).data('id');
            $deleteModal.find('#edit-id_category').val(id);
            $deleteModal.modal('show');
        });
    });