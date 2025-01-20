
/* */ 
select * from "User"

select * from "User" where username = 'admin'

delete from "User" where username = 'admin'

select * from "User" where role = 'Personnel'

update "User" set role = 'Personnel' where username = 'admin'

select * from Pizza_Order inner join Pizza_Order_Product on Pizza_Order.order_id = Pizza_Order_Product.order_id

select * from Product 

delete from Pizza_Order where address is NULL

select * from Pizza_Order where status = 1
select * from Pizza_Order_Product
-- select name, price from Product where type_id = Drank