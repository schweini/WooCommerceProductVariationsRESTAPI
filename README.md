# WooCommerceProductVariationsRESTAPI

Super simple Wordpress/WooCommerce plugin that adds basic product variation's info to the GET call of a 'parent' product.
This IMMENSELY reduces tha mount of REST API calls you have to make to sync your store with a local database.

Completely based on https://stackoverflow.com/questions/49352665/woocommerce-rest-api-get-all-products-with-variations-without-too-many-request

i.e.: GET https://example.com/wp-json/wc/v3/products/1234/ will now, for each product, add the list "product_variations" like this:

```
{
  "id":137259,
  "name":"Vestido Punto Manga Larga",
  "slug":"vestido-punto-manga-larga",

........

  "product_variations":[
         {
            "id":137260,
            "on_sale":true,
            "regular_price":6995,
            "sale_price":5995,
            "sku":"1072111021",
            "quantity":4,
            "stock":4,
            "attributes":[
               {
                  "name":"Talla",
                  "slug":"pa_talla",
                  "option":"s"
               },
               {
                  "name":"Color",
                  "slug":"pa_color",
                  "option":"rojo"
               }
            ]
         },
         {
            "id":137261,
            "on_sale":true,
            "regular_price":6995,
            "sale_price":5995,
            "sku":"1072111022",
            "quantity":8,
            "stock":8,
            "attributes":[
               {
                  "name":"Talla",
                  "slug":"pa_talla",
                  "option":"m"
               },
               {
                  "name":"Color",
                  "slug":"pa_color",
                  "option":"rojo"
               }
            ]
         },
  ]
.........

}

```
