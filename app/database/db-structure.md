```sql
create table rooms (
	id VARCHAR PRIMARY KEY,
	name VARCHAR,
	price INTEGER,
	description VARCHAR
);

create table image_room (
	id INTEGER PRIMARY KEY,
	room_id VARCHAR,
	image VARCHAR,
	position INTEGER,
	FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
);

CREATE TABLE activities (
	id VARCHAR PRIMARY KEY,
	name VARCHAR,
	price INTEGER,
	description VARCHAR,
	image VARCHAR
);

CREATE TABLE booked_rooms (
	id INTEGER PRIMARY KEY,
	check_in DATE,
	check_out DATE,
	total_cost INTEGER,
	room_id VARCHAR,
	FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
);

CREATE TABLE offers (
	id VARCHAR PRIMARY KEY,
	name VARCHAR,
	discount INTEGER,
	requirement VARCHAR,
	requirement_amount INTEGER
);

CREATE TABLE offer_room (
	id INTEGER PRIMARY KEY,
	offer_id VARCHAR,
	room_id VARCHAR,
	FOREIGN KEY (offer_id) REFERENCES offers (id) ON DELETE CASCADE,
	FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE
);

CREATE TABLE room_reviews (
	id INTEGER PRIMARY KEY,
	room_id VARCHAR,
	name VARCHAR,
	review VARCHAR,
	created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (room_id) REFERENCES rooms (id) ON DELETE CASCADE
);
```
