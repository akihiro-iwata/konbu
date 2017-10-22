```sql

-- create table Konbu.server(id int not null primary key, name varchar(20), cpu_capatity int, memory_capatity int, storage_capatity int, status_id int)
-- create table Konbu.status (id int not null primary key, status varchar(20))
-- create table Konbu.instance(id int not null primary key, server_id int , name varchar(20), cpu_size int, memory_size int, storage_size int, status_id int, FOREIGN KEY (server_id) REFERENCES server(id), FOREIGN KEY (status_id) REFERENCES status(id))
-- create table Konbu.ip_address(id int, instance_id int, ip_address varchar(15), mac_address varchar(12), FOREIGN KEY (instance_id) REFERENCES Konbu.instance(id))
-- create table Konbu.key_store (id int, instance_id int, dec_info varchar(200), key_text varchar(2048), FOREIGN KEY (instance_id) REFERENCES Konbu.instance(id))

```