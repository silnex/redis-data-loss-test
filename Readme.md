# 레디스 데이터 유실 테스트

Redis 단일 노드, Redis 센티널, Redis 클러스터에서 각각 노드가 사라질 때 데이터 유실 테스트를 "간단히" 진행합니다.

### 테스트 환경
```bash
$ docker-compose up
```

### 테스트 방법

wrk 로 요청을 전송이 진행되는 동안 레디스 노드를 재시작해 데이터가 유실되는 정도를 확인합니다.

wrk 가 총 100회 요청 했을때, 10건의 에러가 발생하더라도,  
90건의 카운트가 기록되어있으면 데이터 유실이 발생하지 않은 것으로 판단합니다.

## PHP 구성

### Reset count
```bash
curl http://localhost:8080/redis.php?reset=1
```

### Get count without increment
```bash
curl http://localhost:8080/redis.php?get=1
```

# Redis 단일 노드

다른 구성 없이 Redis 만을 실행합니다.

## Test Script
```bash
$ wrk -c 5 -d 10 http://localhost:8080/redis.php
$ docker restart redis-test-redis-1
```



# Redis Sentinel

레디스 센티널 구성을 통해 Redis에 master와 slave 노드를 구성하고,  
Sentinel 노드를 통해 master 노드가 다운되면 slave 노드를 master로 승격시킵니다.

## Test Script
```bash
$ wrk -c 5 -d 10 http://localhost:8080/sentinel.php
$ docker restart redis-test-redis-sentinel-0-1 # OR $ docker restart redis-test-redis-sentinel-0-1
```



# Redis Cluster

레디스 클러스터 구성을 통해 Redis에 여러 노드를 구성하고,  
클러스터 노드 중 하나가 다운되면 데이터 유실이 발생하는지 확인합니다.

## Test Script
```bash
$ wrk -c 5 -d 10 http://localhost:8080/cluster.php
$ docker restart redis-test-redis-cluster-redis-1
```

