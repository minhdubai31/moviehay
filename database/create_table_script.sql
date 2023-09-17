create table series (
	seri_id int primary key AUTO_INCREMENT,
    seri_name text(1000) not null,
    country tinytext,
    seri_poster text(3000)
);

create table seasons (
	season_id int primary key auto_increment,
    season_name text(1000) not null,
    release_date date not null,
    director text(255) not null,
    categories text(1000),
    season_description text(5000),
    season_order int,
    season_tag tinytext,
	season_poster text(3000),
    seri_id int,
    fOREIGN KEY (seri_id) REFERENCES series(seri_id)
);

create table episodes (
	episode_id int primary key auto_increment,
    episode_name text(1000) not null,
    episode_order int not null,
    likes int,
    views int,
    duration int,
    season_id int,
    thumbnail text(3000),
    foreign key (season_id) references seasons(season_id)
);
    
