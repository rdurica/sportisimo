create table if not exists `user`
(
    id                int auto_increment
        primary key,
    username          varchar(50)                          not null,
    password          varchar(128)                         not null,
    first_name        varchar(25)                          not null,
    last_name         varchar(25)                          not null,
    email             varchar(100)                         not null,
    is_active         tinyint(1) default 1                 not null,
    registration_date timestamp  default CURRENT_TIMESTAMP not null,
    constraint email
        unique (email),
    constraint username
        unique (username)
);

create table if not exists `brand`
(
    id         int auto_increment
        primary key,
    title      varchar(50)                         not null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    updated_at timestamp                           null,
    created_by int                                 null,
    updated_by int                                 null,
    constraint title
        unique (title),
    constraint fk_brand_created_by__user_id
        foreign key (created_by) references `user` (id)
            on delete set null,
    constraint fk_brand_updated_by__user_id
        foreign key (updated_by) references `user` (id)
            on delete set null
);

INSERT INTO `user` (`username`, `password`, `first_name`, `last_name`, `email`, `is_active`)
VALUES ('Administrator', '$2y$12$gfT.Cg0.5fGcCAzeMnhQH.ZazPDafBYBiqf2618L6Bo1x4WHS5MVG', 'Admin', 'Admin',
        'admin@sportisimo.cz', 1);
