$(document).ready(function() {
	var productItem = [{
			productName: "Gulab Jamun Ice Cream",
			price: "150.00 ",
			photo: "gulab-jamun.PNG"
		},
		{
			productName: "Cone Vadilal",
			price: "60.00 ",
			photo: "cone vadilal.PNG"
		},
		{
			productName: "Belgian Chocolate",
			price: "180.00 ",
			photo: "Belgian Chocolate.PNG"
        },
		];
	showProductGallery(productItem);
	showCartTable();
});

function addToCart(element) {
	var productParent = $(element).closest('div.product-item');
	var price = $(productParent).find('.price span').text();
	var productName = $(productParent).find('.productname').text();
	var quantity = $(productParent).find('.product-quantity').val();

	var cartItem = {
		productName: productName,
		price: price,
		quantity: quantity
	};
	var cartItemJSON = JSON.stringify(cartItem);

	var cartArray = new Array();
	// If javascript shopping cart session is not empty
	if (sessionStorage.getItem('shopping-cart')) {
		cartArray = JSON.parse(sessionStorage.getItem('shopping-cart'));
	}
	cartArray.push(cartItemJSON);

	var cartJSON = JSON.stringify(cartArray);
	sessionStorage.setItem('shopping-cart', cartJSON);
	showCartTable();
}


function showProductGallery(product) {
	//Iterate javascript shopping cart array
	var productHTML = "";
	product.forEach(function(item) {
		productHTML += '<div class="product-item">'+
					'<img src="product-images/' + item.photo + '">'+
					'<div class="productname">' + item.productName + '</div>'+
					'<div class="price"> Rs <span>' + item.price + '</span></div>'+
					'<div class="cart-action">'+
						'<input type="text" class="product-quantity" name="quantity" value="1" size="2" />'+
						'<input type="submit" value="Add to Cart" class="add-to-cart" onClick="addToCart(this)" />'+
					'</div>'+
				'</div>';
				"<tr>";
		
	});
	$('#product-item-container').html(productHTML);
}
