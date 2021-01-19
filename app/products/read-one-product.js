$(document).ready(function () {

    // handle 'read one' button click
    $(document).on('click', '.read-one-product-button', function () {
        // get product id
        var product_id = $(this).attr('data-id');
        // read product record based on given ID
        $.getJSON("http://localhost/ksp-example/product/read_one.php?product_id=" + product_id, function (data) {
            // start html
            var read_one_product_html = `
 
                        <!-- when clicked, it will show the product's list -->
                        <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                            <span class='glyphicon glyphicon-list'></span> Read Products
                        </div> 
                        <!-- product data will be shown in this table -->
                        <table class='table table-bordered table-hover'>
                            <!-- Product ID field -->
                            <tr>
                                <td>Product ID</td>
                                <td>`+data.product_id+`</td>
                            </tr>

                            <!-- Category ID -->
                            <tr>
                                <td class='w-30-pct'>Category ID</td>
                                <td class='w-70-pct'>` + data.category_id + `</td>
                            </tr>
                            <!-- Product Name -->
                            <tr>
                                <td class='w-30-pct'>Product Name</td>
                                <td class='w-70-pct'>` + data.product_name + `</td>
                            </tr>
                         
                            <!-- product description -->
                            <tr>
                                <td>Description</td>
                                <td>` + data.description + `</td>
                            </tr>

                            <!-- product price -->
                            <tr>
                                <td>Price</td>
                                <td>` + data.price + `</td>
                            </tr>
                         
                         
                            <!-- product category name -->
                            <tr>
                                <td>Category</td>
                                <td>` + data.category_name + `</td>
                            </tr>
                         
                        </table>`;
            // inject html to 'page-content' of our app
            $("#page-content").html(read_one_product_html);

            // chage page title
            changePageTitle("Create Product");
        });
    });

});