create table profile (
    id bigserial not null,
    slug varchar(255) not null,
    first_name varchar(140) not null,
    last_name varchar(140) not null,
    surname varchar(140) not null,
    email varchar(140) not null,
    phone bigint not null,
    experience integer not null,
    created_at timestamp(0) with time zone not null,
    updated_at timestamp(0) with time zone default null,
    primary key (id)
);
