CREATE table service (
     id bigserial not null,
     slug varchar(140) not null,
     title varchar(140) not null,
     parent bigint default null,
     created_at timestamp(0) with time zone,
     updated_at timestamp(0) with time zone,
     PRIMARY KEY(id)
);