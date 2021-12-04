-- insert
insert into customers
(customer_code, name, address, phone, email, discount)
values
('0000001', 'name1', 'address1', 09011111111, 'email', 10);

insert into customers
(customer_code, name, address, phone, email, discount)
values
('0000002', 'name2', 'address2', 09011111112, 'email', 15);

-- グッズinsert処理
insert into goods
(name, raw_price, stock, goods_category_id)
values
('化粧品１', 500, 30, 1);

insert into goods
(name, raw_price, stock, goods_category_id)
values
('化粧水２', 900, 30, 1);

insert into goods
(name, raw_price, stock, goods_category_id)
values
('water3', 900, 30, 1);

insert into sales_slips
(selling_price_sum, customer_id)
values
(500, 1);

delete from sales_slips
where sales_slips_num = 4;