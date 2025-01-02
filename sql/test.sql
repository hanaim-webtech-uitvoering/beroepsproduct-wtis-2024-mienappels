
/* */ 
select * from Product

select * from "User" where username = 'admin'

update "User" set role = 'Personnel' where username = 'admin'

select * from Pizza_Order inner join Pizza_Order_Product on Pizza_Order.order_id = Pizza_Order_Product.order_id
-- select name, price from Product where type_id = Drank