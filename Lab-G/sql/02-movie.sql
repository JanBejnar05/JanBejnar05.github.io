create table movie
(
    id      integer not null
        constraint movie_pk
            primary key autoincrement,
    title text not null,
    producer text not null,
    description text not null
);
