create table series (
	sr_id int primary key AUTO_INCREMENT,
    sr_name text(1000) not null,
    country tinytext,
    sr_poster text(3000)
);

create table seasons (
	ss_id int primary key auto_increment,
    ss_name text(1000) not null,
    ss_release_date date,
    ss_director text(255),
    ss_categories text(1000),
    ss_description text(5000),
    ss_order int not null,
    ss_tag tinytext,
	ss_poster text(3000),
    sr_id int,
    fOREIGN KEY (sr_id) REFERENCES series(sr_id)
);

create table episodes (
	ep_id int primary key auto_increment,
    ep_name text(1000) not null,
    ep_order int not null,
    ep_likes int,
    ep_views int,
    ss_id int,
    ep_thumbnail text(3000),
    foreign key (ss_id) references seasons(ss_id)
);
    
