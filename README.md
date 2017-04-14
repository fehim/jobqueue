# Tarantool JobQueue

# Usage

```bash
./jobqueue
./jobqueue help run
```


## Running a worker

```bash
./jobqueue run <queue-name> -f worker.log -l debug -e executors.php
```


## Tests

```bash
docker run --name jobqueue -p3301:3301 -v `pwd`:/jobqueue tarantool/tarantool:1.7 tarantool /jobqueue/tests/Integration/queues.lua
vendor/bin/phpunit
```