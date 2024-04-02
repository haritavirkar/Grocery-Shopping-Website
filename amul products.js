$(document).ready(function() {
	var productItem = [{
			productName: "Butter",
			price: "80.00 ",
			photo: "60 (5).PNG"
		},
		{
			productName: "Custard",
			price: "200.00 ",
			photo: "60 (1).PNG"
		},
		{
			productName: "Yogurt",
			price: "30.00 ml",
			photo: "60 (3).PNG"  
		},
		{
			productName: "Cheese",
			price: "150.00 ",
			photo: "60 (4).PNG"  
		},
		{
			productName: "Milk",
			price: "60.00 Liter",
			photo: "60 (6).PNG"  
		},
		{
			productName: "Butterscotch Ice Cream",
			price: "60.00 ",
			photo: "ice (2).PNG"  
		},
		{
			productName: "Amul Ice Cream",
			price: "70.00 ",
			photo: "ice (1).PNG"  
		}];
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
