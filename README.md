## setup

### requirements

- rabbitMq

### prepare project
after modify and complete env file, run bellow command to prepare services
```bash
    docker compose up -d
```


## usage

- GET `v1/rooms` => index of rooms
- GET `v1/rooms/:roomId` => get a room by id

a consumer exists on background and listen to room_touched channel and consume room modifications and change related room in elasticsearch.

elasticsearch integrated by `elasticsearch/elasticsearch` package.
