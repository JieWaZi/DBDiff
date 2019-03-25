#!/bin/bash
server="$DATABASE_USER:$DATABASE_PASSWORD@$DATABASE_HOST:$DATABASE_PORT"
./dbdiff --server1=$server server2.test:server1.test
cd /DBDiff/migratesql
db-migrate