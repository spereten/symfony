create table profile_service (
    profile_id BIGINT NOT NULL,
    service_id BIGINT NOT NULL,
    price float not null default 0.0,
    PRIMARY KEY(profile_id, service_id)
)