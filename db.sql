create table products
(
	id integer not null
		constraint products_pk
			primary key autoincrement,
	name varchar not null,
	price float
);

create unique index products_id_uindex
	on products (id);

create unique index products_name_uindex
	on products (name);


