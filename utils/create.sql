CREATE TABLE IF NOT EXISTS photos (
    id BIGSERIAL PRIMARY KEY,
    filename text,
    md5sum text
    );

create index on table photos using md5sum;

CREATE TABLE IF NOT EXISTS tags (
    id BIGSERIAL PRIMARY KEY,
    tagtitle text
);

CREATE TABLE IF NOT EXISTS tagged_items (
    photo_id integer references photos(id),
    tag_id integer references tags(id)
);

CREATE TABLE IF NOT EXISTS thumbnails (
    id bigserial primary key,
    thumbid integer,
    filename text
    );


thumb000000000000673a.

select photos.filename,'thumb' || lpad(to_hex(thumbnails.thumbid), 16, '0') || '.jpg' FROM photos inner join thumbnails on photos.filename = thumbnails.filename;
