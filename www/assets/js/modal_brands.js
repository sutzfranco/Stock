$(document).ready(function () {
    $('.create_brands_Btn').click(function () {
        $('#create_Modal').modal('show');
    });
});
$('.editBtn').click(function () {
    var id_brand = $(this).data('id_brand');
    var detail = $(this).data('detail');      
    $('#id_brand').val(id_brand);
    $('#detail').val(detail);
    $('#editModal').modal('show');
});
$('.delete_Btn').click(function () {
    var id_brand = $(this).data('id_brands'); 
    $('#id_brand_eliminate').val(id_brand);
    $('#deleteModal').modal('show');
});
