$(document).ready(function () {
    $('.create_products_Btn').click(function () {
        $('#create_Modal').modal('show');
    });
});
$('.viewBtn').click(function () {
    var id_product = $(this).data('id_product');
    var number_serial = $(this).data('number_serial');
    var number_product = $(this).data('number_product');
    var name_product = $(this).data('name_product');
    var description = $(this).data('description');
    var stock = $(this).data('stock');
    $('#view_id_product').val(id_product);
    $('#view_number_serial').val(number_serial);
    $('#view_number_product').val(number_product);
    $('#view_name_product').val(name_product);
    $('#view_description').val(description);
    $('#view_stock').val(stock);
    $('#viewModal').modal('show');
});
$('.editBtn').click(function () {
    var id_product = $(this).data('id_product');
    var number_serial = $(this).data('number_serial');
    var number_product = $(this).data('number_product');
    var name_product = $(this).data('name_product');
    var description = $(this).data('description');
    var stock = $(this).data('stock');
    $('#id_product').val(id_product); 
    $('#number_serial').val(number_serial);
    $('#number_product').val(number_product);
    $('#name_product').val(name_product);
    $('#description').val(description);
    $('#stock').val(stock); 
    $('#editModal').modal('show');
});

$('.delete_Btn').click(function () {
    var id_product = $(this).data('id_products');    
    var name_product = $(this).data('name_product');
    $('#id_product_eliminate').val(id_product);
    $('#e_name_product').val(name_product);
    $('#deleteModal').modal('show');
});
