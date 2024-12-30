# underground-hotel

## Build and deploy

```bash
docker build -t hotel-app:latest app/
docker build -t hotel-db:latest db/
docker-compose up -d

```

### Set permission for development in WSL

```bash
sudo chown -R :www-data underground-hotel
sudo chmod -R g+rw underground-hotel
```